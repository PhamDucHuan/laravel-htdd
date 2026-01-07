@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    
    {{-- Để code gọn, tôi giả sử bạn vẫn dùng layout app và cấu trúc như dashboard --}}

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Quản lý Giáo viên</h2>
                <a href="{{ route('admin.invite') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Mời giáo viên mới
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên / Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số điện thoại</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tham gia</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($teachers as $teacher)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                            {{ substr($teacher->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $teacher->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $teacher->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $teacher->phone ?? 'Chưa cập nhật' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($teacher->status == 1)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hoạt động</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Đã khóa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $teacher->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('teachers.show', $teacher->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Xem chi tiết</a>
                                
                                <form action="{{ route('teachers.toggle', $teacher->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @if($teacher->status == 1)
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">Khóa</button>
                                    @else
                                        <button type="submit" class="text-green-600 hover:text-green-900">Mở khóa</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $teachers->links() }} {{-- Phân trang --}}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection