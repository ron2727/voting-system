<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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
            'President' => 'required',
            'Vice_President' => 'required',
            'Treasurer' => 'required',
            'Secretary' => 'required', 
        ];
    }

    public function messages()
    {
        return [
            'President.required' => 'Please choose your President',
            'Vice_President.required' => 'Please choose your Vice President',
            'Treasurer.required' => 'Please choose your Treasurer',
            'Secretary.required' => 'Please choose your Secretary',
        ];
    }
}
