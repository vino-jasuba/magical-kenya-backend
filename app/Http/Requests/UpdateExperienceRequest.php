<?php

namespace App\Http\Requests;

use App\Activity;
use App\Location;
use App\TouristExperience;
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
        $activityTable = (new Activity)->getTable();
        $locationTable = (new Location)->getTable();
        $experiencesTable = (new TouristExperience)->getTable();

        return [
            'description' => ['filled', 'string'],
            'activity_id' => [
                'filled',
                'exists:' . $activityTable . ',id',
                "unique:{$experiencesTable},activity_id,NULL,id,location_id," . request()->location_id
            ],
            'location_id' => [
                'filled',
                'exists:' . $locationTable . ',id',
                "unique:{$experiencesTable},location_id,NULL,id,activity_id," . request()->activity_id
            ],
            'contact_name' => ['filled', 'string'],
            'contact_phone_number' => ['required_with:contact_name'],
        ];
    }
}
