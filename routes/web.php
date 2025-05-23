<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Thêm route này vào đầu file
Route::redirect('/', '/home');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/detailPost/{id}', [PostController::class, 'detailPost'])->name('detailPost');
// Routes cho người dùng chưa đăng nhập
Route::get('/posts', [HomeController::class, 'getListPost'])->name('posts');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

// Routes yêu cầu người dùng đăng nhập
Route::middleware('auth')->group(function () {
    // Route đăng xuất
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Routes chỉ dành cho admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('admin/author', [AdminController::class, 'authors'])->name('author.index');
        Route::get('admin/reader', [AdminController::class, 'readers'])->name('reader.index');
        Route::get('countPost/{id}', [AdminController::class, 'getCountPostOfUser'])->name('countPost');
        Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('admin/posts/{post}/approve', [PostController::class, 'approve'])->name('approve');
        Route::post('admin/posts/{post}/reject', [PostController::class, 'reject'])->name('reject');
        Route::get('/admin/waiting-approval', [PostController::class, 'waitingApproval'])->name('waitingApproval');
    });

    // Routes dành cho author và admin
    Route::middleware(['role:admin,author'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category', [CategoryController::class, 'store'])->name('category.store');
        Route::delete('category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::get('/admin/posts/{authorId}', [PostController::class, 'listOfPostByAuthor'])->name('listOfPostByAuthor');
        Route::get('admin/posts', [PostController::class, 'adminIndex'])->name('adminIndex');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    Route::middleware(['role:author'])->group(function () {
        Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    });

    // Routes chỉ dành cho reader
    Route::middleware(['role:reader'])->group(function () {
        Route::post('/like', [PostController::class, 'like'])->name('like');
        Route::post('/unlike', [PostController::class, 'unlike'])->name('unlike');
    });
});