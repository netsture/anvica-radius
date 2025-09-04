<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Imports\EligibilityPatientImport;
use App\Models\Csv;
use App\Models\TempEligibilityPatient;
use App\Models\Patient;
use App\Models\Insurance;
use App\Models\Provider;
use App\Models\Office;
use App\Models\Procedure;
use App\Models\Appointment;
use App\Models\EligibilityPatient;


class ImportController extends Controller
{
    public function index()
    {
        $csvs = Csv::get();
        return view('import.index', compact('csvs'));
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        TempEligibilityPatient::truncate();
        
        // Excel::import(new CsvImport,request()->file('file'));
        Excel::import(new EligibilityPatientImport,request()->file('file'));
        // return redirect()->back()->with('success', 'Records imported successfully!');
        return redirect()->route('import.appt.data.verify')->with('success', 'Records imported successfully!');
    }

    public function apptDataVerify()
    {
        $csvs = TempEligibilityPatient::get();
        return view('import.verify_appt_data', compact('csvs'));
    }

    public function apptDataSave(Request $request) 
    {
        $csvs = TempEligibilityPatient::get();
        // dd($csvs);
        foreach ($csvs as $csv) {
            // dd($csv);
            // Parse patient and provider names
            $patientNameParts = $this->parsePatientFullName($csv->full_name);
            $providerNameParts = $this->parseProviderFullName($csv->appt_provider);

            // Check and create patient
            if (!empty($patientNameParts['first_name'])) {
                $patient = Patient::firstOrCreate(
                    [
                        'first_name' => $patientNameParts['first_name'],
                        'last_name' => $patientNameParts['last_name'],
                        'dob' => $csv->date_of_birth,
                    ],
                    [
                        'middle_name' => $patientNameParts['middle_name'],
                        'gender' => $csv->gender ?? null,
                        'email' => $csv->email ?? null,
                        'cell_phone' => $csv->cell_phone ?? null,
                        'responsible_party' => $csv->responsible_party ?? null,
                        'preferred_clinic' => $csv->preferred_clinic ?? null,
                        'fee_schedule' => $csv->fee_schedule ?? null,
                        'created_by' => auth()->id(),
                    ]
                );
            }
            // Check and create provider
            if (!empty($csv->clinic)) {
                $office = Office::firstOrCreate(
                    [
                        'name' => $csv->clinic,
                    ],
                    ['created_by' => auth()->id()]
                );
            }
            // Check and create provider
            if (!empty($providerNameParts['first_name'])) {
                $provider = Provider::firstOrCreate(
                    [
                        'first_name' => $providerNameParts['first_name'],
                        'last_name' => $providerNameParts['last_name'],
                    ],
                    ['created_by' => auth()->id()]
                );
            }

            // Check and create insurance
            $primary_insurance = [];
            if (!empty($csv->prim_carrier_name)) {
                $primary_insurance = Insurance::firstOrCreate(
                    ['name' => $csv->prim_carrier_name],
                    ['created_by' => auth()->id()]
                );
            }
            $secondary_insurance = [];
            if (!empty($csv->sec_carrier_name)) {
                $secondary_insurance = Insurance::firstOrCreate(
                    ['name' => $csv->sec_carrier_name],
                    ['created_by' => auth()->id()]
                );
            }
            $apptTime24Hour = Carbon::createFromFormat('h:i A', $csv->appt_time)->format('H:i');
            if (!empty($patientNameParts['first_name']) && !empty($patient->id) && !empty($office->id) && !empty($provider->id)) {
                $appointment = Appointment::firstOrCreate(
                    [
                        'patient_id' => $patient->id,
                        'office_id' => $office->id,
                        'provider_id' => $provider->id,
                        'appt_date' => $csv->appt_date,
                        'appt_time' => $apptTime24Hour,
                    ],
                    [
                        'created_by' => auth()->id()
                    ]
                );
            }

            if (!empty($patientNameParts['first_name']) && !empty($patient->id) && !empty($office->id) && !empty($provider->id)) {
                $appointment = EligibilityPatient::firstOrCreate(
                    [
                        'patient_id' => $patient->id,
                        'office_id' => $office->id,
                        'provider_id' => $provider->id,
                        'primary_insurance_id' => $primary_insurance->id ?? '0',
                        'secondary_insurance_id' => $secondary_insurance->id ?? '0',
                        'appt_date' => $csv->appt_date,
                        'appt_time' => $apptTime24Hour,                    
                    ],
                    [
                        'prim_subscriber' => $csv->prim_subscriber,
                        'prim_carrier_name' => $csv->prim_carrier_name,
                        'prim_subscriber_id' => $csv->prim_subscriber_id,
                        'sec_carrier_name' => $csv->sec_carrier_name,
                        'sec_subscriber_id' => $csv->sec_subscriber_id,
                        'created_by' => auth()->id()
                    ]
                );
            }

            
        }

        return redirect()->route('eligibilities.index')->with('success', 'Records imported successfully!');
    }


