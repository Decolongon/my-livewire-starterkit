<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'     => [
                'required',
                'string',
                'max:100',
                'min:3'
            ],
            'email'    => [
                'required',
                'email',
                'unique:users,email',
                'lowercase'
            ],
            'password' => [
                'required',
                'min:8',
                'confirmed'
            ],
            'captcha'  => [
                'required',
                'captcha'
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ],
        ];
    }
}
