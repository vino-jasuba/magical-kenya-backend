<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MediaUploadRequest extends FormRequest
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
        $targetTypes = array_keys(config('magical_kenya.model_mappings'));
        return [
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file', 'max:6120', 'mimetypes:image/png,image/jpeg,image/jpg,video/mkv,video/mp4'],
            'description' => ['required', 'array'],
            'description.*' => ['nullable', 'string'],
            'target_type' => ['required', 'string', Rule::in($targetTypes)],
            'target_key' => ['required'],
            'use_case' => ['required', Rule::in(['background', 'carousel'])],
        ];
    }
}
