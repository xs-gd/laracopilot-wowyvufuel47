<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'admin@library.com'   => 'admin123',
            'manager@library.com' => 'manager123',
            'staff@library.com'   => 'staff123',
        ];

        if (isset($credentials[$request->email]) && $credentials[$request->email] === $request->password) {
            session([
                'admin_logged_in' => true,
                'admin_user'      => ucfirst(explode('@', $request->email)[0]),
                'admin_email'     => $request->email,
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email']);
        return redirect()->route('admin.login');
    }
}