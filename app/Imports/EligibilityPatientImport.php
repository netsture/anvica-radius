<?php

namespace App\Imports;

use App\Models\TempEligibilityPatient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class EligibilityPatientImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Ensure valid date parsing
        $dob = $row['date_of_birth'];
        if (is_numeric($dob)) {
            $dob = Date::excelToDateTimeObject($dob)->format('Y-m-d');
        } else {
            // $dob = Carbon::parse($dob)->format('Y-m-d');
            // $dob = Carbon::createFromFormat('Y-m-d', $dob);
            try {
                // Try parsing with flexible format detection
                $dob = Carbon::parse($dob)->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    // Try strict format if parse fails
                    $dob = Carbon::createFromFormat('Y-m-d', $dob)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Handle invalid date format (optional)
                    $dob = null; // or throw exception / log error
                }
            }
        }

        $appt_date = $row['appt_date'];
        if (is_numeric($appt_date)) {
            $appt_date = Date::excelToDateTimeObject($appt_date)->format('Y-m-d');
        } else {
            // $appt_date = Carbon::parse($appt_date)->format('Y-m-d');
            // $appt_date = Carbon::createFromFormat('Y-m-d', $appt_date);
            try {
                // Try parsing with flexible format detection
                $appt_date = Carbon::parse($appt_date)->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    // Try strict format if parse fails
                    $appt_date = Carbon::createFromFormat('Y-m-d', $appt_date)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Handle invalid date format (optional)
                    $appt_date = null; // or throw exception / log error
                }
            }
        }

        $appt_time = $row['appt_time'];
        if (is_numeric($appt_time)) {
            $appt_time = Carbon::instance(Date::excelToDateTimeObject($appt_time))->format('g:i A');
        } else {
            $appt_time = Carbon::createFromFormat('g:i A', $appt_time)->format('g:i A');
        }

        return new TempEligibilityPatient([
            'clinic' => $row['clinic'],
            'appt_provider' => $row['appt_provider'],
            'appt_date' => $appt_date,
            'appt_time' => $appt_time,
            'full_name' => $row['full_name'] ?? '',
            'date_of_birth' => $dob,
            'prim_subscriber' => $row['prim_subscriber'] ?? '',
            'prim_carrier_name' => $row['prim_carrier_name'] ?? '',
            'prim_subscriber_id' => $row['prim_subscriber_id'] ?? '',
            'sec_carrier_name' => $row['sec_carrier_name'] ?? '',
            'sec_subscriber_id' => $row['sec_subscriber_id'] ?? '',
            
            
        ]);
    }
}
