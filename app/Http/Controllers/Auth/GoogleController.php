<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google Callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user exists
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                $user = User::create([
                    'name'       => $googleUser->name,
                    'email'      => $googleUser->email,
                    'google_id'  => $googleUser->id,
                    'password'   => bcrypt('random_password'),
                    'is_verified_age' => false,
                ]);
            }

            Auth::login($user);

// Check age verification
if (!$user->is_verified_age) {
    return redirect()->route('age.verify');
}

// Add success message for SweetAlert
return redirect()->route('dashboard')->with('message', '🎉 Login Successfully!');


        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed.');
        }
    }
}
