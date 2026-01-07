@extends('layouts.app') 

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
        {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
        
        {{-- Mobile Header --}}
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
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden mt-10">
                <div class="px-6 py-4 bg-slate-800 text-white flex justify-between items-center">
                    <h2 class="text-xl font-bold">Mời Giáo Viên Mới</h2>
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white text-sm">Quay lại</a>
                </div>
                
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.invite.send') }}">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Nhập Email giáo viên:</label>
                            <input type="email" name="email" required placeholder="teacher@example.com"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded w-full flex justify-center items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Gửi Lời Mời
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection