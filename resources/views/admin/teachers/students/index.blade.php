@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-green-800 mb-6">👨‍🎓 Danh Sách Sinh Viên Của Tôi</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Họ Tên</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Lớp</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">SĐT</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Chi tiết</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-gray-900">{{ $student->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $student->classroom->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $student->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $student->phone ?? '---' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Xem hồ sơ
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        Chưa có sinh viên nào trong các lớp bạn dạy.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection