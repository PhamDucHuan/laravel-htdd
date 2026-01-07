@extends('layouts.client')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800">Tất Cả Khóa Học</h1>
            <p class="text-gray-600 mt-2">Chọn lộ trình phù hợp với mục tiêu của bạn</p>
        </div>

        <div class="flex justify-center gap-4 mb-8">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-full font-medium shadow-md">Tất cả</button>
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Lập trình</button>
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Thiết kế</button>
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Tin học VP</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                <div class="h-48 bg-gray-200 rounded-t-xl bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1498050108023-c5249f4df085');"></div>
                <div class="p-6">
                    <div class="text-xs font-bold text-blue-600 mb-2">LẬP TRÌNH</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Web Fullstack Developer</h3>
                    <p class="text-gray-600 text-sm mb-4">Học HTML, CSS, JS, Laravel từ A-Z. Cam kết việc làm.</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <span class="font-bold text-blue-600">12.000.000đ</span>
                        <button class="text-sm font-semibold text-gray-500 hover:text-blue-600">Chi tiết &rarr;</button>
                    </div>
                </div>
            </div>

             <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                <div class="h-48 bg-gray-200 rounded-t-xl bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0');"></div>
                <div class="p-6">
                    <div class="text-xs font-bold text-green-600 mb-2">VĂN PHÒNG</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Thành thạo Excel & MOS</h3>
                    <p class="text-gray-600 text-sm mb-4">Luyện thi chứng chỉ MOS quốc tế cấp tốc.</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <span class="font-bold text-blue-600">3.500.000đ</span>
                        <button class="text-sm font-semibold text-gray-500 hover:text-blue-600">Chi tiết &rarr;</button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                <div class="h-48 bg-gray-200 rounded-t-xl bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1626785774573-4b799312c546');"></div>
                <div class="p-6">
                    <div class="text-xs font-bold text-purple-600 mb-2">ĐỒ HỌA</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Thiết kế UI/UX App</h3>
                    <p class="text-gray-600 text-sm mb-4">Tư duy thiết kế giao diện hiện đại với Figma.</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <span class="font-bold text-blue-600">6.000.000đ</span>
                        <button class="text-sm font-semibold text-gray-500 hover:text-blue-600">Chi tiết &rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection