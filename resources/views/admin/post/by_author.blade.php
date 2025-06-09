@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-0">
    <h1 class="mb-4">Danh sách bài viết của tác giả: {{ $author->name }}</h1>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    @if($post->status == 'approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @elseif($post->status == 'pending')
                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                    @elseif($post->status == 'rejected')
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{-- Duyệt --}}
                                    @if($post->status != 'approved')
                                        <a href="{{ route('admin.posts.approve', $post->id) }}" class="btn btn-success btn-sm" 
                                            onclick="return confirm('Bạn có chắc muốn duyệt bài viết này?')">
                                            Duyệt
                                        </a>
                                    @endif
                                    {{-- Hủy duyệt --}}
                                    @if($post->status != 'rejected')
                                        <a href="{{ route('admin.posts.reject', $post->id) }}" class="btn btn-warning btn-sm" 
                                            onclick="return confirm('Bạn có chắc muốn hủy duyệt bài viết này?')">
                                            Hủy duyệt
                                        </a>
                                    @endif
                                    {{-- Xóa --}}
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection