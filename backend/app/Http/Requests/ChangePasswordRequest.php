<?php

namespace App\Http\Requests;

use App\Models\User;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) { 
                    $voter = User::find($this->voter_id);
                    if (!Hash::check($value, $voter->password)) {
                        $fail($value);
                    }
                },
            ],
            'new_password' => ['required','min:8','confirmed'],
        ];
    }
}
