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
        if (!$request->expectsJson()) {
            // Nếu người dùng đã đăng nhập và đang truy cập dashboard, không chuyển hướng
            if (Auth::check() && $request->route()->named('dashboard')) {
                return null;
            }
            return route('login'); // Chuyển hướng đến login nếu chưa đăng nhập
        }

        return null;
    }

}
