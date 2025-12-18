<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteTeacherMail; // Đảm bảo đã có Mailable này
use App\Models\User;

class AdminController extends Controller
{
    // Hiển thị form mời
    public function showInviteForm()
    {
        // Kiểm tra xem file view này có tồn tại không: resources/views/admin/invite.blade.php
        return view('admin.invite'); 
    }

    // Xử lý gửi email
    public function sendInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email'
        ]);

        // Gửi mail (Nếu bạn chưa cấu hình mail, đoạn này sẽ lỗi)
        // Nếu chỉ test giao diện, bạn có thể comment dòng Mail::to... lại
        
        try {
            Mail::to($request->email)->send(new InviteTeacherMail());
            return back()->with('success', 'Đã gửi lời mời tới ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi gửi mail: ' . $e->getMessage());
        }
    }
}