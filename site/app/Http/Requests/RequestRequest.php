<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
            'status' => [
                'nullable',
                Rule::in(['new', 'pending', 'resolved']),
            ],
            'decision_date' => 'nullable|date',
            'decision_comments' => 'nullable|min:1',
            'file' => 'nullable|file',
            'user_id' => 'required|integer',
            'type_id' => 'nullable|integer',
            'status_id' => 'nullable|integer',
            'doctoral_school' => 'nullable|min:1|max:300',
            'fns' => 'nullable|boolean',
            'doctoral_status' => 'nullable|min:1|max:300',
            'doctoral_level' => 'nullable|min:1|max:300',
            'tested_products' => 'nullable|min:1|max:300',
            'teachers_nbr' => 'nullable|boolean',
            'students_nbr' => 'nullable|boolean',
            'action_type' => 'nullable|boolean'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
