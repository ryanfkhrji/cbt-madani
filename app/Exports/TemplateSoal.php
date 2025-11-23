<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TemplateSoal implements FromArray, WithTitle, WithHeadings, WithColumnWidths, WithEvents
{
    public function title(): string
    {
        return 'Template Soal';
    }

    public function headings(): array
    {
        return [
            'Ujian',
            'Kategori Soal',
            'Soal',
            'Kategori Jawaban',
            'Pilihan 1',
            'Pilihan 2',
            'Pilihan 3',
            'Pilihan 4',
            'Pilihan 5', // <- koma diperbaiki
            'Poin',
            'Jawaban Benar'
        ];
    }

    public function array(): array
    {
        return [
            [
                'UTS Semester Genap',        // Ujian
                'Text / Image',              // Kategori Soal
                'Contoh soal pilihan ganda', // Soal
                'Text / Image',              // Kategori Jawaban
                'Pilihan A / Image',
                'Pilihan B / Image',
                'Pilihan C / Image',
                'Pilihan D / Image',
                'Pilihan E / Image',         // <- sudah ada untuk Pilihan 5
                '1',                         // Poin
                '1'                          // Jawaban Benar (1 = A, 2 = B, dst.)
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Ujian
            'B' => 25, // Kategori Soal
            'C' => 50, // Soal
            'D' => 25, // Kategori Jawaban
            'E' => 20, // Pilihan 1
            'F' => 20, // Pilihan 2
            'G' => 20, // Pilihan 3
            'H' => 20, // Pilihan 4
            'I' => 20, // Pilihan 5
            'J' => 10, // Poin
            'K' => 15, // Jawaban Benar
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // sekarang sampai K (karena ada 11 kolom)
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '219ebc'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $event->sheet->getRowDimension(1)->setRowHeight(25);
            },
        ];
    }
}
