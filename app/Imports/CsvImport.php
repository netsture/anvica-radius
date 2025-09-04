<?php

namespace App\Imports;

use App\Models\Csv;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CsvImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);
        // Ensure valid date parsing
        $dob = $row['date_of_birth'];
        if (is_numeric($dob)) {
            $dob = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dob)->format('Y-m-d');
        } else {
            // $dob = \Carbon\Carbon::parse($dob)->format('Y-m-d');
            $dob = \Carbon\Carbon::createFromFormat('Y-m-d', $dob);
        }

        $billingDate = $row['billing_date'];
        if (is_numeric($billingDate)) {
            $billingDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($billingDate)->format('Y-m-d');
        } else {
            // $billingDate = \Carbon\Carbon::parse($billingDate)->format('Y-m-d');
            $billingDate = \Carbon\Carbon::createFromFormat('Y-m-d', $billingDate);
        }

        return new Csv([
            'full_name' => $row['full_name'],
            'dob' => $dob,
            'insurance_name' => $row['prim_carrier_name'],
            'subscriber_id' => $row['prim_subscriber_id'],
            'provider_full_name' => $row['provider_full_name'],
            'billing_date' => $billingDate,
            'procedure_code' => $row['procedure_code'],
            'tooth' => $row['tooth'],
            'surface' => $row['surfaces'],
            'quadrant' => $row['quadrant'],
            'cost' => $row['cost'],
        ]);
    }
}
