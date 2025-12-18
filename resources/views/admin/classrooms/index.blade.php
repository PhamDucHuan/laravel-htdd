@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 overflow-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Quản lý Lớp học</h2>
            <a href="{{ route('classrooms.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tạo lớp mới
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên lớp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giáo viên</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lịch học</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Học sinh</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($classrooms as $class)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-blue-600">
                            <a href="{{ route('classrooms.show', $class->id) }}" class="hover:underline">{{ $class->name }}</a>
                        </td>
                        <td class="px-6 py-4">{{ $class->teacher->name ?? 'Chưa gán' }}</td>
                        <td class="px-6 py-4">{{ $class->schedule }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs font-bold">
                                {{ $class->students->count() }} SV
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('classrooms.show', $class->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">Chi tiết &rarr;</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection