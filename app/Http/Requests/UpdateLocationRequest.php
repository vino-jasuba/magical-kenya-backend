<?php

namespace App\Http\Requests;

use App\Location;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
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
            'name' => ['filled', 'string', 'unique:' . (new Location)->getTable()],
            'description' => ['filled', 'string'],
            'icon' => ['filled', 'string'],
            'catchphrase' => ['filled', 'string'],
            'color_tag' => ['filled', 'string', 'starts_with:#', 'min:4'],
            'lat' => ['filled', 'gte:-90', 'lte:90'],
            'lng' => ['filled', 'gte:-180', 'lte:180'],
        ];
    }
}