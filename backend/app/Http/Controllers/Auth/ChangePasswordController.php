<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    public function store (Request $request)
    {

        // Validate the request
        $request->validate([
            'current_password' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) { 
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail("Incorrect password");
                    }
                },
            ],
            'new_password' => ['required','min:8','confirmed', Password::defaults()],
        ]);
 

        // Update the user's password
        User::find(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]); 

        return response()->json(['success', 'Password changed successfully.']); 
    }
}
