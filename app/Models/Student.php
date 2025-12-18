<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'dob', 'classroom_id'];

    // Sinh viên thuộc về Lớp học
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}