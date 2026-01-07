<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Định nghĩa Role để dùng sau này
    const ROLE_ADMIN = 'admin';
    const ROLE_TEACHER = 'teacher';

    protected $fillable = [
        'name',
        'email',
        'password',
        // Thêm các trường mới vào đây
        'phone',
        'address',
        'dob',
        'gender',
        'citizen_id',
        'degree',
        'university',
        'major',
        'family_info',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date', // Ép kiểu ngày sinh
            'family_info' => 'array', // Tự động chuyển JSON sang mảng khi lấy ra
        ];
    }
    
    // Một giáo viên có thể dạy nhiều lớp
    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'teacher_id');
    }
}