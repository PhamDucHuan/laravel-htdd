<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Classroom;
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
    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // --- QUÊN MẬT KHẨU ---
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // --- ĐĂNG KÝ TỪ LỜI MỜI ---
    Route::get('/register/invite/{token}', [AuthController::class, 'showInviteRegisterForm'])->name('register.invite');
    Route::post('/register/invite', [AuthController::class, 'storeInviteRegister'])->name('register.invite.store');
});

// --- ĐÃ ĐĂNG NHẬP (Admin, Teacher, Student) ---
Route::middleware('auth')->group(function () {
    
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $classrooms = [];

        // Nếu là Giáo viên -> Lấy danh sách lớp mình dạy
        if ($user->role == 'teacher') {
            $classrooms = Classroom::where('teacher_id', $user->id)->get();
        }
        // Nếu là Admin -> Lấy hết (hoặc thống kê khác)
        elseif ($user->role == 'admin') {
            $classrooms = Classroom::latest()->take(5)->get();
        }

        return view('dashboard', compact('classrooms')); 
    })->name('dashboard');

    // Đổi mật khẩu
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change.store');

    // ============================================================
    // CHỨC NĂNG DÙNG CHUNG (TEACHER & ADMIN)
    // ============================================================

    // 1. Xem chi tiết Lớp học
    Route::get('/classrooms/{id}', [ClassroomController::class, 'show'])->name('classrooms.show');

    // 2. Thêm buổi học thủ công (Manual Session)
    Route::post('/classrooms/{id}/sessions', [ClassroomController::class, 'storeSession'])->name('classrooms.sessions.store');

    // 3. Điểm danh (Theo buổi học cụ thể - Mới nhất)
    Route::get('/attendance/{session_id}', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

    // 4. Xem hồ sơ sinh viên
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');


    // ============================================================
    // KHU VỰC QUẢN TRỊ VIÊN (ADMIN)
    // ============================================================
    Route::middleware(CheckAdmin::class)->prefix('admin')->group(function () {
        
        // --- MỜI GIÁO VIÊN ---
        Route::get('/invite', [AdminController::class, 'showInviteForm'])->name('admin.invite');
        Route::post('/invite', [AdminController::class, 'sendInvite'])->name('admin.invite.send');

        // --- QUẢN LÝ GIÁO VIÊN ---
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('teachers.show');
        Route::post('/teachers/{id}/toggle', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle');

        // --- QUẢN LÝ LỚP HỌC ---
        Route::get('/classrooms', [ClassroomController::class, 'index'])->name('classrooms.index');
        Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
        Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
        
        // Thêm sinh viên vào lớp
        Route::post('/classrooms/{id}/students', [ClassroomController::class, 'addStudent'])->name('classrooms.students.add');
        
        // Xóa sinh viên KHỎI LỚP (Nhưng không xóa khỏi hệ thống)
        // Lưu ý: Route này dùng để gỡ SV khỏi lớp, cần truyền cả ID lớp và ID sinh viên nếu muốn chính xác
        // Tuy nhiên ở view show.blade.php trước đó ta dùng form trỏ tới students.destroy, nên ta dùng route dưới:
        
        // Xóa sinh viên VĨNH VIỄN (Chức năng Admin)
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        // --- QUẢN LÝ DANH SÁCH SINH VIÊN ---
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');

        // --- QUẢN LÝ MÔN HỌC ---
        Route::resource('subjects', SubjectController::class);
    });
});