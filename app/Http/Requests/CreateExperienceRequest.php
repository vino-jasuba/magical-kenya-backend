<?php

namespace App\Http\Requests;

use App\Activity;
use App\Location;
use Illuminate\Foundation\Http\FormRequest;

class CreateExperienceRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'activity_id' => ['required', 'exists:' . (new Activity)->getTable() . ',id'],
            'location_id' => ['required', 'exists:' . (new Location)->getTable() . ',id'],
        ];
    }
}
