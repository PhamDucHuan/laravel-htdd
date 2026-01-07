<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trung Tâm Tin Học IT CENTER</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-700 bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white p-2 rounded-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <span class="text-xl font-bold text-blue-900">IT CENTER</span>
                </a>

                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 font-medium">Trang chủ</a>
                    <a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 font-medium">Khóa học</a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 font-medium">Về chúng tôi</a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 font-medium">Liên hệ</a>
                </nav>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-blue-600">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="hidden sm:block bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-full">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white pt-12 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <span class="bg-blue-600 p-1 rounded"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></span>
                        IT CENTER
                    </h4>
                    <p class="text-gray-400 text-sm">Đào tạo công nghệ hàng đầu.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Liên kết</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Trang chủ</a></li>
                        <li><a href="{{ route('courses') }}" class="hover:text-white">Khóa học</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Liên hệ</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Cần Thơ, Việt Nam</li>
                        <li>0909 000 000</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} IT Center. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>