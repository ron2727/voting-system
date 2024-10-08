<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElectionUpdateRequest extends FormRequest
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
            'title' => ['required', 'max:100'],
            'description' => ['required', 'max:255'], 
        ];
    }

    public function messages(): array
    {
        return [ 
            'title.required' => 'Please enter the title of the election',
            'description.required' => 'Please enter the description of the election', 
        ];
    }
 
}
