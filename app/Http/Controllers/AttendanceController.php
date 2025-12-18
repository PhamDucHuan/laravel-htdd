<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Hiển thị danh sách sinh viên để điểm danh
    public function create($classroomId)
    {
        $classroom = Classroom::with('students')->findOrFail($classroomId);
        $date = Carbon::today()->format('Y-m-d');

        // Lấy thông tin điểm danh cũ (nếu có)
        $attendances = Attendance::where('classroom_id', $classroomId)
                                 ->where('attendance_date', $date)
                                 ->get()
                                 ->keyBy('student_id');

        // Trỏ đúng vào thư mục admin/teachers/attendance
        return view('admin.teachers.attendance.create', compact('classroom', 'date', 'attendances'));    
    }

    // Lưu kết quả điểm danh
    public function store(Request $request, $classroomId)
    {
        $date = Carbon::today()->format('Y-m-d');
        $data = $request->attendance; // Mảng dữ liệu: [student_id => status]

        if ($data) {
            foreach ($data as $studentId => $status) {
                Attendance::updateOrCreate(
                    [
                        'classroom_id' => $classroomId,
                        'student_id' => $studentId,
                        'attendance_date' => $date,
                    ],
                    [
                        'status' => $status,
                        'note' => $request->note[$studentId] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('dashboard')->with('success', 'Đã lưu điểm danh ngày ' . date('d/m/Y'));
    }
}