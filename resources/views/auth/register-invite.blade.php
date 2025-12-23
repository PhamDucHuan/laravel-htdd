@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Hoàn Tất Đăng Ký</h2>
            <p class="text-gray-600 mt-2">Dành cho Giáo viên được mời tham gia hệ thống</p>
        </div>

        <form method="POST" action="{{ route('register.invite.store') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="bg-blue-50 p-4 rounded-md mb-6 border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-700 mb-4 border-b border-blue-200 pb-2">Thông Tin Tài Khoản</h3>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email đăng nhập</label>
                    <input type="email" name="email" value="{{ $email }}" readonly 
                        class="bg-gray-200 border border-gray-300 text-gray-500 rounded w-full py-2 px-3 leading-tight focus:outline-none cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-1 italic">* Email này đã được chỉ định trong lời mời và không thể thay đổi.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="password">Mật khẩu <span class="text-red-500">*</span></label>
                        <input id="password" type="password" name="password" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="password_confirmation">Xác nhận mật khẩu <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Thông Tin Cá Nhân</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-gray-700 font-bold mb-2" for="name">Họ và Tên <span class="text-red-500">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="phone">Số điện thoại <span class="text-red-500">*</span></label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="citizen_id">CCCD / CMND</label>
                        <input id="citizen_id" type="text" name="citizen_id" value="{{ old('citizen_id') }}" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="dob">Ngày sinh</label>
                        <input id="dob" type="date" name="dob" value="{{ old('dob') }}" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="gender">Giới tính</label>
                        <select id="gender" name="gender" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-white">
                            <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gender') == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="address">Địa chỉ thường trú</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Trình Độ Học Vấn</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="degree">Bằng cấp cao nhất</label>
                        <select id="degree" name="degree" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-white">
                            <option value="">-- Chọn --</option>
                            <option value="Cao đẳng" {{ old('degree') == 'Cao đẳng' ? 'selected' : '' }}>Cao đẳng</option>
                            <option value="Đại học" {{ old('degree') == 'Đại học' ? 'selected' : '' }}>Đại học</option>
                            <option value="Thạc sĩ" {{ old('degree') == 'Thạc sĩ' ? 'selected' : '' }}>Thạc sĩ</option>
                            <option value="Tiến sĩ" {{ old('degree') == 'Tiến sĩ' ? 'selected' : '' }}>Tiến sĩ</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="university">Trường đào tạo</label>
                        <input id="university" type="text" name="university" value="{{ old('university') }}" placeholder="VD: ĐH Cần Thơ"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="major">Chuyên ngành</label>
                        <input id="major" type="text" name="major" value="{{ old('major') }}" placeholder="VD: CNTT"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Thông Tin Liên Hệ Người Thân</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="family_name">Họ tên người thân</label>
                        <input id="family_name" type="text" name="family_name" value="{{ old('family_name') }}" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="family_relationship">Mối quan hệ</label>
                        <input id="family_relationship" type="text" name="family_relationship" value="{{ old('family_relationship') }}" placeholder="VD: Bố, Mẹ, Vợ..."
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="family_phone">SĐT người thân</label>
                        <input id="family_phone" type="text" name="family_phone" value="{{ old('family_phone') }}" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-bold">
                    Hủy bỏ
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-200">
                    Hoàn Tất Đăng Ký
                </button>
            </div>
        </form>
    </div>
</div>
@endsection