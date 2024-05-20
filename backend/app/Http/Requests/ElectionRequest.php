<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ElectionRequest extends FormRequest
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
            'start_date' => ['required','date_format:Y-m-d H:i'],
            'end_date' => ['required','date_format:Y-m-d H:i','after:start_date'],
        ];
    }

    public function messages(): array
    {
        return [ 
            'title.required' => 'Please enter the title of the election',
            'description.required' => 'Please enter the description of the election',
            'start_date.required' => 'Please select where the election will start',
            'end_date.required' => 'Please select where the election will end',
            'end_date.after' => 'The end date must be after the start date',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $startDatetime = $this->input('start_date');
            $endDatetime = $this->input('end_date');

            if (strtotime($startDatetime) >= strtotime($endDatetime)) {
                $validator->errors()->add('end_date', 'The end date and time must be after the start date and time.');
            }
        });
    }
}
