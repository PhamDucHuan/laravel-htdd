@extends('layouts.client')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Liên hệ với chúng tôi</h1>
            <p class="text-gray-600 mb-8">Để lại thông tin, bộ phận tư vấn sẽ gọi lại cho bạn trong vòng 24h.</p>
            
            <form class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Họ và tên</label>
                    <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 bg-gray-50" placeholder="Nguyễn Văn A">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 bg-gray-50" placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nội dung cần tư vấn</label>
                    <textarea rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 bg-gray-50" placeholder="Tôi quan tâm khóa học..."></textarea>
                </div>
                <button type="button" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition w-full md:w-auto">
                    Gửi tin nhắn
                </button>
            </form>
        </div>

        <div class="bg-blue-900 text-white rounded-xl p-8 shadow-2xl">
            <h3 class="text-2xl font-bold mb-6">Thông tin liên hệ</h3>
            <ul class="space-y-6">
                <li class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Số 123, Đường 3/2, Quận Ninh Kiều,<br>Thành phố Cần Thơ</span>
                </li>
                <li class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>0909 000 000 (Hotline)</span>
                </li>
                <li class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>tuvan@itcenter.edu.vn</span>
                </li>
            </ul>
            
            <div class="mt-8 h-48 bg-blue-800 rounded-lg flex items-center justify-center text-blue-400 text-sm">
                [Khu vực bản đồ Google Maps]
            </div>
        </div>
    </div>
</div>
@endsection