@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 overflow-auto p-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Thêm Môn học mới</h2>
            
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                
                {{-- Đã xóa ô nhập Mã môn học --}}
                <div class="mb-4 bg-blue-50 p-3 rounded border border-blue-200 text-sm text-blue-800">
                    <i class="fas fa-info-circle"></i> Mã môn học sẽ được hệ thống tạo ngẫu nhiên (Ví dụ: SUB-A1B2C3).
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Tên môn học <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border p-2 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="VD: Lập trình Laravel" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Số tín chỉ</label>
                    <input type="number" name="credits" value="3" min="1" class="w-full border p-2 rounded focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Mô tả chi tiết</label>
                    <textarea name="description" rows="3" class="w-full border p-2 rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('subjects.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">Hủy</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Lưu & Tạo mã</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection