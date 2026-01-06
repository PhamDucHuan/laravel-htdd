<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Subject;
use App\Models\ClassSession; // <-- Bắt buộc có để tạo lịch
use Illuminate\Http\Request;
use Carbon\Carbon;           // <-- Bắt buộc để xử lý ngày tháng

class ClassroomController extends Controller
{
    // Hiển thị danh sách lớp
    public function index()
    {
        $classrooms = Classroom::with('teacher')->latest()->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    // Hiển thị form tạo lớp
    public function create()
    {
        // Lấy danh sách giáo viên và môn học để hiển thị trong select box
        $teachers = User::where('role', 'teacher')->get();
        $subjects = Subject::all(); 
        return view('admin.classrooms.create', compact('teachers', 'subjects'));
    }

    // Xử lý lưu lớp học và tạo lịch tự động
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required', // Sửa từ 'subject' thành 'subject_id' cho khớp với Form
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'days'       => 'required|array|min:1', // Bắt buộc chọn ít nhất 1 thứ
        ]);

        // 2. Tạo Lớp học (Classroom)
        // Lưu ý: Nếu database của bạn cột là 'subject' (string), ta lưu tạm subject_id vào đó
        $classroom = Classroom::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'subject' => $request->subject_id, // Lưu ID môn học
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'schedule' => implode(',', $request->days), // Lưu tạm các thứ đã chọn (VD: "2,4,6")
            'status' => 'pending',
        ]);

        // 3. LOGIC TỰ ĐỘNG TẠO BUỔI HỌC (Loop từ ngày bắt đầu -> kết thúc)
        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        $daysOfWeek = $request->days; // Mảng các thứ: [2, 4, 6]

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Kiểm tra nếu ngày hiện tại trùng với thứ đã chọn
            if (in_array($date->dayOfWeekIso, $daysOfWeek)) {
                ClassSession::create([
                    'classroom_id' => $classroom->id,
                    'date'         => $date->format('Y-m-d'),
                    'start_time'   => $request->session_start_time,
                    'end_time'     => $request->session_end_time,
                ]);
            }
        }

        return redirect()->route('classrooms.index')
            ->with('success', 'Đã tạo lớp học và lịch học thành công!');
    }

    // Xem chi tiết lớp
    public function show($id)
    {
        $classroom = Classroom::with(['teacher', 'students', 'sessions'])->findOrFail($id);
        return view('admin.classrooms.show', compact('classroom'));
    }

    // Thêm sinh viên vào lớp
    public function addStudent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        \App\Models\Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'classroom_id' => $id,
        ]);

        return back()->with('success', 'Đã thêm sinh viên thành công!');
    }
}