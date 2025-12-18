<aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 hidden md:flex transition-all duration-300">
    
    <div class="h-16 flex items-center justify-center border-b border-slate-700 bg-slate-800 shadow-md">
        <span class="text-xl font-bold tracking-wider uppercase text-blue-400">IT Center</span>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
        
        {{-- === DÙNG CHUNG CHO TẤT CẢ (Dashboard) === --}}
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Tổng quan
        </a>
        
        @php
            $userRole = Auth::user()->role ?? 'guest';
        @endphp

        {{-- ================================================= --}}
        {{-- MENU DÀNH CHO ADMIN (Quản lý toàn bộ) --}}
        {{-- ================================================= --}}
        @if($userRole === 'admin')
            <div class="mt-8 mb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Quản trị Hệ thống</div>

            <a href="{{ route('subjects.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('subjects.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Quản lý Môn học
            </a>

            <a href="{{ route('classrooms.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('classrooms.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Quản lý Lớp học
            </a>

            <a href="{{ route('students.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('students.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Quản lý Học sinh
            </a>
            
            <a href="{{ route('teachers.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('teachers.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Đội ngũ Giáo viên
            </a>

            <a href="{{ route('admin.invite') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.invite') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Gửi lời mời GV
            </a>

        {{-- ================================================= --}}
        {{-- MENU DÀNH CHO TEACHER (Giáo viên) --}}
        {{-- ================================================= --}}
        @elseif($userRole === 'teacher')
            <div class="mt-8 mb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Dành cho Giáo viên</div>

            {{-- Link đến Dashboard (phần bảng lớp học) --}}
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors text-slate-300 hover:bg-slate-800 hover:text-white">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Lớp học của tôi
            </a>

            {{-- Nếu bạn muốn Teacher xem danh sách học sinh của mình (cần code thêm route riêng, nhưng tạm thời trỏ về dashboard) --}}
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors text-slate-300 hover:bg-slate-800 hover:text-white">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Danh sách Sinh viên
            </a>

        {{-- ================================================= --}}
        {{-- MENU DÀNH CHO STUDENT (Học sinh) --}}
        {{-- ================================================= --}}
        @elseif($userRole === 'student')
            <div class="mt-8 mb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Dành cho Học sinh</div>

            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors text-slate-300 hover:bg-slate-800 hover:text-white">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Lớp học của tôi
            </a>

            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors text-slate-300 hover:bg-slate-800 hover:text-white">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Lịch sử Điểm danh
            </a>
        @endif
    </nav>
    
    <div class="p-4 border-t border-slate-700 bg-slate-800">
        <div class="flex items-center w-full">
            {{-- Avatar --}}
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-lg uppercase">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
            </div>
            {{-- Tên & Role --}}
            <div class="ml-3 min-w-0 flex-1">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-slate-400 truncate capitalize">
                    @if(Auth::user()->role === 'admin') Quản trị viên
                    @elseif(Auth::user()->role === 'teacher') Giáo viên
                    @else Học sinh
                    @endif
                </p>
            </div>
            
            {{-- Nút Đăng xuất --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="ml-2 p-2 text-slate-400 hover:text-red-400 transition-colors" title="Đăng xuất">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </div>
</aside>