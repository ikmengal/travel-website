<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group' => [
                'required',
                'string',
                'max:100',
            ],
            'key' => [
                'required',
                'string',
                'max:255',
            ],
            'value' => [
                'nullable',
            ],
            'type' => [
                'required',
                'in:text,textarea,number,email,url,image,boolean,json,password',
            ],
            'autoload' => [
                'nullable',
                'boolean',
            ],
            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
