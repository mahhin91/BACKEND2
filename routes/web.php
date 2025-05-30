<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;

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

// Routes cho người dùng chưa đăng nhập
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts', [HomeController::class, 'getListPost'])->name('posts');
Route::get('/posts/{post}', [PostController::class, 'detailPost'])->name('detailPost');
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
        Route::match(['get', 'post'], 'admin/posts/{post}/approve', [PostController::class, 'approve'])->name('approve');
        Route::match(['get', 'post'], 'admin/posts/{post}/reject', [PostController::class, 'reject'])->name('reject');
        Route::get('/admin/waiting-approval', [PostController::class, 'waitingApproval'])->name('waitingApproval');
        Route::get('/admin/posts', [PostController::class, 'adminIndex'])->name('adminIndex');
    });

    // Routes dành cho author và admin
    Route::middleware(['role:admin,author'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category', [CategoryController::class, 'store'])->name('category.store');
        Route::delete('category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // Routes chỉ dành cho author
    Route::middleware(['role:author'])->group(function () {
        Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    });

    // Routes chỉ dành cho admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Quản lý người dùng
        Route::get('/authors', [AdminController::class, 'authors'])->name('authors.index');
        Route::get('/readers', [AdminController::class, 'readers'])->name('readers.index');
        Route::get('/users/{user}/posts', [AdminController::class, 'getCountPostOfUser'])->name('users.posts.count');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        
        // Quản lý bài viết
        Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
        Route::get('/posts/waiting-approval', [AdminPostController::class, 'waitingApproval'])->name('posts.waiting');
        Route::get('/posts/{post}/approve', [AdminPostController::class, 'approve'])->name('posts.approve');
        Route::get('/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('posts.reject');
    });
});