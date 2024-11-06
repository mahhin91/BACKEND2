<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts', compact('posts'));
    }

    public function adminIndex()
    {
        $posts = DB::table('posts')->where('status', 'approved')
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->paginate(5);
        return view('admin.post.index', compact('posts'));
    }

    public function waitingApproval(Request $request)
    {
        $posts = DB::table('posts')->where('status', 'pending')
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->paginate(5);
        return view('admin.post.waitingApproval', compact('posts'));
    }

    public function listOfPostByAuthor(Request $request, $authorId)
    {
        $posts = Post::where('user_id', $authorId)->paginate(5);
        $author = User::find($authorId);
        return view('admin.post.listOfPostByAuthor', compact('posts', 'author'));
    }

    public function detailPost($id)
    {
        $post = Post::find($id);
        return view('detailPost', compact('post'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.post.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
        ]);
    
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = auth()->user()->id;
        $post->category_id = $request->input('category_id');
    
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time().'.'.$thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('storage'), $thumbnailName);
            $post->thumbnail = $thumbnailName;
        }
    
        $post->save();

        return redirect()->route('listOfPostByAuthor', auth()->user()->id)->with('success', 'Tạo bài viết thành công!');
    }

    public function approve($id)
    {
        // Logic duyệt bài viết
        $post = Post::findOrFail($id);
        $post->status = 'approved';
        $post->status = 'approved';
        $post->save();

        return redirect()->back()->with('success', 'Duyệt bài viết thành công!');
    }

    public function reject($id)
    {
        // Logic từ chối bài viết
        $post = Post::findOrFail($id);
        $post->status = 'rejected';
        $post->save();

        return redirect()->back()->with('success', 'Từ chối bài viết thành công!');
    }

    // public function edit($id)
    // {
    //     $post = Post::findOrFail($id);
    //     return view('posts.edit', compact('post'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $post = Post::findOrFail($id);

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'category_id' => 'required|exists:categories,id',
    //         'status' => 'required|in:pending,approved,rejected',
    //         'content' => 'required|string',
    //         'thumbnail' => 'nullable|image|max:2048',
    //     ]);

    //     $post->title = $request->title;
    //     $post->category_id = $request->category_id;
    //     $post->status = $request->status;
    //     $post->content = $request->content;
    //     $post->published_at = $request->published_at;

    //     if ($request->hasFile('thumbnail')) {
    //         $post->thumbnail = $request->file('thumbnail')->store('thumbnails');
    //     }

    //     $post->save();

    //     return redirect()->route('posts.index');
    // }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $author_id = $post->user_id;
        $post->delete();

        return redirect()->route('listOfPostByAuthor', $author_id);
    }

    public function like(Request $request)
    {
        $post = Post::find($request->post_id);
        if ($post) {
            $post->likes++;
            $post->save();
            return redirect()->route('detailPost', $post->id);
        } else {
            return response()->json(['error' => 'Bài viết không tồn tại']);
        }
    }

    public function unlike(Request $request)
    {
        $post = Post::find($request->post_id);
        if ($post) {
            $post->dislikes++;
            $post->save();
            return redirect()->route('detailPost', $post->id);
        } else {
            return response()->json(['error' => 'Bài viết không tồn tại']);
        }
    }
}
