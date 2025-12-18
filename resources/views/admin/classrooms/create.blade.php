@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-100 p-6 flex justify-center">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-slate-800 text-white flex justify-between items-center">
            <h2 class="text-xl font-bold">Tạo Lớp Học Mới</h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-300 hover:text-white">Quay lại</a>
        </div>
        
        <form method="POST" action="{{ route('classrooms.store') }}" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-bold mb-2">Tên lớp học</label>
                <input type="text" name="name" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border" placeholder="VD: Lập trình Laravel K12">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Giáo viên phụ trách</label>
                <select name="teacher_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    <option value="">-- Chọn giáo viên --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->email }})</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Chỉ hiển thị những tài khoản có vai trò Teacher.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Môn học <span class="text-red-500">*</span></label>
                        <select name="subject" required class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Chọn môn học --</option>
                        @foreach($subjects as $sub)
                        <option value="{{ $sub->name }}">{{ $sub->code }} - {{ $sub->name }}</option>
                        @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Nếu chưa có môn, vui lòng vào <a href="{{ route('subjects.create') }}" class="text-blue-600 hover:underline">Quản lý môn học</a> để tạo trước.</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Lịch học</label>
                    <input type="text" name="schedule" required class="w-full border-gray-300 rounded-md shadow-sm p-2 border" placeholder="VD: T2-T4-T6 19:30">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Ngày bắt đầu</label>
                    <input type="date" name="start_date" required class="w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Ngày kết thúc</label>
                    <input type="date" name="end_date" class="w-full border-gray-300 rounded-md shadow-sm p-2 border">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Mô tả chi tiết</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm p-2 border"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow transition duration-200">
                Lưu & Tạo Lớp
            </button>
        </form>
    </div>
</div>
@endsection