<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Display the default customer login view.
     */
    public function create()
    {
        return view('auth.login', ['loginType' => 'customer']);
    }

    /**
     * Display the seller login view.
     */
    public function createSeller()
    {
        return view('auth.login', ['loginType' => 'seller']);
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin()
    {
        return view('auth.login', ['loginType' => 'admin']);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'login_type' => ['nullable', 'string'],
        ]);

        $loginType = $request->input('login_type', 'customer');
        $credentials = Arr::only($validated, ['email', 'password']);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($loginType === 'admin' && !$user->isAdmin()) {
                Auth::logout();
                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'Please sign in with an admin account for this portal.'])
                    ->onlyInput('email');
            }

            if ($loginType === 'seller' && !$user->isSeller()) {
                Auth::logout();
                return redirect()->route('seller.login')
                    ->withErrors(['email' => 'Please sign in with a seller account for this portal.'])
                    ->onlyInput('email');
            }

            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }

            if ($user->isSeller()) {
                return redirect()->intended('/seller/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Display the registration view.
     */
    public function registerView()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function registerStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role for web registration
        ]);

        Auth::login($user);

        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
