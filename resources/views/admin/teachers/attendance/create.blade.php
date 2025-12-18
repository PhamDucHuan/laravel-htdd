@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 overflow-auto p-8">
        <div class="max-w-4xl mx-auto bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-blue-600 text-white flex justify-between items-center">
                <h2 class="text-xl font-bold">Điểm danh lớp: {{ $classroom->name }}</h2>
                <span class="text-sm bg-blue-500 px-2 py-1 rounded">Ngày: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
            </div>

            <form action="{{ route('attendance.store', $classroom->id) }}" method="POST">
                @csrf
                <div class="p-6">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3">Sinh viên</th>
                                <th class="px-4 py-3 text-center">Trạng thái</th>
                                <th class="px-4 py-3">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($classroom->students as $student)
                            @php
                                $status = $attendances[$student->id]->status ?? 'present';
                                $note = $attendances[$student->id]->note ?? '';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">{{ $student->name }} <br> <span class="text-xs text-gray-500">{{ $student->email }}</span></td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-4">
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="present" class="text-green-600" {{ $status == 'present' ? 'checked' : '' }}>
                                            <span class="text-green-700 font-bold">Có mặt</span>
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="text-red-600" {{ $status == 'absent' ? 'checked' : '' }}>
                                            <span class="text-red-700 font-bold">Vắng</span>
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="late" class="text-yellow-600" {{ $status == 'late' ? 'checked' : '' }}>
                                            <span class="text-yellow-700 font-bold">Muộn</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="note[{{ $student->id }}]" value="{{ $note }}" class="w-full border rounded px-2 py-1" placeholder="Lý do...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Hủy</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Lưu Điểm Danh</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection