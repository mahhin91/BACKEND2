<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Phương thức hiển thị danh sách bài viết chờ xác nhận
    // public function index()
    // {
    //     $pendingPosts = Post::where('status', 'pending')->get();
    //     return view('admin.posts.index', compact('pendingPosts'));
    // }

    // // Xác nhận bài viết
    // public function approve(Post $post)
    // {
    //     $post->status = 'approved';
    //     $post->publish_date = now();
    //     $post->save();

    //     return redirect()->route('admin.posts.index');
    // }

    // // Từ chối bài viết và thêm lý do
    // public function reject(Request $request, Post $post)
    // {
    //     $validated = $request->validate(['rejection_reason' => 'required|string']);

    //     $post->status = 'rejected';
    //     $post->rejection_reason = $validated['rejection_reason'];
    //     $post->save();

    //     return redirect()->route('admin.posts.index');
    // }

    // // Quản lý danh sách tác giả
    // public function manageAuthors()
    // {
    //     $authors = User::where('role', 'author')->get();
    //     return view('admin.authors.index', compact('authors'));
    // }

    // // Xóa tác giả
    // public function deleteAuthor(User $author)
    // {
    //     if ($author->role == 'author') {
    //         $author->delete();
    //     }

    //     return redirect()->route('admin.authors.index');
    // }
}
