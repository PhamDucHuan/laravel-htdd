@extends('layouts.app')

@section('content')
<div class="flex h-screen w-full bg-gray-100 overflow-hidden">
    @include('layouts.sidebar')

    <div class="flex-1 overflow-auto p-8">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Chi tiết Lớp học</h2>
                <p class="text-gray-500 text-sm">Quản lý thông tin và danh sách sinh viên.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Quay lại Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $classroom->name }}</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Giáo viên phụ trách</p>
                            <div class="flex items-center mt-1">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-2">
                                    {{ substr($classroom->teacher->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="font-medium">{{ $classroom->teacher->name ?? 'Chưa gán' }}</span>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Môn học</p>
                            <p class="text-gray-800">{{ $classroom->subject ?? 'Chưa cập nhật' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Lịch học</p>
                            <p class="text-gray-800 bg-gray-100 inline-block px-2 py-1 rounded text-sm">{{ $classroom->schedule }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Ngày bắt đầu</p>
                                <p class="text-sm">{{ \Carbon\Carbon::parse($classroom->start_date)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Trạng thái</p>
                                @if($classroom->status == 'pending')
                                    <span class="text-yellow-600 font-bold text-sm">Đang chờ</span>
                                @elseif($classroom->status == 'started')
                                    <span class="text-green-600 font-bold text-sm">Đang học</span>
                                @else
                                    <span class="text-gray-600 font-bold text-sm">Kết thúc</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Thêm Sinh Viên Mới</h3>
                    <form action="{{ route('classrooms.addStudent', $classroom->id) }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                                <input type="text" name="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                                + Thêm vào lớp
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-700">Danh sách Sinh viên ({{ $classroom->students->count() }})</h3>
                        <button class="text-blue-600 text-sm hover:underline">Xuất Excel</button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Liên hệ</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($classroom->students as $index => $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('students.show', $student->id) }}" class="font-medium text-blue-600 hover:underline">
                                            {{ $student->name }}
                                        </a>
                                        <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $student->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $student->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa sinh viên này khỏi lớp?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                @if($classroom->students->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        Chưa có sinh viên nào trong lớp này.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection