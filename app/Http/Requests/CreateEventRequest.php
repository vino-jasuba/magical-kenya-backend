<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => ['required', 'date_format:Y/m/d H/m/s'],
            'end_date' => ['required', 'date_format:Y/m/d H/m/s'],
            'external_url' => ['required', 'string'],
            'title' => ['required', 'string'],
        ];
    }
}
