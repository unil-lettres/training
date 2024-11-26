<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:150',
            'theme' => 'nullable|min:1|max:300',
            'description' => 'nullable|min:1',
            'deadline' => 'nullable|date',
            'level' => 'nullable|min:1|max:300',
            'applicants' => 'nullable|min:1|max:300',
            'contact' => 'nullable|email',
            'comments' => 'nullable|min:1',
            'doctoral_school' => 'nullable|min:1|max:300',
            'fns' => 'nullable|boolean',
            'doctoral_status' => 'nullable|min:1|max:300',
            'doctoral_level' => 'nullable|min:1|max:300',
            'tested_products' => 'nullable|min:1|max:300',
            'teachers_nbr' => 'nullable|boolean',
            'students_nbr' => 'nullable|boolean',
            'action_type' => 'nullable|boolean',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le champ nom est requis.',
        ];
    }
}
