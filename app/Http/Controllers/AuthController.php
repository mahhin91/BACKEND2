<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'reader') {
                return redirect()->route('home');
            } else {
                return redirect()->intended('dashboard'); // Chuyển hướng đến dashboard
            }
        }

        return redirect()->route('login')->withErrors('Thông tin đăng nhập không chính xác.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'role' => 'required|in:author,reader', // Chỉ chấp nhận 'author' hoặc 'reader'
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Kích thước tối đa 2MB
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Kiểm tra mật khẩu tối thiểu 8 ký tự
        ]);

        // Xử lý ảnh đại diện
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public'); // Lưu ảnh vào thư mục 'storage/app/public/avatars'
        }

        // Tạo người dùng mới
        User::create([
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'role' => $request->role,
            'avatar' => $avatarPath, // Lưu đường dẫn ảnh đại diện
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        // Đăng nhập tự động hoặc chuyển hướng sau khi đăng ký
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        }
    }
