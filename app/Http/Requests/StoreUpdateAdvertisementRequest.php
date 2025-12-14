<?php

namespace App\Http\Requests;

use App\Models\Advertisement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateAdvertisementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'           => ['required', 'string', 'max:255'],
            'page_section'    => ['required'],
            // 'image'           => ['required', 'image', 'mimes:jpg,jpeg,png,gif,mp4,mov,webm,webp,avif', 'max:5120'], // 5MB
            'media'           => ['required', 'file', 'mimes:jpg,jpeg,png,gif,mp4,mov,webm,webp,avif', 'max:5120'], // 5MB
            'click_url'       => ['nullable', 'url', 'max:2048'],
            'start_at'        => ['nullable', 'date'],
            'end_at'          => ['nullable', 'date', 'after:start_at'],
            'time_slot'       => ['required'],
            'weekdays'        => ['nullable', 'array'],
            'weekdays.*'      => ['in:' . implode(',', $this->weekdayOptions)],
            'priority'        => ['nullable', 'integer', 'min:1', 'max:1000'],
            'max_impressions' => ['nullable', 'integer', 'min:1'],
            'max_clicks'      => ['nullable', 'integer', 'min:1'],
            'country'         => ['nullable', 'string', 'max:100'],
            'state'           => ['nullable', 'string', 'max:100'],
            'city'            => ['nullable', 'string', 'max:100'],
            'zone'            => ['nullable', 'string', 'max:100'],
            'area'            => ['nullable', 'string', 'max:100'],
            'society'         => ['nullable', 'string', 'max:150'],
            'status'         =>  ['required'],
        ];
    }
}
