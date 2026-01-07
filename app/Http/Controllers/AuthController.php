<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

    // 1. Hiển thị form nhập email
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Gửi link reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Gửi link reset pass (Laravel tự xử lý token và gửi mail dựa trên bảng password_reset_tokens)
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // 3. Hiển thị form đặt lại mật khẩu (khi user click link trong mail)
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // 4. Xử lý đổi mật khẩu mới từ form reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Thực hiện reset password
        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new \Illuminate\Auth\Events\PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công.');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    // ==========================================================
    // CHỨC NĂNG: ĐỔI MẬT KHẨU (Change Password - Khi đang login)
    // ==========================================================

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed|different:current_password',
        ], [
            'new_password.different' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.',
            'new_password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // Cập nhật mật khẩu mới
        /** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất khỏi hệ thống
 
        $request->session()->invalidate(); // Hủy session hiện tại
 
        $request->session()->regenerateToken(); // Tạo lại token bảo mật
 
        return redirect()->route('home'); // Quay về trang chủ
    }

    // 1. Hiển thị form đăng ký đặc biệt cho lời mời
    public function showInviteRegisterForm($token)
    {
        // Kiểm tra token có tồn tại không
        $invite = DB::table('invitations')->where('token', $token)->first();

        if (!$invite) {
            abort(404, 'Lời mời không tồn tại hoặc đã hết hạn.');
        }

        // Trả về view đăng ký, truyền email đã được mời sang để user đỡ phải nhập lại
        return view('auth.register-invite', ['email' => $invite->email, 'token' => $token]);
    }

    // 2. Xử lý lưu user từ form lời mời
    public function storeInviteRegister(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
            // Email lấy từ token nên không cho user sửa lung tung, hoặc validate khớp token
        ]);

        // Lấy thông tin từ token
        $invite = DB::table('invitations')->where('token', $request->token)->first();

        if (!$invite) {
            return back()->withErrors(['token' => 'Lời mời không hợp lệ.']);
        }

        // Tạo User mới
        User::create([
            'name' => $request->name,
            'email' => $invite->email, // Dùng email từ lời mời để đảm bảo đúng người
            'password' => Hash::make($request->password),
            'role' => 'teacher', // Mặc định là giáo viên
            'status' => 1,
            // Thêm các trường khác nếu form có (phone, address...)
        ]);

        // Xóa lời mời sau khi dùng xong
        DB::table('invitations')->where('email', $invite->email)->delete();

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Hãy đăng nhập.');
    }
}