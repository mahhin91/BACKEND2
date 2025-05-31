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
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
                ],
                'role' => 'required|in:reader,author'
            ], [
                'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ hoa, một chữ thường và một số.',
                'email.unique' => 'Email này đã được sử dụng.',
                'role.in' => 'Vai trò không hợp lệ.'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'birth_date' => $request->input('birth_date', null), // Optional field
                'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null
            ]);

            // Log thông tin đăng ký
            \Log::info('User registered', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            return redirect()->route('login')
                ->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.']);
        }
    }
}
