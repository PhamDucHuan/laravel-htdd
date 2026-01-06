@extends('layouts.app') {{-- Sửa từ guest thành app --}}

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    {{-- 1. Sidebar --}}
    @include('layouts.sidebar')
    
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">Không thể tạo lớp!</strong>
        <span class="block sm:inline">Vui lòng kiểm tra lại các thông tin sau:</span>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    {{-- 2. Nội dung chính --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
        
        {{-- Header Mobile --}}
        <header class="md:hidden bg-white shadow-sm flex items-center justify-between p-4 z-10">
            <div class="font-bold text-lg text-blue-600">IT Center</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-gray-500 hover:text-red-500">Thoát</button>
            </form>
        </header>

        {{-- Form Tạo Lớp Học --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-slate-800 text-white flex justify-between items-center">
                    <h2 class="text-xl font-bold">Tạo Lớp Học Mới</h2>
                    <a href="{{ route('classrooms.index') }}" class="text-gray-300 hover:text-white text-sm">Quay lại danh sách</a>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('classrooms.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tên lớp học <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-blue-500 focus:border-blue-500" placeholder="VD: Lập trình Laravel K12">
                        </div>

                        <div class="mb-4">
    <label class="block text-gray-700 font-bold mb-2">Môn học</label>
    
    <select name="subject_id" class="border rounded w-full py-2 px-3">
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">
                {{ $subject->name }} ({{ $subject->code }})
            </option>
        @endforeach
    </select>
</div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Giáo viên phụ trách <span class="text-red-500">*</span></label>
                            <select name="teacher_id" required class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Chọn giáo viên --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Lịch học</label>
                                <input type="text" name="schedule" required class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-blue-500 focus:border-blue-500" placeholder="VD: T2-T4-T6 19:30">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Ngày khai giảng</label>
                                <input type="date" name="start_date" required class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Mô tả chi tiết</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <div class="mt-8 border-t pt-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Cấu hình Lịch học Tự động</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Ngày bắt đầu khóa học</label>
            <input type="date" name="start_date" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Ngày kết thúc dự kiến</label>
            <input type="date" name="end_date" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
        </div>

        <div>
            <label class="block text-gray-700 font-bold mb-2">Giờ vào lớp</label>
            <input type="time" name="session_start_time" class="shadow border rounded w-full py-2 px-3 text-gray-700">
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Giờ tan lớp</label>
            <input type="time" name="session_end_time" class="shadow border rounded w-full py-2 px-3 text-gray-700">
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Chọn các thứ trong tuần học:</label>
        <div class="flex flex-wrap gap-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="days[]" value="1" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Thứ 2</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="days[]" value="2" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Thứ 3</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="days[]" value="3" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Thứ 4</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="days[]" value="4" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Thứ 5</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="days[]" value="5" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Thứ 6</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="days[]" value="6" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Thứ 7</span>
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="days[]" value="7" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2">Chủ Nhật</span>
            </label>
        </div>
    </div>
</div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('classrooms.index') }}" class="px-4 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">Hủy</a>
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition">
                                Lưu & Tạo Lớp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection