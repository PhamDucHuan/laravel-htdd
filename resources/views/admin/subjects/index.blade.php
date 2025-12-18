@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 overflow-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Quản lý Môn học</h2>
            <a href="{{ route('subjects.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Thêm môn học
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded border-l-4 border-green-500">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mã môn</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên môn học</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tín chỉ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($subjects as $subject)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-bold text-gray-700">{{ $subject->code }}</td>
                        <td class="px-6 py-4">{{ $subject->name }}</td>
                        <td class="px-6 py-4">{{ $subject->credits }}</td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('subjects.edit', $subject->id) }}" class="text-yellow-600 hover:text-yellow-800">Sửa</a>
                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Xóa môn học này?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-800">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $subjects->links() }}</div>
        </div>
    </div>
</div>
@endsection