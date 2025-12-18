<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdmin; // <--- QUAN TRỌNG: Gọi Middleware CheckAdmin đã tạo
use App\Http\Controllers\ClassroomController; // Nhớ thêm use ở đầu file hoặc để ở đây nếu PHP 8+
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// --- NHÓM ROUTE KHÁCH (CHƯA ĐĂNG NHẬP) ---
Route::middleware('guest')->group(function () {
    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- NHÓM ROUTE ĐÃ ĐĂNG NHẬP (BẮT BUỘC LOGIN) ---
Route::middleware('auth')->group(function () {

    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // --- NHÓM ADMIN (Sử dụng CheckAdmin::class thay vì viết hàm trực tiếp) ---
    // ... Bên trong nhóm Route Admin (CheckAdmin)
Route::middleware(CheckAdmin::class)->prefix('admin')->group(function () {
    
    // Route cũ (Mời giáo viên)
    Route::get('/invite', [AdminController::class, 'showInviteForm'])->name('admin.invite');
    Route::post('/invite', [AdminController::class, 'sendInvite'])->name('admin.invite.send');

    // --- MỚI: QUẢN LÝ LỚP HỌC ---
    
    Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
    Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
    

    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::post('/teachers/{id}/toggle', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle');


Route::middleware(CheckAdmin::class)->prefix('admin')->group(function () {
    // ... các route cũ
    
    // --- QUẢN LÝ LỚP HỌC & SINH VIÊN ---
    // Route xem chi tiết lớp
    Route::get('/classrooms/{id}', [ClassroomController::class, 'show'])->name('classrooms.show');
    
    // Route thêm sinh viên vào lớp
    Route::post('/classrooms/{id}/students', [ClassroomController::class, 'addStudent'])->name('classrooms.addStudent');
    
    // Route xóa sinh viên (dùng hàm removeStudent)
    Route::delete('/students/{id}', [ClassroomController::class, 'removeStudent'])->name('students.destroy');

    // Route danh sách tổng quan
    Route::get('/classrooms', [ClassroomController::class, 'index'])->name('classrooms.index');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');


    Route::middleware(CheckAdmin::class)->prefix('admin')->group(function () {
    // ... code cũ
    Route::resource('subjects', SubjectController::class);
    });
});
});

});