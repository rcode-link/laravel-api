<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterApiRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'email' => ['email', 'required'],
            'password' => [
        'required',
        'string',
        'min:8',
        'regex:/[A-Z]/',
        'regex:/[0-9]/',
        'regex:/[@$!%*#?_&]/'
    ]
        ];
    }
}
