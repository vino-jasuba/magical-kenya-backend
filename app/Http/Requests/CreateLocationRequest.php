<?php

namespace App\Http\Requests;

use App\Location;
use Illuminate\Foundation\Http\FormRequest;

class CreateLocationRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:' . (new Location)->getTable()],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'catchphrase' => ['required', 'string'],
            'color_tag' => ['required', 'string', 'starts_with:#', 'min:4'],
            'lat' => ['required', 'gte:-90', 'lte:90'],
            'lng' => ['required', 'gte:-180', 'lte:180'],
        ];
    }
}
