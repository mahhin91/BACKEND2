<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Nếu truy cập các route quản lý thì chuyển về login
            $adminPaths = [
                'dashboard',
                'admin',
                'categories',
                'category',
                'posts/create',
                'posts/store',
                // Thêm các path quản lý khác nếu có
            ];

            $path = $request->path();

            // Kiểm tra nếu path bắt đầu bằng các từ khóa quản lý
            foreach ($adminPaths as $adminPath) {
                if (str_starts_with($path, $adminPath)) {
                    return route('login');
                }
            }

            // Ngược lại, chuyển về trang home
            return route('home');
        }

        return null;
    }

}
