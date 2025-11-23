<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TemplateSiswa implements FromArray, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    public function array(): array
    {
        return [
            [
                'nama' => 'Contoh Siswa',
                'jenis_kelamin' => 'Laki-laki',
                'nis' => '1234567890',
                'nisn' => '321234567890',
                'tanggal_lahir' => '11-07-2008',
                'kelas' => 'XII RPL 1',
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Jenis Kelamin',
            'NIS',
            'NISN',
            'Tanggal Lahir',
            'Kelas',
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa['nama'],
            $siswa['jenis_kelamin'],
            $siswa['nis'],
            $siswa['nisn'],
            $siswa['tanggal_lahir'],
            $siswa['kelas'],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Nama
            'B' => 15, // Jenis Kelamin
            'C' => 20, // NIS
            'D' => 20, // NISN
            'E' => 20, // Tanggal Lahir
            'F' => 20, // Kelas
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:F1')->applyFromArray([
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
            },
        ];
    }
}
