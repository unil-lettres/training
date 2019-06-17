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
            'name' => 'required|min:1|max:100',
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
            'file' => 'nullable|file'
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
