<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{   

    public function index()
    {
        $query = Post::where('status', 'approved');
        
        // Filter by category if selected
        if (request()->has('category')) {
            $query->where('category_id', request('category'));
        }
        
        $posts = $query->orderBy('published_at', 'desc')->take(6)->get();
        $categories = Category::all();
        $featuredPosts = Post::with('user')
            ->where('status', 'approved')
            ->orderByDesc('likes')
            ->take(4)
            ->get();

        return view('home.index', [
            'posts' => $posts,
            'categories' => $categories,
            'featuredPosts' => $featuredPosts,
        ]);
    }

    public function getListPost()
    {
        $query = Post::where('status', 'approved');
        
        // Filter by category if selected
        if (request()->has('category')) {
            $query->where('category_id', request('category'));
        }
        
        // Lấy danh sách bài viết mới nhất, mỗi trang hiển thị 10 bài viết
        $posts = $query->orderBy('published_at', 'desc')->paginate(10);
        $categories = Category::all();
        return view('post', compact('posts', 'categories'));
    }
}
