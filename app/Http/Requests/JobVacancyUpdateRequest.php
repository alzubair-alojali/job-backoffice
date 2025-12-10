<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
             'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|string|in:Full-time,Contract,Remote,Hybrid',
            'description' => 'required|string',
            'required_skills' => 'string',
            'company_id' => 'required|exists:companies,id',
            'job_category_id' => 'required|exists:job_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'title.string' => 'The job title must be a string.',
            'title.max' => 'The job title may not be greater than 255 characters.',
            'location.required' => 'The job location is required.',
            'location.string' => 'The job location must be a string.',
            'location.max' => 'The job location may not be greater than 255 characters.',
            'salary.required' => 'The salary is required.',
            'salary.numeric' => 'The salary must be a number.',
            'salary.min' => 'The salary must be at least 0.',
            'type.required' => 'The job type is required.',
            'type.string' => 'The job type must be a string.',
            'type.in' => 'The selected job type is invalid.',
            'description.required' => 'The job description is required.',
            'description.string' => 'The job description must be a string.',
            'required_skills.string' => 'The required skills must be a string.',
            'company_id.required' => 'The company is required.',
            'company_id.exists' => 'The selected company is invalid.',
            'job_category_id.required' => 'The job category is required.',
            'job_category_id.exists' => 'The selected job category is invalid.',
        ];
    }
}