    public function saveSample(Request $request) 
    {
        $csvs = Csv::get();
        // dd($csvs);
        foreach ($csvs as $csv) {
            // Parse patient and provider names
            $patientNameParts = $this->parsePatientFullName($csv->full_name);
            $providerNameParts = $this->parseProviderFullName($csv->appt_provider);

            // Check and create patient
            $patient = Patient::firstOrCreate(
                [
                    'first_name' => $patientNameParts['first_name'],
                    'last_name' => $patientNameParts['last_name'],
                    'dob' => $csv->dob,
                ],
                [
                    'middle_name' => $patientNameParts['middle_name'],
                    'gender' => $csv->gender ?? null,
                    'email' => $csv->email ?? null,
                    'cell_phone' => $csv->cell_phone ?? null,
                    'responsible_party' => $csv->responsible_party ?? null,
                    'preferred_clinic' => $csv->preferred_clinic ?? null,
                    'fee_schedule' => $csv->fee_schedule ?? null,
                    'created_by' => auth()->id(),
                ]
            );

            // Check and create insurance
            $insurance = Insurance::firstOrCreate(
                ['name' => $csv->insurance_name],
                ['created_by' => auth()->id()]
            );

            // Check and create provider
            $provider = Provider::firstOrCreate(
                [
                    'first_name' => $providerNameParts['first_name'],
                    'last_name' => $providerNameParts['last_name'],
                ],
                ['created_by' => auth()->id()]
            );

            $amount = preg_replace('/[^0-9.]/', '', $csv->cost);

            // Insert data into procedures table
            $procedure = Procedure::firstOrCreate(
                [
                    'patient_id' => $patient->id,
                    'insurance_id' => $insurance->id,
                    'provider_id' => $provider->id,
                    'dos' => $csv->billing_date,
                    'procedure_code' => $csv->procedure_code,
                    'tooth' => $csv->tooth,
                    'surface' => $csv->surface,
                    'quadrant' => $csv->quadrant,
                    'amount' => $amount,
                ],
                ['created_by' => auth()->id()]
            );

            
        }

        return redirect()->route('patients.index')->with('success', 'Records imported successfully!');
    }

    public function save2(Request $request) 
    {
        $csvs = Csv::get();
        // dd($csvs);
        foreach ($csvs as $csv) {
            $patientNameParts = $this->parsePatientFullName($csv->full_name);
            $providerNameParts = $this->parseProviderFullName($csv->provider_full_name);

            $exists = Patient::where('first_name', $patientNameParts['first_name'])
                ->where('last_name', $patientNameParts['last_name'])
                ->where('dob', $csv->dob)
                ->exists();
            if (!$exists) {                
                Patient::create([
                    'first_name' => $patientNameParts['first_name'],
                    'middle_name' => $patientNameParts['middle_name'],
                    'last_name' => $patientNameParts['last_name'],
                    'dob' => $csv->dob,
                    'gender' => $csv->gender ?? null,
                    'email' => $csv->email ?? null,
                    'cell_phone' => $csv->cell_phone ?? null,
                    'responsible_party' => $csv->responsible_party ?? null,
                    'preferred_clinic' => $csv->preferred_clinic ?? null,
                    'fee_schedule' => $csv->fee_schedule ?? null,
                    'created_by' => auth()->id(),
                ]);
            }

            $exists_insurance = Insurance::where('name', $csv->insurance_name)->exists();
            if (!$exists_insurance) {                
                Insurance::create([
                    'name' => $csv->insurance_name,
                    'created_by' => auth()->id(),
                ]);
            }

            $exists_provider = Provider::where('first_name', $providerNameParts['first_name'])
                ->where('last_name', $providerNameParts['last_name'])
                ->exists();
            if (!$exists_provider) {
                Provider::create([
                    'first_name' => $providerNameParts['first_name'],
                    'last_name' => $providerNameParts['last_name'],
                    'created_by' => auth()->id(),
                ]);
            }

        }

        return redirect()->route('patients.index')->with('success', 'Records imported successfully!');
    }

    private function parsePatientFullName($fullName)
    {
        $parts = explode(',', $fullName);

        // Last name is the part before the comma
        $lastName = trim($parts[0]);

        // First name and middle name (if any) are the part after the comma
        $firstName = '';
        $middleName = '';
        if (isset($parts[1])) {
            $names = explode(' ', trim($parts[1]));
            $firstName = $names[0] ?? '';
            $middleName = $names[1] ?? ''; // If there's a middle name
        }

        return [
            'last_name' => $lastName,
            'first_name' => $firstName,
            'middle_name' => $middleName,
        ];
    }

    private function parseProviderFullName($fullName)
    {
        $nameParts = explode(' ', $fullName);

        // First name is the first part
        $firstName = $nameParts[0];

        // Last name is everything after the first part
        $lastName = implode(' ', array_slice($nameParts, 1));

        return [
            'last_name' => $lastName,
            'first_name' => $firstName,
        ];
    }
}
