@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Lớp: {{ $classroom->name }}</h2>
            <p class="text-gray-600">Giáo viên: {{ $classroom->teacher->name ?? 'Chưa gán' }}</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">&larr; Quay lại Dashboard</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-xl font-bold text-blue-800">📅 Lịch Học & Điểm Danh</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Ngày</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Giờ học</th>
                                <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Trạng thái</th>
                                <th class="px-4 py-2 text-right text-xs font-bold text-gray-500 uppercase">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($classroom->sessions as $session)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($session->date)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($session->date)->dayName }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    @if($session->attendances_count > 0)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Đã điểm danh
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Chưa
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('attendance.create', $session->id) }}" 
                                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded shadow">
                                        📝 Điểm danh
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500 italic">
                                    Chưa có lịch học. Vui lòng tạo tự động hoặc thêm thủ công.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 pt-4 border-t">
                    <details>
                        <summary class="cursor-pointer text-blue-600 text-sm font-bold select-none">
                            + Thêm buổi học bổ sung
                        </summary>
                        <form action="{{ route('classrooms.sessions.store', $classroom->id) }}" method="POST" class="mt-4 bg-gray-50 p-4 rounded">
                            @csrf
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="text-xs font-bold">Ngày</label>
                                    <input type="date" name="date" required class="w-full border rounded px-2 py-1">
                                </div>
                                <div>
                                    <label class="text-xs font-bold">Bắt đầu</label>
                                    <input type="time" name="start_time" required class="w-full border rounded px-2 py-1">
                                </div>
                                <div>
                                    <label class="text-xs font-bold">Kết thúc</label>
                                    <input type="time" name="end_time" required class="w-full border rounded px-2 py-1">
                                </div>
                            </div>
                            <button type="submit" class="mt-2 bg-gray-600 text-white text-xs py-1 px-3 rounded hover:bg-gray-700">Lưu</button>
                        </form>
                    </details>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Danh sách Sinh viên</h3>
                
                <ul class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($classroom->students as $student)
                    <li class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                        <div class="flex items-center">
                            <div class="bg-blue-100 text-blue-800 font-bold rounded-full w-8 h-8 flex items-center justify-center mr-3">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500">{{ $student->email }}</p>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="text-gray-500 text-sm italic">Chưa có sinh viên nào.</li>
                    @endforelse
                </ul>

                <div class="mt-4 pt-4 border-t">
                    <form action="{{ route('classrooms.students.add', $classroom->id) }}" method="POST">
                        @csrf
                        <input type="text" name="name" placeholder="Tên sinh viên mới..." required class="w-full border rounded px-3 py-2 text-sm mb-2">
                        <button type="submit" class="w-full bg-green-500 text-white font-bold py-2 rounded hover:bg-green-600 text-sm">
                            + Thêm Sinh viên
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection