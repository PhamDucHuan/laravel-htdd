<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // 1. Hiển thị form điểm danh cho một buổi học cụ thể (Session)
    // app/Http/Controllers/AttendanceController.php

    public function create($session_id)
    {
    // Lấy thông tin buổi học + Lớp + Danh sách sinh viên
    $session = ClassSession::with('classroom.students')->findOrFail($session_id);
    
    // SỬA ĐOẠN NÀY:
    // Thay vì dùng pluck, ta lấy toàn bộ object và keyBy('student_id') để dễ truy xuất ở View
    $attendances = Attendance::where('class_session_id', $session_id)
                             ->get()
                             ->keyBy('student_id'); // Kết quả: [student_id => {object Attendance}]

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