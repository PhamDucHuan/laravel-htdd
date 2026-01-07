@extends('layouts.client')

@section('content')
<div class="bg-blue-50 py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Về IT CENTER</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Chúng tôi không chỉ dạy lập trình, chúng tôi xây dựng tương lai công nghệ cho bạn.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c" alt="Team" class="rounded-lg shadow-xl">
        </div>
        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Tầm nhìn & Sứ mệnh</h2>
            <div class="space-y-4">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">01</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Chất lượng đào tạo</h3>
                        <p class="text-gray-600">Giáo trình luôn được cập nhật theo xu hướng công nghệ mới nhất thế giới.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">02</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Thực chiến</h3>
                        <p class="text-gray-600">Học đi đôi với hành. 70% thời lượng là thực hành dự án thực tế.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">03</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Hỗ trợ trọn đời</h3>
                        <p class="text-gray-600">Cộng đồng cựu học viên lớn mạnh, hỗ trợ nhau trong công việc.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection