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
use App\Models\PostReaction;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    use LogsExceptions;

    public function index()
    {
        $posts = Post::all();
        return view('posts', compact('posts'));
    }

    public function adminIndex(Request $request)
    {
        $query = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name as user_name');

        // Thêm filter theo status nếu có
        if ($request->has('status') && in_array($request->status, ['approved', 'pending', 'rejected'])) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'approved'); // Mặc định hiển thị approved
        }

        $posts = $query->paginate(5);
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
        $post = Post::with(['user', 'category'])->findOrFail($id);
        
        // Tăng lượt xem
        $post->incrementViews();
        
        // Lấy bài viết liên quan (cùng danh mục, khác bài viết hiện tại)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();
            
        return view('detailPost', compact('post', 'relatedPosts'));
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
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
                'category_id' => 'required|exists:categories,id',
            ]);

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('thumbnails', $filename, 'public');
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

    public function like(Post $post)
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để like bài viết.');
            }

            if (auth()->user()->role !== 'reader') {
                return redirect()->back()->with('error', 'Chỉ độc giả mới có thể like bài viết.');
            }

            $user = auth()->user();
            
            // Kiểm tra xem user đã có reaction chưa
            $existingReaction = PostReaction::where('user_id', $user->id)
                ->where('post_id', $post->id)
                ->first();

            if ($existingReaction) {
                if ($existingReaction->reaction_type === 'like') {
                    // Nếu đã like thì xóa reaction
                    $existingReaction->delete();
                    $message = 'Đã bỏ like bài viết';
                } else {
                    // Nếu đang dislike thì chuyển sang like
                    $existingReaction->update(['reaction_type' => 'like']);
                    $message = 'Đã chuyển từ dislike sang like';
                }
            } else {
                // Tạo reaction mới
                PostReaction::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'reaction_type' => 'like'
                ]);
                $message = 'Đã like bài viết';
            }

            return redirect()->route('detailPost', $post->id)
                ->with('success', $message);
        } catch (\Exception $e) {
            $this->logException($e, 'PostController@like');
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi like bài viết.');
        }
    }

    public function unlike(Post $post)
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để dislike bài viết.');
            }

            if (auth()->user()->role !== 'reader') {
                return redirect()->back()->with('error', 'Chỉ độc giả mới có thể dislike bài viết.');
            }

            $user = auth()->user();

            // Kiểm tra xem user đã có reaction chưa
            $existingReaction = PostReaction::where('user_id', $user->id)
                ->where('post_id', $post->id)
                ->first();

            if ($existingReaction) {
                if ($existingReaction->reaction_type === 'dislike') {
                    // Nếu đã dislike thì xóa reaction
                    $existingReaction->delete();
                    $message = 'Đã bỏ dislike bài viết';
                } else {
                    // Nếu đang like thì chuyển sang dislike
                    $existingReaction->update(['reaction_type' => 'dislike']);
                    $message = 'Đã chuyển từ like sang dislike';
                }
            } else {
                // Tạo reaction mới
                PostReaction::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'reaction_type' => 'dislike'
                ]);
                $message = 'Đã dislike bài viết';
            }

            return redirect()->route('detailPost', $post->id)
                ->with('success', $message);
        } catch (\Exception $e) {
            $this->logException($e, 'PostController@unlike');
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi dislike bài viết.');
        }
    }
}
