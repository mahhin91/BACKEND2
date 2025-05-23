<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{   

    public function index()
    {
        $posts = Post::where('status', 'approved')->orderBy('published_at', 'desc')->take(6)->get();
        $categories = Category::all();
        $featuredPosts = \App\Models\Post::with('user')
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
        // Lấy danh sách bài viết mới nhất, mỗi trang hiển thị 10 bài viết
        $posts = Post::where('status', 'approved')->orderBy('published_at', 'desc')->paginate(10);
        $categories = Category::all();
        return view('post', compact('posts', 'categories'));
    }
}
