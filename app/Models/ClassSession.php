<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classroom; // Import model Classroom

class ClassSession extends Model
{
    use HasFactory;

    // Cho phép gán dữ liệu hàng loạt vào các cột này
    protected $fillable = [
        'classroom_id',
        'date',
        'start_time',
        'end_time',
        // 'status', // Nếu sau này bạn muốn thêm trạng thái (VD: đã điểm danh, nghỉ...)
    ];

    // Thiết lập quan hệ: Một buổi học thuộc về Một lớp học
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}