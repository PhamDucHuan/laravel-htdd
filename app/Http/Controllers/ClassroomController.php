<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    // Hiển thị danh sách lớp (cho Dashboard Admin)
    public function index()
    {
        $classrooms = Classroom::with('teacher')->latest()->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    // Hiển thị form tạo lớp mới
    public function create()
{
    $teachers = User::where('role', 'teacher')->get();
    $subjects = \App\Models\Subject::all(); // Lấy tất cả môn học
    return view('admin.classrooms.create', compact('teachers', 'subjects'));
}

    // Lưu lớp học mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id', // Bắt buộc chọn giáo viên
            'start_date' => 'required|date',
            'schedule' => 'required|string',
        ]);

        Classroom::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'subject' => $request->subject,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'schedule' => $request->schedule,
            'description' => $request->description,
            'status' => 'pending', // Mặc định là 'Chờ'
        ]);

        return redirect()->route('dashboard')->with('success', 'Đã tạo lớp học thành công!');
    }
    // --- MỚI: XEM CHI TIẾT LỚP HỌC ---
    public function show($id)
    {
        // Lấy thông tin lớp kèm theo Giáo viên và Sinh viên
        $classroom = Classroom::with(['teacher', 'students'])->findOrFail($id);
        
        return view('admin.classrooms.show', compact('classroom'));
    }

    // --- MỚI: THÊM SINH VIÊN VÀO LỚP ---
    public function addStudent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ]);

        // Tạo sinh viên mới gắn với classroom_id này
        \App\Models\Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'classroom_id' => $id,
        ]);

        return back()->with('success', 'Đã thêm sinh viên thành công!');
    }
    
    // --- MỚI: XÓA SINH VIÊN KHỎI LỚP (Tùy chọn) ---
    public function removeStudent($id)
    {
        $student = \App\Models\Student::findOrFail($id);
        $student->delete();
        return back()->with('success', 'Đã xóa sinh viên khỏi lớp.');
    }
}