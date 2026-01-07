<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use App\Models\Attendance;
use App\Models\Student;

class AttendanceController extends Controller
{
    // 1. Hiển thị form điểm danh cho một buổi học cụ thể (Session)
    public function create($session_id)
    {
        // Lấy thông tin buổi học + Lớp + Danh sách sinh viên của lớp đó
        $session = ClassSession::with('classroom.students')->findOrFail($session_id);
        
        // Lấy dữ liệu điểm danh cũ (nếu đã điểm danh rồi) để hiển thị lại
        $attendances = Attendance::where('class_session_id', $session_id)
                                 ->pluck('status', 'student_id')
                                 ->toArray();

        // Trả về view (Bạn cần tạo file view này ở bước phụ bên dưới)
        return view('admin.teachers.attendance.create', compact('session', 'attendances'));
    }

    // 2. Lưu dữ liệu điểm danh
    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:class_sessions,id',
            'attendance' => 'required|array', // Mảng: [student_id => status]
        ]);

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                [
                    'class_session_id' => $request->session_id,
                    'student_id' => $student_id
                ],
                [
                    'status' => $status, // 'present', 'absent', 'late'
                    'remarks' => $request->remarks[$student_id] ?? null // Ghi chú nếu có
                ]
            );
        }

        return redirect()->route('classrooms.show', $request->classroom_id)
                         ->with('success', 'Đã lưu điểm danh thành công!');
    }
}