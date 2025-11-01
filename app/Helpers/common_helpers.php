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
            return date('d'.config('constants.DATE_SEPARATOR').'m'.config('constants.DATE_SEPARATOR').'Y', strtotime($value));
        }
    }
}

if (!function_exists('viewDateTime')) {
    function viewDateTime($value = null)
    {
        if($value){
            return date('d'.config('constants.DATE_SEPARATOR').'m'.config('constants.DATE_SEPARATOR').'Y H:i:s', strtotime($value));
        }
    }
}

if (!function_exists('setTimeFormat')) {
    function setTimeFormat($value = null)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('g:i A');
    }
}



