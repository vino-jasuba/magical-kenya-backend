<?php

namespace App\Http\Requests;

use App\Activity;
use App\Location;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
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
            'description' => ['filled', 'string'],
            'activity_id' => ['filled', 'exists:' . (new Activity)->getTable() . ',id'],
            'location_id' => ['filled', 'exists:' . (new Location)->getTable() . ',id'],
            'contact_name' => ['filled', 'string'],
            'contact_phone_number' => ['required_with:contact_name'],
        ];
    }
}
