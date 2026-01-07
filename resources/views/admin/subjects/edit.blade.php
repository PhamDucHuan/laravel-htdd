@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">

    <div class="flex-1 overflow-auto p-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Sửa Môn học: {{ $subject->name }}</h2>
            
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Mã môn học</label>
                    <input type="text" value="{{ $subject->code }}" disabled class="w-full border p-2 rounded bg-gray-200 text-gray-600 cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-1">Mã môn học là duy nhất và không thể thay đổi.</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Tên môn học</label>
                    <input type="text" name="name" value="{{ $subject->name }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Số tín chỉ</label>
                    <input type="number" name="credits" value="{{ $subject->credits }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Mô tả</label>
                    <textarea name="description" class="w-full border p-2 rounded">{{ $subject->description }}</textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('subjects.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Hủy</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection