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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            
            // SỬA: Thay classroom_id và attendance_date bằng class_session_id
            // Vì một buổi học (session) đã thuộc về một lớp rồi, nên không cần classroom_id ở đây nữa
            $table->foreignId('class_session_id')->constrained('class_sessions')->onDelete('cascade');
            
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            
            $table->string('status')->default('present'); // present, absent, late
            $table->text('remarks')->nullable(); // Sửa 'note' thành 'remarks' cho khớp với Controller
            $table->timestamps();
            
            // Một sinh viên chỉ có 1 bản ghi điểm danh trong 1 buổi học
            $table->unique(['class_session_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
