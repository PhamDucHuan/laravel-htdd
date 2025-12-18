@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-semibold text-center mb-6">Đăng Ký Giáo Viên</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6 border-b pb-4">
            <h3 class="text-lg font-bold text-gray-700 mb-4">1. Thông tin tài khoản</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                    <input type="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="mb-6 border-b pb-4">
            <h3 class="text-lg font-bold text-gray-700 mb-4">2. Thông tin cá nhân</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ngày sinh</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Giới tính</label>
                    <select name="gender" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CMND/CCCD</label>
                    <input type="text" name="citizen_id" value="{{ old('citizen_id') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="mb-6 border-b pb-4">
            <h3 class="text-lg font-bold text-gray-700 mb-4">3. Bằng cấp & Trình độ</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bằng cấp (Degree)</label>
                    <input type="text" name="degree" value="{{ old('degree') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Trường (University)</label>
                    <input type="text" name="university" value="{{ old('university') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Chuyên ngành (Major)</label>
                    <input type="text" name="major" value="{{ old('major') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4">4. Liên hệ người thân</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Họ tên người thân</label>
                    <input type="text" name="family_name" value="{{ old('family_name') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">SĐT người thân</label>
                    <input type="text" name="family_phone" value="{{ old('family_phone') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mối quan hệ</label>
                    <input type="text" name="family_relationship" value="{{ old('family_relationship') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 mr-4" href="{{ route('login') }}">
                Đã có tài khoản?
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Đăng ký
            </button>
        </div>
    </form>
@endsection