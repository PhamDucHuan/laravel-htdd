<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'subject', 'teacher_id', 
        'start_date', 'end_date', 'schedule', 'status'
    ];

    // Quan hệ: Một lớp thuộc về một giáo viên
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Một lớp có nhiều sinh viên
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}