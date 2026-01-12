@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $classroom->name }}</h1>
            <p class="text-gray-600 mt-1">
                <span class="font-bold">Giáo viên:</span> {{ $classroom->teacher->name ?? 'Chưa gán' }} | 
                <span class="font-bold">Sĩ số:</span> {{ $classroom->students->count() }} sinh viên
            </p>
        </div>
        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow transition">
            &larr; Quay lại Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        📅 Danh Sách Buổi Học
                    </h3>
                    <span class="text-blue-100 text-sm bg-blue-700 px-2 py-1 rounded">
                        Tổng: {{ $classroom->sessions->count() }} buổi
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Thời gian</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Thứ</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($classroom->sessions as $session)
    @php
        // Xử lý logic thời gian ngay tại đây
        $startTime = \Carbon\Carbon::parse($session->start_time);
        $endTime   = \Carbon\Carbon::parse($session->end_time);
        
        // Kiểm tra: Nếu giờ bắt đầu < 12h trưa là Sáng, ngược lại là Chiều
        $isMorning = $startTime->hour < 12;
    @endphp

    <tr class="hover:bg-blue-50 transition duration-150 border-b border-gray-100">
        
        {{-- Cột 1: Ngày & Giờ --}}
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-bold text-gray-900">
                {{ \Carbon\Carbon::parse($session->date)->format('d/m/Y') }}
            </div>
            <div class="text-xs text-gray-500 mt-1">
                ⏰ {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}
            </div>
        </td>

        {{-- Cột 2: Thứ & Buổi (Sáng/Chiều) --}}
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex flex-col gap-1">
                {{-- Hiển thị Thứ --}}
                <span class="text-xs font-semibold text-gray-500 uppercase">
                    {{ \Carbon\Carbon::parse($session->date)->dayName }}
                </span>

                {{-- Hiển thị Badge Sáng/Chiều --}}
                @if($isMorning)
                    <span class="w-fit px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                        🌅 Buổi Sáng
                    </span>
                @else
                    <span class="w-fit px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-sky-100 text-sky-800 border border-sky-200">
                        🌆 Buổi Chiều
                    </span>
                @endif
            </div>
        </td>

        {{-- Cột 3: Trạng thái điểm danh --}}
        <td class="px-6 py-4 whitespace-nowrap text-center">
            @if($session->attendances->count() > 0)
                <span class="px-3 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full border border-green-200">
                    ✓ Đã điểm danh
                </span>
            @else
                <span class="px-3 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded-full border border-yellow-200">
                    ⏳ Chưa điểm danh
                </span>
            @endif
        </td>

        {{-- Cột 4: Nút bấm --}}
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="{{ route('attendance.create', $session->id) }}" 
               class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ $session->attendances->count() > 0 ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                
                @if($session->attendances->count() > 0)
                    ✏️ Sửa điểm danh
                @else
                    📝 Điểm Danh
                @endif
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p>Lớp này chưa có lịch học nào được tạo.</p>
            </div>
        </td>
    </tr>
@endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="bg-gray-800 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">👨‍🎓 Sinh Viên Lớp</h3>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-gray-200 max-h-[500px] overflow-y-auto">
                        @forelse($classroom->students as $student)
                        <li class="p-4 flex items-center hover:bg-gray-50">
                            <div class="flex-shrink-0">
                                <span class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                    {{ substr($student->name, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500">{{ $student->email }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="p-6 text-center text-gray-500 italic text-sm">
                            Chưa có sinh viên nào trong lớp này.
                        </li>
                        @endforelse
                    </ul>
                </div>
                
                @if(Auth::user()->role == 'admin')
                <div class="p-4 bg-gray-50 border-t">
                    <form action="{{ route('classrooms.students.add', $classroom->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="name" placeholder="Tên sinh viên..." required class="w-full text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                            + Thêm Sinh Viên
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection