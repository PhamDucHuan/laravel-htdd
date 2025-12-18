@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
        <header class="md:hidden bg-white shadow-sm flex items-center justify-between p-4 z-10">
            <div class="font-bold text-lg text-blue-600">IT Center</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-gray-500 hover:text-red-500">Thoát</button>
            </form>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                
                {{-- Header --}}
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold">Điểm danh lớp: {{ $classroom->name }}</h2>
                        <div class="text-blue-100 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Ngày: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="flex items-center text-white bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded text-sm transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Quay lại
                    </a>
                </div>

                <form action="{{ route('attendance.store', $classroom->id) }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider font-semibold">
                                <tr>
                                    <th class="px-6 py-3 w-10 text-center">STT</th>
                                    <th class="px-6 py-3">Sinh viên</th>
                                    <th class="px-6 py-3 text-center w-48">Trạng thái</th>
                                    <th class="px-6 py-3">Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($classroom->students as $index => $student)
                                @php
                                    $status = $attendances[$student->id]->status ?? 'present';
                                    $note = $attendances[$student->id]->note ?? '';
                                @endphp
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="px-6 py-4 text-center text-gray-500">{{ $index + 1 }}</td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3">
                                                {{ substr($student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $student->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- === DROPDOWN CHỌN TRẠNG THÁI === --}}
                                    <td class="px-6 py-4 text-center">
                                        <select name="attendance[{{ $student->id }}]" 
                                            class="attendance-select block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm py-2 font-bold transition-colors"
                                            onchange="updateColor(this)">
                                            
                                            <option value="present" class="text-green-600 font-bold" {{ $status == 'present' ? 'selected' : '' }}>
                                                ● Có mặt
                                            </option>
                                            <option value="absent" class="text-red-600 font-bold" {{ $status == 'absent' ? 'selected' : '' }}>
                                                ● Vắng
                                            </option>
                                            <option value="late" class="text-yellow-600 font-bold" {{ $status == 'late' ? 'selected' : '' }}>
                                                ● Muộn
                                            </option>
                                        </select>
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="text" name="note[{{ $student->id }}]" value="{{ $note }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Nhập lý do...">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($classroom->students->isEmpty())
                            <div class="p-8 text-center text-gray-500 flex flex-col items-center">
                                <p>Lớp này chưa có sinh viên nào.</p>
                            </div>
                        @endif
                    </div>
                    
                    @if(!$classroom->students->isEmpty())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3 sticky bottom-0 bg-white shadow-inner">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm font-bold transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Lưu Kết Quả
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </main>
    </div>
</div>

{{-- JAVASCRIPT XỬ LÝ MÀU SẮC --}}
<script>
    function updateColor(selectElement) {
        // Xóa các class màu cũ
        selectElement.classList.remove('text-green-600', 'text-red-600', 'text-yellow-600', 'bg-green-50', 'bg-red-50', 'bg-yellow-50');

        // Thêm class màu mới dựa trên giá trị
        if (selectElement.value === 'present') {
            selectElement.classList.add('text-green-600', 'bg-green-50');
        } else if (selectElement.value === 'absent') {
            selectElement.classList.add('text-red-600', 'bg-red-50');
        } else if (selectElement.value === 'late') {
            selectElement.classList.add('text-yellow-600', 'bg-yellow-50');
        }
    }

    // Chạy hàm này khi trang vừa tải xong để tô màu các giá trị có sẵn
    document.addEventListener("DOMContentLoaded", function() {
        const selects = document.querySelectorAll('.attendance-select');
        selects.forEach(select => {
            updateColor(select);
        });
    });
</script>
@endsection