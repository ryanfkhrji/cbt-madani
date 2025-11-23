<?php

namespace App\Imports;

use App\Models\Kategori;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Illuminate\Support\Facades\Validator;

class ImportSoal implements ToModel, WithHeadingRow
{
    private static $rowIndex = 2; // Start from 2 if there's a header
    private $supportedImageTypes = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * Process a row from the Excel file
     */
    public function model(array $row)
    {
        try {
            // Skip empty rows
            if (empty(array_filter($row, function ($value) {
                return $value !== null && $value !== '';
            }))) {
                Log::info("Skipping empty row");
                return null;
            }

            

            // Get current row number for image processing
            $currentRowNumber = self::$rowIndex++;

            // Get ujian ID
            $idUjian = $this->getUjianId($row);

            // Get kategori IDs
            $idKategoriSoal = $this->getKategoriId($row, 'kategori_soal', 'text');
            $idKategoriJawaban = $this->getKategoriId($row, 'kategori_jawaban', 'text');

            // Prepare soal data
            $soalData = [
                'id_ujian' => $idUjian,
                'id_kategori_soal' => $idKategoriSoal,
                'id_kategori_jawaban' => $idKategoriJawaban,
                'soal' => $row['soal'],
                'pilihan_1' => $row['pilihan_1'] ?? null,
                'pilihan_2' => $row['pilihan_2'] ?? null,
                'pilihan_3' => $row['pilihan_3'] ?? null,
                'pilihan_4' => $row['pilihan_4'] ?? null,
                'pilihan_5' => $row['pilihan_5'] ?? null,
                'poin' => $row['poin'] ?? 1,
                'jawaban_benar' => $row['jawaban_benar'],
            ];

            Log::info("Creating soal with data:", $soalData);

            // Create the question record
            $soal = Soal::create($soalData);

            if (!$soal) {
                throw new \Exception("Failed to create soal record");
            }

            // Process images for this row
            $this->processImagesForRow($soal, $currentRowNumber);

            return $soal;
        } catch (\Exception $e) {
            Log::error('Error importing soal at row ' . self::$rowIndex . ': ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Get ujian ID from row or use default
     */
    private function getUjianId(array $row): int
    {
        // Default to first ujian if none specified
        if (!isset($row['ujian']) || empty($row['ujian'])) {
            $ujian = Ujian::first();
            if (!$ujian) {
                throw new \Exception("No ujian found in database");
            }
            return $ujian->id;
        }

        // Find ujian by name
        $ujian = Ujian::where('nama_ujian', $row['ujian'])->first();
        if (!$ujian) {
            throw new \Exception("Ujian '{$row['ujian']}' not found");
        }

        return $ujian->id;
    }

    /**
     * Get kategori ID from row or use default
     */
    private function getKategoriId(array $row, string $field, string $defaultType): int
    {
        // Use default if not specified
        if (!isset($row[$field])) {
            $defaultKategori = Kategori::where('type', $defaultType)->first();
            if (!$defaultKategori) {
                throw new \Exception("Default kategori for type '$defaultType' not found");
            }
            return $defaultKategori->id;
        }

        // Find kategori by name
        $kategoriName = trim($row[$field]);
        $kategori = Kategori::where('type', $kategoriName)->first();

        if (!$kategori) {
            Log::warning("Kategori '$kategoriName' not found, using default");
            $defaultKategori = Kategori::where('type', $defaultType)->first();
            return $defaultKategori ? $defaultKategori->id : 1;
        }

        return $kategori->id;
    }

    /**
     * Process all images for a row
     */
    private function processImagesForRow(Soal $soal, int $rowNumber): void
    {
        try {
            if (!request()->hasFile('file')) {
                Log::warning("No Excel file available for image processing");
                return;
            }

            $spreadsheet = IOFactory::load(request()->file('file'));
            $worksheet = $spreadsheet->getActiveSheet();

            $updates = [];
            $processedImages = 0;

            // Mapping of Excel columns to database fields
            $columnMappings = [
                'soal' => 'soal',
                'pilihan 1' => 'pilihan_1',
                'pilihan 2' => 'pilihan_2',
                'pilihan 3' => 'pilihan_3',
                'pilihan 4' => 'pilihan_4',
                'pilihan 5' => 'pilihan_5',
                'pilihan1' => 'pilihan_1',
                'pilihan2' => 'pilihan_2',
                'pilihan3' => 'pilihan_3',
                'pilihan4' => 'pilihan_4',
                'pilihan5' => 'pilihan_5',
            ];

            // Process all drawings in the worksheet
            foreach ($worksheet->getDrawingCollection() as $drawing) {
                $coordinates = $drawing->getCoordinates();
                
                if (!preg_match('/([A-Z]+)(\d+)/', $coordinates, $matches)) {
                    Log::warning("Invalid drawing coordinates: $coordinates");
                    continue;
                }

                $column = $matches[1];
                $drawingRowNumber = (int) $matches[2];

                // Only process drawings for the current row
                if ($drawingRowNumber !== $rowNumber) {
                    continue;
                }

                Log::info("Processing image at $coordinates for row $rowNumber");

                // Get image content and extension
                $imageContents = null;
                $extension = null;

                if ($drawing instanceof MemoryDrawing) {
                    ob_start();
                    call_user_func(
                        $drawing->getRenderingFunction(),
                        $drawing->getImageResource()
                    );
                    $imageContents = ob_get_contents();
                    ob_end_clean();

                    switch ($drawing->getMimeType()) {
                        case MemoryDrawing::MIMETYPE_PNG:
                            $extension = 'png';
                            break;
                        case MemoryDrawing::MIMETYPE_GIF:
                            $extension = 'gif';
                            break;
                        case MemoryDrawing::MIMETYPE_JPEG:
                            $extension = 'jpg';
                            break;
                        default:
                            Log::warning("Unsupported memory drawing type: " . $drawing->getMimeType());
                            continue 2;
                    }
                } else {
                    $zipReader = fopen($drawing->getPath(), 'rb');
                    if (!$zipReader) {
                        Log::warning("Failed to open drawing file");
                        continue;
                    }
                    
                    $imageContents = '';
                    while (!feof($zipReader)) {
                        $imageContents .= fread($zipReader, 1024);
                    }
                    fclose($zipReader);
                    $extension = strtolower($drawing->getExtension());
                }

                // Validate image type
                if (!in_array($extension, $this->supportedImageTypes)) {
                    Log::warning("Unsupported image type: $extension");
                    continue;
                }

                // Determine which field this image belongs to
                $columnIndex = Coordinate::columnIndexFromString($column);
                $headerValue = strtolower(trim($worksheet->getCellByColumnAndRow($columnIndex, 1)->getValue() ?? ''));

                $fieldName = null;
                foreach ($columnMappings as $excelColumn => $dbField) {
                    if (str_replace(['_', ' '], '', $headerValue) === str_replace(['_', ' '], '', $excelColumn)) {
                        $fieldName = $dbField;
                        break;
                    }
                }

                if (!$fieldName) {
                    Log::warning("Could not determine field for column $column with header '$headerValue'");
                    continue;
                }

                Log::info("Assigning image to field: $fieldName");

                // Determine storage directory based on field type
                $directory = $fieldName === 'soal' ? 'soal_images' : 'pilihan_images';
                $storagePath = "public/{$directory}/";

                // Generate unique filename
                $fileName = 'row_' . $rowNumber . '_' . $fieldName . '_' . uniqid() . '.' . $extension;

                // Store the image file
                if (Storage::put($storagePath . $fileName, $imageContents)) {
                    // Get the public URL path
                    $relativePath = "{$directory}/{$fileName}";
                    $updates[$fieldName] = $relativePath;
                    $processedImages++;
                    Log::info("Saved image to storage: $relativePath");
                } else {
                    Log::error("Failed to save image to storage: {$storagePath}{$fileName}");
                }
            }

            // Update the record with image paths if any were found
            if (!empty($updates)) {
                if ($soal->update($updates)) {
                    Log::info("Successfully updated $processedImages images for soal ID: {$soal->id}");
                } else {
                    Log::error("Failed to update images for soal ID: {$soal->id}");
                }
            } else {
                Log::info("No images found for row $rowNumber");
            }
        } catch (\Exception $e) {
            Log::error('Error processing images for row ' . $rowNumber . ': ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}