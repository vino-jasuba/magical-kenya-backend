<?php

namespace App\Http\Requests;

use App\Activity;
use Illuminate\Foundation\Http\FormRequest;

class CreateActivityRequest extends FormRequest
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
        $database = (new Activity)->getTable();

        return [
            'catchphrase' => ["required", "string"],
            'title' => ["required", "string", "unique:{$database}"],
            'description' => ["required", "string"],
        ];
    }
}
