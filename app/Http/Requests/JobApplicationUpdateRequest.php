<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class jobApplicationUpdateRequest extends FormRequest
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
            'status' => 'required|string|in:pending,accepted,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'The application status is required.',
            'status.string' => 'The application status must be a string.',
            'status.in' => 'The selected application status is invalid.',
        ];
    }
}
