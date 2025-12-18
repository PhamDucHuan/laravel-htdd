<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // 1. Hiển thị danh sách giáo viên
    public function index()
    {
        // Lấy danh sách user có role là 'teacher', phân trang 10 người/trang
        $teachers = User::where('role', 'teacher')->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    // 2. Xem chi tiết giáo viên
    public function show($id)
    {
        $teacher = User::findOrFail($id);
        
        // Kiểm tra chắc chắn đây là giáo viên
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        return view('admin.teachers.show', compact('teacher'));
    }

    // 3. Khóa / Mở khóa tài khoản (Block/Unblock)
    public function toggleStatus($id)
    {
        $teacher = User::findOrFail($id);

        // Đảo ngược trạng thái: Nếu 1 (Active) -> 0 (Block) và ngược lại
        $teacher->status = $teacher->status == 1 ? 0 : 1;
        $teacher->save();

        $msg = $teacher->status == 1 ? 'Đã mở khóa tài khoản.' : 'Đã khóa tài khoản giáo viên.';
        return back()->with('success', $msg);
    }
    
    // 4. Xóa giáo viên (Nếu cần)
    public function destroy($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->delete();
        return back()->with('success', 'Đã xóa giáo viên khỏi hệ thống.');
    }
}