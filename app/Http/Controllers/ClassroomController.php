<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Subject;
use App\Models\ClassSession; // <-- Bắt buộc có để tạo lịch
use Illuminate\Http\Request;
use Carbon\Carbon;           // <-- Bắt buộc để xử lý ngày tháng
use App\Models\Student;

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
    // app/Http/Controllers/ClassroomController.php

public function store(Request $request)
{
    // 1. Validate dữ liệu
    $request->validate([
        'name' => 'required|string|max:255',
        'teacher_id' => 'required|exists:users,id',
        'subject_id' => 'required',
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'days'       => 'required|array|min:1',
        // Validate giờ: Bắt buộc phải nhập ít nhất 1 buổi (Sáng hoặc Chiều)
        'morning_start' => 'nullable',
        'morning_end'   => 'nullable|after:morning_start',
        'afternoon_start' => 'nullable',
        'afternoon_end'   => 'nullable|after:afternoon_start',
    ]);

    // Kiểm tra xem người dùng có nhập ít nhất 1 khung giờ không
    if (!$request->morning_start && !$request->afternoon_start) {
        return back()->withErrors(['time_error' => 'Bạn phải nhập thời gian cho ít nhất là Buổi Sáng hoặc Buổi Chiều.'])->withInput();
    }

    // 2. Tạo Lớp học
    $classroom = Classroom::create([
        'name' => $request->name,
        'teacher_id' => $request->teacher_id,
        'subject' => $request->subject_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'description' => $request->description,
        'schedule' => implode(',', $request->days),
        'status' => 'pending',
    ]);

    // 3. LOGIC TỰ ĐỘNG TẠO BUỔI HỌC (2 BUỔI/NGÀY)
    $startDate = Carbon::parse($request->start_date);
    $endDate   = Carbon::parse($request->end_date);
    $daysOfWeek = $request->days;

    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        
        // Nếu ngày hiện tại trùng với thứ đã chọn
        if (in_array($date->dayOfWeekIso, $daysOfWeek)) {
            
            // --- TẠO BUỔI SÁNG (Nếu có nhập giờ) ---
            if ($request->morning_start && $request->morning_end) {
                ClassSession::create([
                    'classroom_id' => $classroom->id,
                    'date'         => $date->format('Y-m-d'),
                    'start_time'   => $request->morning_start,
                    'end_time'     => $request->morning_end,
                ]);
            }

            // --- TẠO BUỔI CHIỀU (Nếu có nhập giờ) ---
            if ($request->afternoon_start && $request->afternoon_end) {
                ClassSession::create([
                    'classroom_id' => $classroom->id,
                    'date'         => $date->format('Y-m-d'),
                    'start_time'   => $request->afternoon_start,
                    'end_time'     => $request->afternoon_end,
                ]);
            }
        }
    }

    return redirect()->route('classrooms.index')
        ->with('success', 'Đã tạo lớp học và lịch học (Sáng/Chiều) thành công!');
}

    public function storeSession(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ], [
            'end_time.after' => 'Giờ kết thúc phải sau giờ bắt đầu.',
        ]);

        ClassSession::create([
            'classroom_id' => $id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Đã thêm buổi học mới thành công!');
    }

    // Xem chi tiết lớp
    // app/Http/Controllers/ClassroomController.php

public function show($id)
{
    // Tìm lớp học theo ID
    // with('sessions'): Lấy kèm danh sách buổi học
    // with('students'): Lấy kèm danh sách sinh viên
    $classroom = Classroom::with(['teacher', 'students', 'sessions' => function($query) {
        $query->orderBy('date', 'asc') // Sắp xếp ngày học tăng dần
              ->orderBy('start_time', 'asc');
    }])->findOrFail($id);

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

    // app/Http/Controllers/ClassroomController.php

    public function myClasses()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Thêm ->with('subjectInfo') vào câu truy vấn
        $classrooms = Classroom::where('teacher_id', $user->id)
                               ->withCount('students')
                               ->with('subjectInfo') // <--- THÊM DÒNG NÀY
                               ->get();
    
        return view('teachers.classrooms.index', compact('classrooms'));
    }

    // Xóa lớp học
    public function destroy($id)
    {
        // Tìm lớp học
        $classroom = Classroom::findOrFail($id);

        // Xóa lớp (Các bảng liên quan như class_sessions sẽ tự xóa theo nếu đã cài cascade trong database)
        $classroom->delete();

        return redirect()->back()->with('success', 'Đã xóa lớp học thành công!');
    }

    // --- Thêm vào App/Http/Controllers/ClassroomController.php ---

    // 1. Hiển thị form chỉnh sửa
    public function edit($id)
{
    // Thêm with('students') để lấy danh sách học viên của lớp này
    $classroom = Classroom::with('students')->findOrFail($id);
    
    $teachers = User::where('role', 'teacher')->get();
    $subjects = Subject::all();
    
    return view('admin.classrooms.edit', compact('classroom', 'teachers', 'subjects'));
}

// 2. Cập nhật hàm update
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'teacher_id' => 'required|exists:users,id',
        'subject_id' => 'required',
        'description' => 'nullable|string',
        // Validate mảng dữ liệu học viên (nếu có)
        'students.*.name' => 'required|string|max:255',
        'students.*.phone' => 'nullable|string|max:20',
    ]);

    $classroom = Classroom::findOrFail($id);

    // 1. Cập nhật thông tin Lớp học
    $classroom->update([
        'name' => $request->name,
        'teacher_id' => $request->teacher_id,
        'subject' => $request->subject_id,
        'description' => $request->description,
    ]);

    // 2. Cập nhật thông tin Học viên (Vòng lặp thần thánh)
    if ($request->has('students')) {
        foreach ($request->students as $studentId => $data) {
            // Tìm học viên và cập nhật
            $student = Student::find($studentId);
            if ($student) {
                $student->update([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    // Bạn có thể thêm email nếu muốn sửa luôn email
                    // 'email' => $data['email'], 
                ]);
            }
        }
    }

    return redirect()->route('classrooms.index')->with('success', 'Cập nhật lớp học và danh sách học viên thành công!');
}
}