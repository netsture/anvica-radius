<?php

namespace App\Exports;

use App\Models\Eligibility;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Style;

class EligibilitySortFormSheet implements FromView, WithColumnWidths, WithStyles
{
    protected $patientId;

    public function __construct($patientId)
    {
        $this->patientId = $patientId;
    }

    // ✅ Set column width (first column "A" to 20 width)
    public function columnWidths(): array
    {
        return [
            'A' => 20, // Set width of first column
            'B' => 10, // Set width of first column
            'C' => 20, // Set width of first column
            'D' => 10, // Set width of first column
            'E' => 10, // Set width of first column
            'F' => 10, // Set width of first column
            'G' => 20, // Set width of first column
            'H' => 50, // Set width of first column
        ];
    }

    // ✅ Apply Borders to All Rows & Columns
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $cellRange = 'A1:' . $highestColumn . $highestRow;
        $sheet->getStyle($cellRange)->applyFromArray([
            'font' => [
                'name' => 'Arial',   // Font family
                'size' => 9,         // Font size
                'bold' => true,
            ],
            'alignment' => [
                'wrapText' => true,
            ],
        ]);

        // Apply borders to A-D
        $sheet->getStyle('A1:D' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ],
        ]);

        // Apply borders to G onward
        $sheet->getStyle('G1:' . $sheet->getHighestColumn() . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ],
        ]);

        $sheet->getStyle('G23:I31')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                ],
            ],            
        ]);

        // $sheet->getStyle('A1:A' . $highestRow)->getFont()
            // ->setName('Arial')
            // ->setSize(9)
            // ->setBold(true);
    }

    public function view(): View
    {

        return view('eligibilities.export-sort-form', [
            'eligibilities' => Eligibility::with('patient')->where('patient_id', $this->patientId)->get()
        ]);
    }

}
