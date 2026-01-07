<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Hiển thị danh sách tất cả học sinh
    public function index()
    {
        // Lấy danh sách học sinh kèm thông tin lớp học, phân trang 10 em
        $students = Student::with('classroom')->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function show($id)
    {
    // Lấy thông tin sinh viên kèm lớp đang học
    $student = Student::with('classroom')->findOrFail($id);

    // Nếu là Teacher, kiểm tra xem sinh viên này có thuộc lớp mình dạy không
    if (Auth::user()->role == 'teacher') {
        $teacherClasses = \App\Models\Classroom::where('teacher_id', Auth::id())->pluck('id')->toArray();
        if (!in_array($student->classroom_id, $teacherClasses)) {
             abort(403, 'Sinh viên này không thuộc lớp bạn quản lý.');
        }
    }

    // Lấy lịch sử điểm danh của sinh viên này
    $attendanceHistory = \App\Models\Attendance::where('student_id', $id)
                            ->orderBy('attendance_date', 'desc')
                            ->get();

    return view('admin.students.show', compact('student', 'attendanceHistory'));
    }

    // app/Http/Controllers/StudentController.php
    public function myStudents()
    {
    $teacherId = Auth::id();

    // Lấy sinh viên thuộc các lớp mà giáo viên này dạy
    $students = \App\Models\Student::whereHas('classroom', function($q) use ($teacherId) {
        $q->where('teacher_id', $teacherId);
    })->with('classroom')->get();

    return view('teachers.students.index', compact('students'));
    }
}