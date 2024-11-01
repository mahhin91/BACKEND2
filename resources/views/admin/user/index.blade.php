
php
CopyInsert
<!-- resources/views/admin/user/index.blade.php -->

@extends('adminLayouts.app')

@section('content')
    <h1>Quản lý tác giả</h1>
    <table>
        <thead>
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
                        <td>{{ $user->birth_date }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('posts.index', ['author_id' => $user->id]) }}">Xem danh sách bài viết</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection