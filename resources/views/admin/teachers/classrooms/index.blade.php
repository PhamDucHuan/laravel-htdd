@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">🏫 Lớp Học Của Tôi</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classrooms as $class)
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition">
            <div class="bg-blue-600 p-4">
                <h3 class="text-white font-bold text-lg">{{ $class->name }}</h3>
                <span class="text-blue-100 text-sm">{{ $class->subject }}</span>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center text-gray-600 mb-4">
                    <span>👨‍🎓 Sĩ số:</span>
                    <span class="font-bold text-gray-800">{{ $class->students_count }} SV</span>
                </div>
                <div class="flex justify-between items-center text-gray-600 mb-6">
                    <span>📅 Lịch học:</span>
                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $class->schedule ?? 'Chưa cập nhật' }}</span>
                </div>
                
                <a href="{{ route('classrooms.show', $class->id) }}" 
                   class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 font-bold py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                    Vào lớp & Điểm danh &rarr;
                </a>
            </div>
        </div>
        @empty
        <p class="text-gray-500 italic col-span-3 text-center">Bạn chưa được phân công lớp học nào.</p>
        @endforelse
    </div>
</div>
@endsection