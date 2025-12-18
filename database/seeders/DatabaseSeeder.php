<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản Admin gốc
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com', // Tên đăng nhập
            'password' => Hash::make('123456'), // Mật khẩu
            'role' => 'admin',
            'status' => 1,
            'phone' => '0909000000', // Các trường này để giả lập
        ]);

        echo "Đã tạo xong tài khoản Admin: admin@gmail.com / 123456 \n";
    }
}