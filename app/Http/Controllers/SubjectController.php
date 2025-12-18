<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // 1. Danh sách môn học
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    // 2. Form tạo môn học
    public function create()
    {
        return view('admin.subjects.create');
    }

    // 3. Lưu môn học mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects',
            'credits' => 'integer|min:1',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')->with('success', 'Thêm môn học thành công!');
    }

    // 4. Form sửa môn học
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    // 5. Cập nhật môn học
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $id, // Bỏ qua check unique chính nó
            'credits' => 'integer|min:1',
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')->with('success', 'Cập nhật môn học thành công!');
    }

    // 6. Xóa môn học
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return back()->with('success', 'Đã xóa môn học.');
    }
}