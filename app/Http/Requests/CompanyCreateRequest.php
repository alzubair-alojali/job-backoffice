<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:companies,name',
            'industry' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|string|url|max:255',

            //owner valadtion
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|string|email|max:255|unique:users,email',
            'owner_password' => 'required|string|min:8|max:255',
            
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 255 characters.',
            'name.unique' => 'The category name has already been taken.',
            'industry.required' => 'The industry is required.',
            'industry.string' => 'The industry must be a string.',
            'industry.max' => 'The industry may not be greater than 255 characters.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address may not be greater than 500 characters.',
            'website.url' => 'The website must be a valid URL.',
            'website.max' => 'The website may not be greater than 255 characters.',
            'website.string' => 'The website must be a string.',

            //owner messages
            'owner_name.required' => 'The owner name is required.',
            'owner_name.string' => 'The owner name must be a string.',
            'owner_name.max' => 'The owner name may not be greater than 255 characters.',
            'owner_email.required' => 'The owner email is required.',
            'owner_email.string' => 'The owner email must be a string.',
            'owner_email.email' => 'The owner email must be a valid email address.',
            'owner_email.max' => 'The owner email may not be greater than 255 characters.',
            'owner_password.required' => 'The owner password is required.',
            'owner_password.string' => 'The owner password must be a string.',
            'owner_password.min' => 'The owner password must be at least 8 characters.',
            'owner_password.max' => 'The owner password may not be greater than 255 characters.',
        ];
    }
}
