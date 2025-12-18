<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- HIỂN THỊ FORM ---
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    // --- XỬ LÝ ĐĂNG KÝ ---
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', // Thêm confirmed để khớp với ô nhập lại mật khẩu
            'phone' => 'required',
            // Các validate khác...
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'citizen_id' => $request->citizen_id,
            'degree' => $request->degree,
            'university' => $request->university,
            'major' => $request->major,
            'family_info' => [
                'name' => $request->family_name,
                'phone' => $request->family_phone,
                'relationship' => $request->family_relationship,
            ],
            'role' => User::ROLE_TEACHER,
            'status' => 1,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    // --- XỬ LÝ ĐĂNG NHẬP ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất khỏi hệ thống
 
        $request->session()->invalidate(); // Hủy session hiện tại
 
        $request->session()->regenerateToken(); // Tạo lại token bảo mật
 
        return redirect('/login'); // Quay về trang đăng nhập
    }
}