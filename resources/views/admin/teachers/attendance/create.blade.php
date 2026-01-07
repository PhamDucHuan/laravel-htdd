@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">
            Điểm danh: {{ $session->classroom->name }}
            <span class="text-sm font-normal text-gray-500 block">
                Buổi học ngày: {{ \Carbon\Carbon::parse($session->date)->format('d/m/Y') }} 
                ({{ $session->start_time }} - {{ $session->end_time }})
            </span>
        </h2>

        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            <input type="hidden" name="classroom_id" value="{{ $session->classroom->id }}">

            <table class="min-w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Sinh viên</th>
                        <th class="px-4 py-2 border text-center">Có mặt</th>
                        <th class="px-4 py-2 border text-center">Vắng</th>
                        <th class="px-4 py-2 border text-center">Muộn</th>
                        <th class="px-4 py-2 border">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($session->classroom->students as $student)
                    @php 
                        $status = $attendances[$student->id] ?? 'present'; // Mặc định là Có mặt
                    @endphp
                    <tr>
                        <td class="px-4 py-2 border">{{ $student->name }}</td>
                        
                        <td class="px-4 py-2 border text-center">
                            <input type="radio" name="attendance[{{ $student->id }}]" value="present" 
                                {{ $status == 'present' ? 'checked' : '' }} class="h-5 w-5 text-green-600">
                        </td>
                        <td class="px-4 py-2 border text-center">
                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent" 
                                {{ $status == 'absent' ? 'checked' : '' }} class="h-5 w-5 text-red-600">
                        </td>
                        <td class="px-4 py-2 border text-center">
                            <input type="radio" name="attendance[{{ $student->id }}]" value="late" 
                                {{ $status == 'late' ? 'checked' : '' }} class="h-5 w-5 text-yellow-600">
                        </td>
                        
                        <td class="px-4 py-2 border">
                            <input type="text" name="remarks[{{ $student->id }}]" class="border rounded px-2 py-1 w-full">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 text-right">
                <a href="{{ route('classrooms.show', $session->classroom->id) }}" class="text-gray-600 mr-4">Hủy</a>
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700">
                    Lưu Điểm Danh
                </button>
            </div>
        </form>
    </div>
</div>
@endsection