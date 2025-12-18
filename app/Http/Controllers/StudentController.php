<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Hiển thị danh sách tất cả học sinh
    public function index()
    {
        // Lấy danh sách học sinh kèm thông tin lớp học, phân trang 10 em
        $students = Student::with('classroom')->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }
}