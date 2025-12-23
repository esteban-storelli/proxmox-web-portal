<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request) {
        $incomingFields = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt(['email' => $incomingFields['email'], 'password' => $incomingFields['password']])) {
            $request->session()->regenerate();
            return redirect('/');
        }
        return redirect('/login')->withErrors(['login.failed' => 'Email or password are incorrect.']);
    }
    public function logout() {
        auth()->logout();
        return redirect('/login');
    }
}