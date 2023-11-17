<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function submitLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            return redirect('/dashboard');
        }
        return redirect('/login')->with('error', 'Invalid credentials')->withInput($request->only('email'));
    }

    public function submitLogout(Request $request)
    {
        try {
            Auth::logout();

            return redirect('/login');
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Logout failed'], 500);
        }
    }

}