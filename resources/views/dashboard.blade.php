@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    
    {{-- Sidebar --}}
    @include('layouts.sidebar') 

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
            
            {{-- XỬ LÝ DỮ LIỆU & LINK CHO TỪNG ROLE --}}
            @php
                $user = Auth::user();
                $role = $user->role;

                // Mặc định
                $stat1_link = '#'; $stat2_link = '#'; $stat3_link = '#';

                // 1. Dữ liệu cho ADMIN
                if ($role === 'admin') {
                    $stat1_title = 'Tổng Lớp học';
                    $stat1_count = \App\Models\Classroom::count();
                    $stat1_icon  = 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
                    $stat1_link  = route('classrooms.index'); // Link đến danh sách lớp

                    $stat2_title = 'Tổng Giáo viên';
                    $stat2_count = \App\Models\User::where('role', 'teacher')->count();
                    $stat2_icon  = 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z';
                    $stat2_link  = route('teachers.index'); // Link đến danh sách GV

                    $stat3_title = 'Tổng Học sinh';
                    $stat3_count = \App\Models\Student::count();
                    $stat3_icon  = 'M12 14l9-5-9-5-9 5 9 5z';
                    $stat3_link  = route('students.index'); // Link đến danh sách HS
                } 
                // 2. Dữ liệu cho TEACHER
                elseif ($role === 'teacher') {
                    $myClasses = \App\Models\Classroom::where('teacher_id', $user->id)->get();

                    $stat1_title = 'Lớp phụ trách';
                    $stat1_count = $myClasses->count();
                    $stat1_icon  = 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10';
                    $stat1_link  = '#my-classes-table'; // Cuộn xuống bảng lớp học

                    $stat2_title = 'Tổng Sinh viên';
                    $stat2_count = \App\Models\Student::whereIn('classroom_id', $myClasses->pluck('id'))->count();
                    $stat2_icon  = 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z';

                    $stat3_title = 'Trạng thái';
                    $stat3_count = 'Đang dạy';
                    $stat3_icon  = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                }
                // 3. Dữ liệu cho STUDENT
                else {
                    $studentProfile = \App\Models\Student::where('email', $user->email)->first();
                    $myClass = $studentProfile ? $studentProfile->classroom : null;

                    $stat1_title = 'Lớp của tôi';
                    $stat1_count = $myClass ? $myClass->name : 'Chưa xếp';
                    $stat1_icon  = 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
                    // Nếu muốn link chi tiết lớp cho Student, cần mở quyền truy cập route show, hiện tại để tạm #
                    
                    $stat2_title = 'GV Chủ nhiệm';
                    $stat2_count = ($myClass && $myClass->teacher) ? $myClass->teacher->name : 'N/A';
                    $stat2_icon  = 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z';

                    $stat3_title = 'Môn học';
                    $stat3_count = $myClass ? $myClass->subject : 'N/A';
                    $stat3_icon  = 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
                }
            @endphp

            @if(session('success'))
                <div class="mb-6 flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <span class="font-medium mr-2">Thành công!</span> {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tổng quan hệ thống</h2>
                    <p class="text-gray-500 text-sm mt-1">Xin chào, <span class="font-bold text-blue-600">{{ $user->name }}</span> ({{ ucfirst($role) }})</p>
                </div>
                <div class="text-sm text-gray-400 italic">Hôm nay: {{ date('d/m/Y') }}</div>
            </div>

            {{-- GRID THỐNG KÊ (Đã chuyển thành thẻ A để bấm được) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ $stat1_link }}" class="block bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wider group-hover:text-blue-600 transition-colors">{{ $stat1_title }}</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1 truncate">{{ $stat1_count }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600 group-hover:bg-blue-200 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat1_icon }}"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ $stat2_link }}" class="block bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wider group-hover:text-green-600 transition-colors">{{ $stat2_title }}</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1 truncate">{{ $stat2_count }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full text-green-600 group-hover:bg-green-200 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat2_icon }}"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ $stat3_link }}" class="block bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wider group-hover:text-purple-600 transition-colors">{{ $stat3_title }}</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1 truncate">{{ $stat3_count }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full text-purple-600 group-hover:bg-purple-200 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat3_icon }}"></path></svg>
                        </div>
                    </div>
                </a>
            </div>

            {{-- NỘI DUNG CHÍNH (BẢNG) --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                
                {{-- 1. VIEW CHO ADMIN --}}
                @if($role === 'admin')
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-700 text-lg">Lớp học gần đây</h3>
                        <a href="{{ route('classrooms.index') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">Xem tất cả</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider text-xs font-semibold">
                                <tr>
                                    <th class="px-6 py-3">Tên lớp</th>
                                    <th class="px-6 py-3">Giáo viên</th>
                                    <th class="px-6 py-3">Lịch học</th>
                                    <th class="px-6 py-3">Trạng thái</th>
                                    <th class="px-6 py-3 text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach(\App\Models\Classroom::with('teacher')->latest()->take(5)->get() as $class)
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-blue-600">
                                        <a href="{{ route('classrooms.show', $class->id) }}">{{ $class->name }}</a>
                                    </td>
                                    <td class="px-6 py-4">{{ $class->teacher->name ?? 'Chưa gán' }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $class->schedule }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $class->status == 'started' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $class->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('classrooms.show', $class->id) }}" class="text-slate-400 hover:text-blue-600 font-medium text-xs uppercase">Chi tiết &rarr;</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                {{-- 2. VIEW CHO TEACHER --}}
                @elseif($role === 'teacher')
                    {{-- Thêm ID để link cuộn xuống đây --}}
                    <div id="my-classes-table" class="px-6 py-4 border-b border-gray-200 bg-blue-50 flex justify-between items-center">
                        <h3 class="font-bold text-blue-800 text-lg">Danh sách lớp phụ trách</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-500 uppercase">
                                <tr>
                                    <th class="px-6 py-3">Tên lớp</th>
                                    <th class="px-6 py-3">Môn học</th>
                                    <th class="px-6 py-3">Lịch học</th>
                                    <th class="px-6 py-3 text-right">Điểm danh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($myClasses as $class)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $class->name }}</td>
                                    <td class="px-6 py-4">{{ $class->subject }}</td>
                                    <td class="px-6 py-4">{{ $class->schedule }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('attendance.create', $class->id) }}" class="inline-flex items-center bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 text-xs font-bold uppercase shadow transition">
                                            Điểm danh
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Bạn chưa được phân công lớp học nào.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                {{-- 3. VIEW CHO STUDENT --}}
                @else 
                    <div class="px-6 py-4 border-b border-gray-200 bg-purple-50 flex justify-between items-center">
                        <h3 class="font-bold text-purple-800 text-lg">Thông tin lớp học của bạn</h3>
                    </div>
                    <div class="p-6">
                        @if($myClass)
                            <div class="bg-white border rounded-lg p-6 flex flex-col md:flex-row gap-6">
                                <div class="flex-1">
                                    <h4 class="text-2xl font-bold text-gray-800 mb-2">{{ $myClass->name }}</h4>
                                    <p class="text-gray-500 mb-4">{{ $myClass->subject }}</p>
                                    
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="block text-gray-400 text-xs uppercase">Giáo viên</span>
                                            <span class="font-semibold">{{ $myClass->teacher->name ?? 'Chưa rõ' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-400 text-xs uppercase">Lịch học</span>
                                            <span class="font-semibold">{{ $myClass->schedule }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-400 text-xs uppercase">Ngày bắt đầu</span>
                                            <span class="font-semibold">{{ \Carbon\Carbon::parse($myClass->start_date)->format('d/m/Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-400 text-xs uppercase">Trạng thái</span>
                                            <span class="inline-block px-2 py-0.5 rounded text-xs font-bold {{ $myClass->status == 'started' ? 'bg-green-100 text-green-700' : 'bg-gray-100' }}">
                                                {{ $myClass->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex-1 border-t md:border-t-0 md:border-l pt-4 md:pt-0 md:pl-6">
                                    <h5 class="font-bold text-gray-700 mb-3">Mô tả / Ghi chú</h5>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        {{ $myClass->description ?? 'Không có mô tả thêm cho lớp học này.' }}
                                    </p>
                                    <div class="mt-4">
                                        <span class="text-xs text-gray-400">Bạn đang là thành viên của lớp này.</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-10">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <h3 class="text-lg font-medium text-gray-900">Chưa tham gia lớp học nào</h3>
                                <p class="text-gray-500 mt-1">Tài khoản của bạn chưa được thêm vào lớp học nào trên hệ thống.</p>
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </main>
    </div>
</div>
@endsection