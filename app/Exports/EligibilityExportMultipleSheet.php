<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EligibilityExportMultipleSheet implements WithMultipleSheets
{
    protected $patientId;

    public function __construct($patientId)
    {
        $this->patientId = $patientId;
    }

    public function sheets(): array
    {
        return [
            new EligibilityFullFormSheet($this->patientId),
            new EligibilitySortFormSheet($this->patientId),
            // Add more sheets as needed
        ];
    }
}
