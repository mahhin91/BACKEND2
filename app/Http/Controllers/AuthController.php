<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsExceptions;

class AuthController extends Controller
{
    use LogsExceptions;

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                if (Auth::user()->role == 'reader') {
                    return redirect()->route('home');
                } else {
                    return redirect()->intended('dashboard'); // Chuyển hướng đến dashboard
                }
            }

            return redirect()->route('login')->withErrors('Thông tin đăng nhập không chính xác.');
        } catch (\Exception $e) {
            $this->logException($e, 'AuthController@authenticate');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi đăng nhập.');
        }
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
        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'birth_date' => 'required|date',
                'role' => 'required|in:reader,author'
            ]);

            // Tạo user mới
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'birth_date' => $validated['birth_date'],
                'role' => $validated['role']
            ]);

            // Chuyển hướng về trang login với thông báo thành công
            return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            $this->logException($e, 'AuthController@store');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi đăng ký.');
        }
    }
}
