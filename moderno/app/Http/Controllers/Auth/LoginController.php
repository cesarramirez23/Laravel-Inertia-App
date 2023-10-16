<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Redirector;
class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/login');
    }
    public function store(Request $request)
    {
        $credentials =$request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email'=>'the provided credentials do not match our records',
        ]);
    }
    public function destroy() 
    {
        Auth::logout();
        return redirect()->route('login');

    }
}
