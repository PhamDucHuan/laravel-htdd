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
    Schema::create('subjects', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Tên môn (VD: Lập trình PHP)
        $table->string('code')->unique(); // Mã môn (VD: PHP101)
        $table->text('description')->nullable(); // Mô tả
        $table->integer('credits')->default(3); // Số tín chỉ (tùy chọn)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
