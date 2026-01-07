@extends('layouts.client')

@section('content')
    <section class="relative bg-blue-900 text-white py-24">
        <div class="container mx-auto px-4 text-center md:text-left">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6">Khởi Đầu Sự Nghiệp <br/><span class="text-yellow-400">Công Nghệ Số</span></h1>
                <p class="text-xl text-blue-100 mb-8">Hơn 5000 học viên đã thành công. Bạn đã sẵn sàng?</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('courses') }}" class="bg-yellow-500 text-blue-900 font-bold py-3 px-8 rounded-lg hover:bg-yellow-400">Xem Khóa Học</a>
                    <a href="{{ route('contact') }}" class="border-2 border-white text-white font-bold py-3 px-8 rounded-lg hover:bg-white hover:text-blue-900">Tư Vấn Ngay</a>
                </div>
            </div>
        </div>
    </section>

    @endsection