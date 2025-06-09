<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User; // Thêm dòng này nếu chưa có
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');

        // Lọc theo trạng thái nếu có
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    public function waitingApproval()
    {
        $posts = Post::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    public function approve(Post $post)
    {
        $post->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Bài viết đã được duyệt thành công.');
    }

    public function reject(Post $post)
    {
        $post->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Bài viết đã bị từ chối.');
    }

    public function listOfPostByAuthor($authorId)
    {
        $author = User::with('posts')->findOrFail($authorId);
        $posts = $author->posts()->latest()->paginate(10);

        return view('admin.post.by_author', compact('author', 'posts'));
    }
}