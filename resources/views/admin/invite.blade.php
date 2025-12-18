@extends('layouts.guest') 

@section('content')
    <h2 class="text-2xl font-semibold text-center mb-6">Mời Giáo Viên Mới</h2>

    <form method="POST" action="{{ route('admin.invite.send') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nhập Email giáo viên:</label>
            <input type="email" name="email" required placeholder="teacher@example.com"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded w-full">
            Gửi Lời Mời
        </button>

        <div class="mt-4 text-center">
            <a href="{{ route('dashboard') }}" class="text-blue-500">Quay lại Dashboard</a>
        </div>
    </form>
@endsection