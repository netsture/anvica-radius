<?php
use Carbon\Carbon;
use App\Models\Option;

if (!function_exists('getOptions')) {
    function getOptions($category)
    {
        // dd(Option::where('category', $category)->pluck('value', 'key')->toArray());
        return Option::where('category', $category)->pluck('value', 'key')->toArray();
    }
}

if (!function_exists('viewDate')) {
    function viewDate($value = null)
    {
        //DATE_SEPARATOR  Define in config\constants.php
        if($value){
            return date('m'.config('constants.DATE_SEPARATOR').'d'.config('constants.DATE_SEPARATOR').'Y', strtotime($value));
        }
    }
}

if (!function_exists('setTimeFormat')) {
    function setTimeFormat($value = null)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('g:i A');
    }
}

if (!function_exists('getEligibilityFormFieldsArray')) {
    function getEligibilityFormFieldsArray()
    {
        return [
            'deductiblesArray' => [
                'deductibles' => 'Deductibles',
                'deductible_remain' => 'Deductible REMAIN',
            ],
            'requiredPreauthXrayArray' => [
                'extraction' => 'Extraction',
                'crown' => 'Crown',
                'rct' => 'RCT',
                'periodontal' => 'Periodontal',
                'denture' => 'Denture',
            ],
            'coverageArray' => [
                'diagnostic_xray' => [
                    'coverage' => 'Diagnostic - X-RAY',
                    'remarks' => false,
                ],
                'preventive' => [
                    'coverage' => 'Preventive',
                    'remarks' => false,
                ],
                'oral_facial_images' => [
                    'coverage' => 'Oral / Facial photographic images - D0350',
                    'remarks' => false,
                ],
                'basic_restorative' => [
                    'coverage' => 'Basic Restorative - D2391/Downgrade',
                    'remarks' => true,
                ],
                'major_restorative_d2950' => [
                    'coverage' => 'Major Restorative - D2950',
                    'remarks' => false,
                ],
                'major_restorative_d2740' => [
                    'coverage' => 'Major Restorative - D2740/Downgrade',
                    'remarks' => true,
                ],
                'endo' => [
                    'coverage' => 'Endo - D3310',
                    'remarks' => false,
                ],
                'perio_d4341' => [
                    'coverage' => 'Perio - D4341',
                    'remarks' => false,
                ],
                'perio_d4346' => [
                    'coverage' => 'Perio - D4346',
                    'remarks' => false,
                ],
                'perio_d4381' => [
                    'coverage' => 'Perio - D4381',
                    'remarks' => false,
                ],
                'oral_surgery' => [
                    'coverage' => 'Oral & Maxillofacial Surgery - D7210',
                    'remarks' => false,
                ],
                'bonegraft' => [
                    'coverage' => 'Bonegraft - D7953',
                    'remarks' => false,
                ],
                'prostho' => [
                    'coverage' => 'Prostho - D5110',
                    'remarks' => false,
                ],
                'implants' => [
                    'coverage' => 'Implants - D6010',
                    'remarks' => false,
                ],
                'ortho' => [
                    'coverage' => 'Ortho - D8090',
                    'remarks' => false,
                ],
                'nightguard' => [
                    'coverage' => 'Nightguard - D9944',
                    'remarks' => false,
                ],
            ],
            'examDataArray' => [
                'periodic_exam' => 'Periodic Exam - D0120',
                'comp_exam' => 'Comp. Exam - D0150',
                'consultation' => 'Consultation - D9310',
                'fac_photographic' => 'Fac. photographic images - D0350',
                'prophy' => 'Prophy - D1110, D1120',
                'bw' => 'BW - D0274',
                'fmx_pano' => 'FMX & Pano - D0210 & D0330',
                'crowns' => 'Crowns - D2740',
                'dentures' => 'Dentures - D5110',
                'nightguard' => 'Nightguard - D9944',
                'perio_srp' => 'Perio SRP - D4341',
                'd4381' => 'D4381',
                'perio_maintenance' => 'Perio Maintenance - D4910',
            ],
            'shareHistoryArray' => [
                'exam_codes' => 'D0150/D0120/D0140/D9310',
                'cleaning_codes' => 'D1110/D4910',
                'xray_codes' => 'D0210/D0330',
            ],
            'fluorideSealantsArray' => [
                'fluoride' => 'D1208, D1206',
                'sealant' => 'D1351',
                'sealant_2' => 'D1351',
            ],
            'options' => [
                'Yes' => 'Yes',
                'No' => 'No'
            ],
            
        ];
    }
}

