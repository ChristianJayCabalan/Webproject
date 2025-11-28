<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user) {
                return back()->with('error', 'Authentication failed');
            }

            // Merge session cart into database cart before logging in
            if (session()->has('cart')) {
                try {
                    $sessionCart = session()->get('cart', []);
                    foreach ($sessionCart as $productId => $item) {
                        \App\Models\Cart::updateOrCreate(
                            ['user_id' => Auth::id(), 'product_id' => $productId],
                            ['quantity' => DB::raw("quantity + {$item['quantity']}")]
                        );
                    }
                    session()->forget('cart');
                } catch (\Exception $e) {
                    Log::error('Cart merge error: ' . $e->getMessage());
                }
            }

            // Age verification check
            if (!$user->is_verified_age) {
                return redirect()->route('age.verify');
            }

            // Redirect by role
            if ($user->role == 0) {
                return redirect()->route('admin.dashboard')->with('message', 'Welcome Admin!');
            } else {
                return redirect()->route('dashboard')->with('message', 'Welcome!');
            }
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during login. Please try again.');
        }
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully logged out!');
    }
}
