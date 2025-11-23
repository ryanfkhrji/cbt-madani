<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HasilUjian implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithCustomStartCell
{
    protected Collection $items;
    protected array $meta; // ['kelas' => 'X RPL 1', 'ujian' => 'PTS Ganjil', 'tanggal' => '05-09-2025']

    public function __construct(Collection $items, array $meta = [])
    {
        $this->items = $items;
        $this->meta  = $meta;
    }

    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Ujian',
            'Jumlah Soal',
            'Jumlah Benar',
            'Jumlah Salah',
            'Nilai',
        ];
    }

    public function map($row): array
    {
        return [
            $row->no ?? null,
            $row->nis,
            $row->nama,
            $row->nama_kelas,
            $row->nama_ujian,
            $row->jum_soal,
            $row->benar,
            $row->salah,
            $row->score,
        ];
    }

    /**
     * Mulai tabel (headings) di A5 agar A1–A3 bisa dipakai untuk header informasi.
     */
    public function startCell(): string
    {
        return 'A5';
    }

    /**
     * Style untuk baris header tabel (baris 5 setelah startCell).
     */
    public function styles(Worksheet $sheet)
    {
        return [
            5 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'],
                ],
            ],
        ];
    }

    /**
     * Tulis header informasi (judul + keterangan) dan kasih border untuk seluruh area.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Hitung kolom terakhir berdasar jumlah headings
                $lastColIndex  = count($this->headings()); // 9 kolom
                $lastColLetter = Coordinate::stringFromColumnIndex($lastColIndex);

                // ==== Header Informasi (baris 1–3) ====
                // Baris 1: Judul
                $title = 'REKAP HASIL UJIAN';
                $sheet->setCellValue("A1", $title);
                $sheet->mergeCells("A1:{$lastColLetter}1");
                $sheet->getStyle("A1")->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Baris 2: Kelas & Ujian
                $kelas = $this->meta['kelas']  ?? '-';
                $ujian = $this->meta['ujian']  ?? '-';
                $sheet->setCellValue("A2", "KELAS: {$kelas}    |    UJIAN: {$ujian}");
                $sheet->mergeCells("A2:{$lastColLetter}2");
                $sheet->getStyle("A2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Baris 3: Tanggal
                $tanggal = $this->meta['tanggal'] ?? date('d-m-Y');
                $sheet->setCellValue("A3", "TANGGAL: {$tanggal}");
                $sheet->mergeCells("A3:{$lastColLetter}3");
                $sheet->getStyle("A3")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Sedikit spasi sebelum tabel
                $sheet->getRowDimension(4)->setRowHeight(6);

                // ==== Border untuk seluruh area (header info + tabel data) ====
                $highestRow = $sheet->getHighestRow(); // termasuk data
                $fullRange  = "A1:{$lastColLetter}{$highestRow}";
                $sheet->getStyle($fullRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Bold label "Kelas", "Ujian", "Tanggal" (opsional)
                $sheet->getStyle("A2:A3")->getFont()->setBold(true);

                // Freeze pane di baris 6 (supaya header tabel selalu terlihat)
                $sheet->freezePane("A6");
            },
        ];
    }
}
