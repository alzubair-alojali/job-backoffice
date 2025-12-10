<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'password' => 'required|string|min:8|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'password.required' => 'The user password is required.',
            'password.string' => 'The user password must be a string.',
            'password.min' => 'The user password must be at least 8 characters.',
            'password.max' => 'The user password may not be greater than 255 characters.',
        ];
    }
}
