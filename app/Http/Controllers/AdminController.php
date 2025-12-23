<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; // <-- Cần cái này để thao tác bảng invitations
use Illuminate\Support\Str;        // <-- Cần để tạo token ngẫu nhiên
use App\Mail\InviteTeacherMail;

class AdminController extends Controller
{
    public function showInviteForm()
    {
        return view('admin.invite'); 
    }

    public function sendInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email' // Đảm bảo email chưa đăng ký
        ]);

        // 1. Tạo token ngẫu nhiên
        $token = Str::random(32);

        // 2. Lưu vào bảng invitations (Xóa cũ nếu có để tránh rác)
        DB::table('invitations')->where('email', $request->email)->delete();
        
        DB::table('invitations')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Tạo link đăng ký kèm token
        // Ví dụ: http://yoursite.com/register/invite/abcd1234xyz...
        $url = route('register.invite', ['token' => $token]);

        // 4. Gửi mail chứa Link
        try {
            Mail::to($request->email)->send(new InviteTeacherMail($url));
            return back()->with('success', 'Đã gửi lời mời tham gia tới ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi gửi mail: ' . $e->getMessage());
        }
    }
}