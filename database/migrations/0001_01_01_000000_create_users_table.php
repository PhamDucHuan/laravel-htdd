<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/0001_01_01_000000_create_users_table.php

public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Họ tên
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        
        // --- Thêm các trường theo bangChucNang.xlsx ---
        $table->string('phone')->nullable();           // Số điện thoại
        $table->string('address')->nullable();         // Địa chỉ
        $table->date('dob')->nullable();               // Ngày sinh
        $table->string('gender')->nullable();          // Giới tính
        $table->string('citizen_id')->nullable();      // ID document (CCCD/CMND)
        
        // Thông tin bằng cấp (Qualification)
        $table->string('degree')->nullable();          // Bằng cấp
        $table->string('university')->nullable();      // Trường ĐH
        $table->string('major')->nullable();           // Chuyên ngành
        
        // Thông tin gia đình (Family info - lưu dạng JSON hoặc text nếu đơn giản)
        $table->text('family_info')->nullable();       // Lưu Name, Address, Phone người thân
        
        // Phân quyền
        $table->string('role')->default('teacher');    // 'admin' hoặc 'teacher'
        $table->tinyInteger('status')->default(1);     // 1: Active, 0: Block
        
        $table->rememberToken();
        $table->timestamps();
    });

    // ... (Giữ nguyên phần Schema::create cho password_reset_tokens và sessions bên dưới)

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
