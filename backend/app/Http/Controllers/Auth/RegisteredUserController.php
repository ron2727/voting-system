<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): Response
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);
          
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return response()->noContent();
    // }
    public function store(Request $request): Response
    {
        $request->validate([
            'student_id' => ['required', 'integer', 'digits:11'], 
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('student_id', $request->student_id)->first();
        
        if ($user && empty($user->password)) {
            User::where('student_id', $request->student_id)
                    ->update(['password' => Hash::make($request->password)]); 

            event(new Registered($user));

            Auth::login($user);
        }elseif (!$user) {
            throw ValidationException::withMessages([
                'student_id' => "Please register your id first to administrator",
            ]);
        }
        else{
            throw ValidationException::withMessages([
                'student_id' => "Account already exist",
            ]);
        }

        return response()->noContent();
    }
}
