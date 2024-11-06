<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Quản lý danh sách tác giả
    public function authors()
    {
        $authors = User::where('role', 'author')
                ->withCount('posts')
                ->paginate(5);
        return view('admin.authors', compact('authors'));
    }

    public function getCountPostOfUser($id)
    {
        $count = Post::where('user_id', '=', $id)->count();
        echo($count);
        return $count;
    }

    public function readers()
    {
        $readers = User::where('role', 'reader')->paginate(5);
        return view('admin.readers', compact('readers'));
    }

    // Xóa tác giả
    public function deleteAuthor(User $author)
    {
        if ($author->role == 'author') {
            $author->delete();
        }

        return redirect()->route('admin.authors.index');
    }
}
