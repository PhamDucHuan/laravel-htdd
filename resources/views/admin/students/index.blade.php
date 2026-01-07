@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">

    <div class="flex-1 overflow-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Danh sách Học sinh</h2>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Họ tên</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lớp học</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SĐT</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-xs mr-3">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($student->classroom)
                                <a href="{{ route('classrooms.show', $student->classroom->id) }}" class="text-blue-600 hover:underline">
                                    {{ $student->classroom->name }}
                                </a>
                            @else
                                <span class="text-gray-400 italic">Chưa xếp lớp</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $student->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $student->phone ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection