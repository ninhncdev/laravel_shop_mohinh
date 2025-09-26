<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function register()
    {
        return view('admin.auth.register');
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function postRegister(RegisterRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $data['is_active'] = 0;
            $data['role'] = 'customer';

            $user = User::create($data);
            return redirect()->route('a-login')->with('success', 'Đăng kí tài khoản thành công!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Có lỗi xảy ra vui lòng thử lại!');
        }

    }

    public function postLoginAdmin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin');
        }

        return back()->withErrors([
            'email' => 'Lỗi !!'
        ]);
    }

    public function logoutAdmin(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('a-login');
    }
}
