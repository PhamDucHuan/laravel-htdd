@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    
    {{-- 1. Sidebar: Nên tách ra file riêng để dùng chung, nhưng nếu bạn chưa tách thì dùng code này --}}
    @include('layouts.sidebar') 
    
    {{-- Nếu bạn chưa tạo file layouts/sidebar.blade.php thì hãy tạo nó với nội dung sidebar cũ --}}
    {{-- Hoặc nếu muốn dùng sidebar trực tiếp tại đây, hãy bỏ comment đoạn code sidebar cũ --}}

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
        
        <header class="md:hidden bg-white shadow-sm flex items-center justify-between p-4 z-10">
            <div class="font-bold text-lg text-blue-600">IT Center</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-gray-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8">
            
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div><span class="font-medium">Thành công!</span> {{ session('success') }}</div>
                </div>
            @endif

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tổng quan hệ thống</h2>
                    <p class="text-gray-500 text-sm mt-1">Chào mừng quay trở lại, {{ Auth::user()->name }}!</p>
                </div>
                <div class="text-sm text-gray-400 italic">Hôm nay: {{ date('d/m/Y') }}</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <a href="{{ route('classrooms.index') }}" class="block bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow cursor-pointer group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wider group-hover:text-blue-600">Lớp học</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Classroom::count() }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600 group-hover:bg-blue-200 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('teachers.index') }}" class="block bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow cursor-pointer group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wider group-hover:text-green-600">Giáo viên</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::where('role', 'teacher')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full text-green-600 group-hover:bg-green-200 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('students.index') }}" class="block bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow cursor-pointer group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wider group-hover:text-purple-600">Học sinh</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Student::count() }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full text-purple-600 group-hover:bg-purple-200 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-700 text-lg">Lớp học gần đây</h3>
                    <a href="{{ route('classrooms.index') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">Xem tất cả</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3">Tên lớp</th>
                                <th class="px-6 py-3">Giáo viên phụ trách</th>
                                <th class="px-6 py-3">Lịch học</th>
                                <th class="px-6 py-3">Trạng thái</th>
                                <th class="px-6 py-3 text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $recentClassrooms = \App\Models\Classroom::with('teacher')->latest()->take(5)->get();
                            @endphp

                            @foreach($recentClassrooms as $class)
                            <tr class="hover:bg-blue-50 transition-colors group">
                                {{-- Link tên lớp --}}
                                <td class="px-6 py-4 font-semibold">
                                    <a href="{{ route('classrooms.show', $class->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-2">
                                        {{ $class->name }}
                                        <svg class="w-4 h-4 text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </td>

                                <td class="px-6 py-4 flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                        {{ substr($class->teacher->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-gray-600">{{ $class->teacher->name ?? 'Chưa gán' }}</span>
                                </td>
                                
                                <td class="px-6 py-4 text-gray-600">{{ $class->schedule }}</td>
                                
                                <td class="px-6 py-4">
                                    @if($class->status == 'pending')
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Chờ mở</span>
                                    @elseif($class->status == 'started')
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Đang học</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">Kết thúc</span>
                                    @endif
                                </td>

                                {{-- Nút Xem chi tiết --}}
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('classrooms.show', $class->id) }}" class="text-slate-400 hover:text-blue-600 font-medium text-xs uppercase tracking-wide">
                                        Xem chi tiết &rarr;
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                            @if($recentClassrooms->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            Chưa có dữ liệu lớp học nào.
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection