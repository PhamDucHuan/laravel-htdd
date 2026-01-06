<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_class_sessions_table.php

    public function up()
    {
    Schema::create('class_sessions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('classroom_id')->constrained()->onDelete('cascade'); // Liên kết với lớp học
        $table->date('date');        // Ngày học (VD: 2025-12-25)
        $table->time('start_time')->nullable(); // Giờ bắt đầu
        $table->time('end_time')->nullable();   // Giờ kết thúc
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_sessions');
    }
};
