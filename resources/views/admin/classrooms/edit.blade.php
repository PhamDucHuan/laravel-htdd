@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    
    {{-- Header --}}
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                ✏️ Chỉnh sửa lớp: <span class="text-blue-600">{{ $classroom->name }}</span>
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('classrooms.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                ⬅️ Quay lại danh sách
            </a>
        </div>
    </div>

    <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- CỘT TRÁI: THÔNG TIN LỚP HỌC --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Thông tin chung</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Các thông tin cơ bản của lớp học.</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tên lớp học <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $classroom->name) }}" required
                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Môn học <span class="text-red-500">*</span></label>
                            <select name="subject_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $classroom->subject == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }} ({{ $subject->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Giảng viên phụ trách <span class="text-red-500">*</span></label>
                            <select name="teacher_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ $classroom->teacher_id == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mô tả thêm</label>
                            <textarea name="description" rows="4"
                                      class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $classroom->description) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="block lg:hidden">
                     <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        💾 Lưu tất cả thay đổi
                    </button>
                </div>
            </div>

            {{-- CỘT PHẢI: DANH SÁCH HỌC VIÊN --}}
            <div class="lg:col-span-2">
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg leading-6 font-bold text-blue-900">Danh sách Học viên</h3>
                            <p class="mt-1 text-sm text-blue-700">Chỉnh sửa trực tiếp thông tin học viên tại đây.</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $classroom->students->count() }} học viên
                        </span>
                    </div>

                    @if($classroom->students->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ và Tên</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số điện thoại</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email (Không sửa)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($classroom->students as $student)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text" 
                                                       name="students[{{ $student->id }}][name]" 
                                                       value="{{ $student->name }}" 
                                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold text-gray-800"
                                                       placeholder="Nhập tên học viên">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text" 
                                                       name="students[{{ $student->id }}][phone]" 
                                                       value="{{ $student->phone }}" 
                                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                       placeholder="Số điện thoại">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center">
                                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {{ $student->email }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-10 text-center flex flex-col items-center justify-center text-gray-500">
                            <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p>Lớp này chưa có học viên nào.</p>
                        </div>
                    @endif
                    
                    {{-- Footer của bảng --}}
                    <div class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200 text-right">
                         <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-105">
                            💾 Lưu tất cả thay đổi
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection