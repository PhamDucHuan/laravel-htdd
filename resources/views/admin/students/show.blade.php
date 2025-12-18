@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
        {{-- Header --}}
        <header class="bg-white shadow-sm flex items-center justify-between p-4 z-10">
            <div class="font-bold text-lg text-blue-600">Hồ sơ Sinh viên</div>
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 text-sm">Quay lại Dashboard</a>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- 1. THÔNG TIN CÁ NHÂN --}}
                <div class="col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-3xl mb-4">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $student->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $student->email }}</p>
                        
                        <div class="mt-6 w-full text-left space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-500 text-sm">Mã SV:</span>
                                <span class="font-medium">SV{{ $student->id }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-500 text-sm">Ngày sinh:</span>
                                <span class="font-medium">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-500 text-sm">Số điện thoại:</span>
                                <span class="font-medium">{{ $student->phone ?? '---' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. LỚP HỌC & LỊCH SỬ --}}
                <div class="col-span-2 space-y-6">
                    
                    {{-- Lớp hiện tại --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Lớp học hiện tại
                        </h3>
                        @if($student->classroom)
                            <div class="bg-blue-50 p-4 rounded-lg flex justify-between items-center">
                                <div>
                                    <a href="{{ route('classrooms.show', $student->classroom->id) }}" class="text-blue-700 font-bold text-lg hover:underline">
                                        {{ $student->classroom->name }}
                                    </a>
                                    <p class="text-sm text-gray-600">GV: {{ $student->classroom->teacher->name ?? 'Chưa gán' }}</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">
                                    Đang học
                                </span>
                            </div>
                        @else
                            <p class="text-gray-500 italic">Sinh viên này chưa được xếp vào lớp nào.</p>
                        @endif
                    </div>

                    {{-- Lịch sử điểm danh --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Lịch sử chuyên cần</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-500 font-semibold">
                                    <tr>
                                        <th class="px-4 py-2">Ngày</th>
                                        <th class="px-4 py-2">Trạng thái</th>
                                        <th class="px-4 py-2">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($attendanceHistory as $att)
                                    <tr>
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($att->attendance_date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            @if($att->status == 'present')
                                                <span class="text-green-600 font-bold">Có mặt</span>
                                            @elseif($att->status == 'absent')
                                                <span class="text-red-600 font-bold">Vắng</span>
                                            @else
                                                <span class="text-yellow-600 font-bold">Muộn</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-500 italic">{{ $att->note ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-gray-400">Chưa có dữ liệu điểm danh.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>
@endsection