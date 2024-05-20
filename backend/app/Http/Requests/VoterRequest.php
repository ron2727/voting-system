<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoterRequest extends FormRequest
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
            'student_id' => ['required', 'integer', 'digits:11'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'course' => ['required', 'string'],
            'year_level' => ['required', 'string'],
            'section' => ['required', 'string'],
        ];
    }
}
