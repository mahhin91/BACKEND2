<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\LogsExceptions;

class PostController extends Controller
{
    use LogsExceptions;

    public function index()
    {
        $posts = Post::all();
        return view('posts', compact('posts'));
    }

    public function adminIndex()
    {
        $posts = DB::table('posts')->where('status', 'approved')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name as user_name') 
            ->paginate(5);
        return view('admin.post.index', compact('posts'));
    }

    public function waitingApproval(Request $request)
    {
        $posts = DB::table('posts')
                ->where('status', 'pending')
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->select('posts.*', 'users.name as user_name') // chọn tất cả cột từ posts và tên người dùng từ users
                ->paginate(5);
        // dd($posts);
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
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'thumbnail' => 'required|image|max:2048',
                'category_id' => 'required|exists:categories,id',
            ]);

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $path = $file->store('thumbnails', 'public');
                $validated['thumbnail'] = $path;
            }

            $validated['user_id'] = auth()->user()->id;
            $validated['status'] = 'pending';

            Post::create($validated);
            
            return redirect()->route('listOfPostByAuthor', auth()->user()->id)
                ->with('success', 'Tạo bài viết thành công!');
        } catch (\Exception $e) {
            $this->logException($e, 'PostController@store');
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function approve($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->status = 'approved';
            $post->save();
    
            return redirect()->back()->with('success', 'Duyệt bài viết thành công!');
        } catch (ModelNotFoundException $e) {
            $this->logException($e, 'PostController@approve');
            return redirect()->back()->withErrors('Bài viết không tồn tại hoặc đã được duyệt trước đó.');
        }
    }

    public function reject($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->status = 'rejected';
            $post->save();

            return redirect()->back()->with('success', 'Từ chối bài viết thành công!');
        } catch (\Exception $e) {
            $this->logException($e, 'PostController@reject');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi từ chối bài viết.');
        }
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
        try {
            $post = Post::findOrFail($id);
            $author_id = $post->user_id;
            $post->delete();

            return redirect()->route('listOfPostByAuthor', $author_id);
        } catch (\Exception $e) {
            $this->logException($e, 'PostController@destroy');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi xóa bài viết.');
        }
    }

    public function like(Request $request)
    {
        try {
            $post = Post::findOrFail($request->post_id);
            $post->likes++;
            $post->save();
            return redirect()->route('detailPost', $post->id);
        } catch (\Exception $e) {
            $this->logException($e, 'PostController@like');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi like bài viết.');
        }
    }

    public function unlike(Request $request)
    {
        try {
            $post = Post::findOrFail($request->post_id);
            $post->dislikes++;
            $post->save();
            return redirect()->route('detailPost', $post->id);
        } catch (\Exception $e) {
            $this->logException($e, 'PostController@unlike');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi unlike bài viết.');
        }
    }
}
