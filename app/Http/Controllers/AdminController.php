<?php

namespace App\Http\Controllers;

use App\Mail\InviteTeacherMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // Hiển thị form mời giáo viên (Giao diện Admin)
    public function showInviteForm()
    {
        return view('admin.invite');
    }

    // Xử lý gửi mail
    public function sendInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Gửi mail đến địa chỉ được nhập
        Mail::to($request->email)->send(new InviteTeacherMail());

        return back()->with('success', 'Đã gửi lời mời thành công tới ' . $request->email);
    }
}