<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class LoadCategories
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle(Request $request, Closure $next)
        {
            $categories = Category::all();
            view()->share('categories', $categories);
            return $next($request);
        }   
}
