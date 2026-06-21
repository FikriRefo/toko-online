<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    // Tambahkan fungsi untuk menyimpan session via POST
    public function setSession(Request $request)
    {
        $user = $request->input('user');
        $accessToken = $request->input('access_token');
        
        if ($user) {
            $request->session()->put('user', json_encode($user));
        }
        if ($accessToken) {
            $request->session()->put('access_token', $accessToken);
        }
        
        return response()->json(['success' => true]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->forget('access_token');
        return redirect('/');
    }
}
