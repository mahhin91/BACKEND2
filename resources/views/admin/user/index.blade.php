
php
CopyInsert
<!-- resources/views/admin/user/index.blade.php -->

@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-0">
    <h1 class="mb-4">Quản lý tác giả</h1>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ngày sinh</th>
                            <th>Email</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @if($user->role == 'author')
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary mb-1" href="{{ route('posts.index', ['author_id' => $user->id]) }}">
                                            <i class="fas fa-list"></i> Danh sách bài viết
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection