<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Middleware\CheckAdmin;

// --- TRANG CHỦ ---
Route::get('/', function () {
    return view('welcome');
});

// --- KHÁCH (Chưa đăng nhập) ---
Route::middleware('guest')->group(function () {
    // Đăng ký (nếu có dùng)
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // --- THÊM: QUÊN MẬT KHẨU ---
    // 1. Form nhập email
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    // 2. Gửi link reset về email
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    // 3. Form nhập mật khẩu mới (Link từ email trỏ về đây)
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    // 4. Xử lý cập nhật mật khẩu mới
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // ROUTE MỚI CHO LỜI MỜI
    Route::get('/register/invite/{token}', [AuthController::class, 'showInviteRegisterForm'])->name('register.invite');
    Route::post('/register/invite', [AuthController::class, 'storeInviteRegister'])->name('register.invite.store');
});

// --- ĐÃ ĐĂNG NHẬP (Dùng chung cho Admin, Teacher, Student) ---
Route::middleware('auth')->group(function () {
    
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // ============================================================
    // CÁC ROUTE DÙNG CHUNG (GIÁO VIÊN & ADMIN ĐỀU CẦN DÙNG)
    // ============================================================

    // 1. Điểm danh (Giáo viên cần vào đây)
    Route::get('/classroom/{id}/attendance', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/classroom/{id}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

    // 2. Xem chi tiết Lớp học (Giáo viên xem lớp mình dạy)
    Route::get('/classrooms/{id}', [ClassroomController::class, 'show'])->name('classrooms.show');

    // 3. Xem hồ sơ chi tiết Sinh viên (Giáo viên xem sinh viên trong lớp)
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');

    // --- THÊM: ĐỔI MẬT KHẨU (Cho người đang đăng nhập) ---
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change.store');

    // ============================================================
    // KHU VỰC QUẢN TRỊ VIÊN (CHỈ ADMIN MỚI VÀO ĐƯỢC)
    // ============================================================
    Route::middleware(CheckAdmin::class)->prefix('admin')->group(function () {
        
        // Mời giáo viên
        Route::get('/invite', [AdminController::class, 'showInviteForm'])->name('admin.invite');
        Route::post('/invite', [AdminController::class, 'sendInvite'])->name('admin.invite.send');

        // Quản lý Giáo viên (Danh sách, chi tiết, khóa tài khoản)
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('teachers.show'); // Admin xem chi tiết GV
        Route::post('/teachers/{id}/toggle', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle');

        // Quản lý Lớp học (Tạo, Sửa, Xóa, Thêm/Bớt sinh viên)
        Route::get('/classrooms', [ClassroomController::class, 'index'])->name('classrooms.index'); // Danh sách tổng
        Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create'); // Form tạo
        Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store'); // Lưu tạo
        Route::post('/classrooms/{id}/students', [ClassroomController::class, 'addStudent'])->name('classrooms.addStudent'); // Thêm SV vào lớp
        Route::delete('/classrooms/{id}/students/{student_id}', [ClassroomController::class, 'removeStudent'])->name('classrooms.removeStudent'); // Xóa SV khỏi lớp
        
        // Quản lý Sinh viên (Danh sách tổng, Xóa)
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        // Quản lý Môn học (Full chức năng: index, create, store, edit, update, destroy)
        Route::resource('subjects', SubjectController::class);
    });
});