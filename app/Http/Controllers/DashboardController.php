<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê bài viết
        $totalPosts = Post::count();
        $approvedPosts = Post::where('status', 'approved')->count();
        $pendingPosts = Post::where('status', 'pending')->count();
        $rejectedPosts = Post::where('status', 'rejected')->count();

        // Thống kê tương tác
        $totalViews = Post::sum('views');
        $totalLikes = Post::withCount('reactions')->whereHas('reactions', function($query) {
            $query->where('reaction_type', 'like');
        })->get()->sum('reactions_count');
        $totalDislikes = Post::withCount('reactions')->whereHas('reactions', function($query) {
            $query->where('reaction_type', 'dislike');
        })->get()->sum('reactions_count');
        $totalUsers = User::count();

        // Bài viết mới nhất
        $latestPosts = Post::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPosts',
            'approvedPosts',
            'pendingPosts',
            'rejectedPosts',
            'totalViews',
            'totalLikes',
            'totalDislikes',
            'totalUsers',
            'latestPosts'
        ));
    }
}
