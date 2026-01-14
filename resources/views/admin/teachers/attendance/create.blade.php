@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                📝 Điểm danh lớp: <span class="text-blue-600">{{ $session->classroom->name }}</span>
            </h2>
            <div class="text-right">
                <div class="text-sm font-bold text-gray-700">
                    Ngày: {{ \Carbon\Carbon::parse($session->date)->format('d/m/Y') }}
                </div>
                <div class="text-xs text-gray-500">
                    Thời gian: {{ $session->start_time }} - {{ $session->end_time }}
                </div>
            </div>
        </div>

        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            <input type="hidden" name="classroom_id" value="{{ $session->classroom->id }}">

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 text-left w-1/4">Sinh viên</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center w-1/4">Trạng thái</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-left w-1/2">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($session->classroom->students as $student)
                        @php 
                            // Lấy dữ liệu điểm danh (hỗ trợ cả trường hợp Controller trả về Object hoặc String)
                            $data = $attendances[$student->id] ?? null;
                            
                            if (is_object($data)) {
                                $status = $data->status;
                                $remark = $data->remarks;
                            } else {
                                $status = $data ?? 'present'; // Mặc định là present (Có mặt)
                                $remark = '';
                            }
                        @endphp
                        
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            {{-- Cột Tên --}}
                            <td class="px-6 py-3 whitespace-nowrap font-medium text-gray-800">
                                {{ $student->name }}
                            </td>
                            
                            {{-- Cột Dropdown Trạng thái --}}
                            <td class="px-6 py-3 text-center">
                                <select name="attendance[{{ $student->id }}]" 
                                        class="block w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 font-bold
                                        {{ $status == 'present' ? 'text-green-600' : ($status == 'absent' ? 'text-red-600' : 'text-yellow-600') }}"
                                        onchange="this.className = 'block w-full bg-white border border-gray-300 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 font-bold ' + (this.value == 'present' ? 'text-green-600' : (this.value == 'absent' ? 'text-red-600' : 'text-yellow-600'))">
                                    
                                    <option value="present" class="text-green-600 font-bold" {{ $status == 'present' ? 'selected' : '' }}>
                                        ✅ Có mặt
                                    </option>
                                    <option value="absent" class="text-red-600 font-bold" {{ $status == 'absent' ? 'selected' : '' }}>
                                        ❌ Vắng
                                    </option>
                                    <option value="late" class="text-yellow-600 font-bold" {{ $status == 'late' ? 'selected' : '' }}>
                                        ⚠️ Muộn
                                    </option>
                                </select>
                            </td>
                            
                            {{-- Cột Ghi chú --}}
                            <td class="px-6 py-3">
                                <input type="text" 
                                       name="remarks[{{ $student->id }}]" 
                                       value="{{ $remark }}" 
                                       class="appearance-none block w-full bg-gray-50 text-gray-700 border border-gray-300 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                                       placeholder="Nhập ghi chú (nếu có)...">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('classrooms.show', $session->classroom->id) }}" 
                   class="bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded hover:bg-gray-300 transition duration-300">
                    Hủy
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white font-bold py-2 px-8 rounded shadow hover:bg-blue-700 transition duration-300 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Lưu Điểm Danh
                </button>
            </div>
        </form>
    </div>
</div>
@endsection