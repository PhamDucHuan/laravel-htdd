<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AttendanceController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// --- KHÁCH ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- ĐĂNG NHẬP RỒI ---
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // --- ADMIN (Gộp tất cả vào 1 nhóm duy nhất) ---
    Route::middleware(CheckAdmin::class)->prefix('admin')->group(function () {
        
        // Mời giáo viên
        Route::get('/invite', [AdminController::class, 'showInviteForm'])->name('admin.invite');
        Route::post('/invite', [AdminController::class, 'sendInvite'])->name('admin.invite.send');

        // Quản lý Giáo viên
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('teachers.show');
        Route::post('/teachers/{id}/toggle', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle');

        // Quản lý Lớp học & Sinh viên
        Route::get('/classrooms', [ClassroomController::class, 'index'])->name('classrooms.index');
        Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
        Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
        Route::get('/classrooms/{id}', [ClassroomController::class, 'show'])->name('classrooms.show');
        Route::post('/classrooms/{id}/students', [ClassroomController::class, 'addStudent'])->name('classrooms.addStudent');
        
        // Quản lý Sinh viên (Tổng)
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::delete('/students/{id}', [ClassroomController::class, 'removeStudent'])->name('students.destroy');

        // Quản lý Môn học (Resource)
        Route::resource('subjects', SubjectController::class);

        // --- ROUTE CHO GIÁO VIÊN (Điểm danh) ---
        Route::get('/classroom/{id}/attendance', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/classroom/{id}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });
});