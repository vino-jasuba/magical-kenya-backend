<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Activity;

class UpdateActivityRequest extends FormRequest
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
            'catchphrase' => ["filled", "string"],
            'title' => ["filled", "string", "unique:{$database}"],
            'description' => ["filled", "string"],
        ];
    }
}
