@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    {{-- @include('layouts.sidebar') --}}
    
    <div class="flex-1 overflow-auto p-8">
        <div class="max-w-4xl mx-auto bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center bg-gray-50 border-b">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Hồ sơ Giáo viên</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Chi tiết thông tin cá nhân và bằng cấp.</p>
                </div>
                <a href="{{ route('teachers.index') }}" class="text-sm text-blue-600 hover:text-blue-500">Quay lại danh sách</a>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Họ và tên</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $teacher->name }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $teacher->email }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Số điện thoại</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $teacher->phone }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Địa chỉ</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $teacher->address }}</dd>
                    </div>

                    <div class="bg-blue-50 px-4 py-3 sm:px-6">
                        <h4 class="font-bold text-blue-800">Thông tin Bằng cấp (Qualification)</h4>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Bằng cấp / Chuyên ngành</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $teacher->degree }} - {{ $teacher->major }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Trường đào tạo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $teacher->university }}</dd>
                    </div>

                    <div class="bg-blue-50 px-4 py-3 sm:px-6">
                        <h4 class="font-bold text-blue-800">Thông tin Gia đình</h4>
                    </div>
                    <div class="bg-white px-4 py-5 sm:px-6">
                        @if($teacher->family_info)
                            <ul class="list-disc pl-5 text-sm text-gray-900">
                                <li><strong>Họ tên:</strong> {{ $teacher->family_info['name'] ?? '' }}</li>
                                <li><strong>SĐT:</strong> {{ $teacher->family_info['phone'] ?? '' }}</li>
                                <li><strong>Quan hệ:</strong> {{ $teacher->family_info['relationship'] ?? '' }}</li>
                            </ul>
                        @else
                            <span class="text-sm text-gray-500">Chưa cập nhật thông tin</span>
                        @endif
                    </div>
                </dl>s
            </div>
        </div>
    </div>
</div>
@endsection