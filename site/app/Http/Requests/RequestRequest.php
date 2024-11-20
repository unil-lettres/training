<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
            'filling_date' => 'nullable|date',
            'status_admin' => [
                'nullable',
                Rule::in(['new', 'pending', 'resolved']),
            ],
            'type' => [
                'nullable',
                Rule::in(['training', 'analysis']),
            ],
            'contacts.*.contact' => 'nullable|max:150',
            'contacts.*.notes' => 'nullable|max:300',
            'decision_date' => 'nullable|date',
            'decision_comments' => 'nullable|min:1',
            'file' => [
                'nullable',
                // Allow all types, but max upload size is 10MB
                File::types([])
                    ->max(10 * 1024),
            ],
            'user_id' => 'nullable|integer',
            'status_id' => 'nullable|integer',
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
            'type' => 'Le type sélectionné n\'est pas valide.',
            'contacts.*.contact' => 'Le champ ne peut pas comporter plus de 150 caractères.',
            'contacts.*.notes' => 'Le champ ne peut pas comporter plus de 300 caractères.',
        ];
    }
}
