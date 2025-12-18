@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-semibold text-center mb-6">Đăng Nhập</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('email')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mật khẩu</label>
            <input id="password" type="password" name="password" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Đăng nhập
            </button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-sm text-blue-500 hover:text-blue-800">Chưa có tài khoản? Đăng ký ngay</a>
        </div>
    </form>
@endsection