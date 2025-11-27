<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                $user = User::create([
                    'name'            => $googleUser->name,
                    'email'           => $googleUser->email,
                    'google_id'       => $googleUser->id,
                    'password'        => bcrypt('random_password'),
                    'role'            => 1, // default user
                    'is_verified_age' => false,
                ]);
            }

            Auth::login($user);

            // Age verification
            if (!$user->is_verified_age) {
                return redirect()->route('age.verify');
            }

            // Redirect by role
            if ($user->role == 0) {
                return redirect()->route('admin.dashboard')->with('message', '🎉 Welcome Admin!');
            } else {
                return redirect()->route('dashboard')->with('message', '🎉 Welcome!');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed.');
        }
    }
}
