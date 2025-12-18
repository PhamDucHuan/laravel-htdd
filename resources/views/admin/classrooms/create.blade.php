@extends('layouts.app') {{-- Sửa từ guest thành app --}}

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    {{-- 1. Sidebar --}}
    @include('layouts.sidebar')

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
                            <label class="block text-gray-700 font-bold mb-2">Môn học <span class="text-red-500">*</span></label>
                            <select name="subject" required class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 border focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Chọn môn học --</option>
                                @foreach($subjects as $sub)
                                    <option value="{{ $sub->name }} ({{ $sub->code }})">
                                        {{ $sub->code }} - {{ $sub->name }} ({{ $sub->credits }} tín chỉ)
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Nếu chưa có môn, <a href="{{ route('subjects.create') }}" class="text-blue-600 hover:underline">tạo môn học mới tại đây</a>.</p>
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