<?php

namespace App\Exports;

use App\Models\Csv;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CsvExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Csv::all();
    }

    public function headings(): array
    {
        return ["ID", "fullname", "dob"];
    }
}
