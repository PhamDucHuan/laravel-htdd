<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Kiểm tra xem người dùng đã đăng nhập chưa?
        // 2. Kiểm tra xem role có phải là 'admin' không?
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Nếu không phải admin, chặn lại và báo lỗi 403
            abort(403, 'Bạn không có quyền truy cập trang quản trị.');
        }

        // Nếu đúng là admin, cho phép đi tiếp
        return $next($request);
    }
}