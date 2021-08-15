<?php

namespace App\Http\Services;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportService implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithHeadingRow
{
    public $exportData;
    public $dataCount;
    public $headings = [];

    public function __construct($exportData, $headings)
    {
        $this->exportData = $exportData;
        $this->headings = $headings;
        $this->dataCount = count($exportData);
    }

    public function collection()
    {
        return  $this->exportData;
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');
                $rows = count($this->exportData)+2;
                $cols = count($this->headings[1])-1;
                $cellHeaders = 'A2:'.$alpha[$cols].'2'; // All headers
                $cellBorders = 'A1:'.$alpha[$cols].''.$rows.''; // All Data

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(25);
                $event->sheet->getDelegate()->mergeCells('A1:'.$alpha[$cols].'1');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellHeaders)->getFont()->setSize(16);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellBorders)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
