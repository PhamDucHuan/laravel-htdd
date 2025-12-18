<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('classrooms', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Tên lớp
        $table->text('description')->nullable(); // Mô tả
        $table->string('subject')->nullable(); // Môn học
        
        // Liên kết với bảng users (Giáo viên)
        $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');

        $table->date('start_date')->nullable(); // Ngày bắt đầu
        $table->date('end_date')->nullable();   // Ngày kết thúc
        $table->string('schedule')->nullable(); // Lịch học (VD: T2-T4-T6 19h)
        
        // Trạng thái: pending (chờ), started (đang học), closed (kết thúc)
        $table->string('status')->default('pending'); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
