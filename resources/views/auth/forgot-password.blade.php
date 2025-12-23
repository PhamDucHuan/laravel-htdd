@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-semibold text-center mb-6">Quên Mật Khẩu</h2>
    
    <div class="mb-4 text-sm text-gray-600">
        Vui lòng nhập email của bạn. Chúng tôi sẽ gửi một liên kết để bạn đặt lại mật khẩu.
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('email')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Gửi liên kết đặt lại mật khẩu
            </button>
        </div>
        
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Quay lại đăng nhập</a>
        </div>
    </form>
@endsection