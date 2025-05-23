@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-0">
    <h1 class="mb-4">Chờ duyệt</h1>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Tên tác giả</th>
                            <th>Ngày tạo</th>
                            <th>Ảnh minh họa</th>
                            <th>Xác nhận</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->user_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh minh họa" class="rounded" width="60" height="40" style="object-fit:cover; border:1px solid #e2e8f0;">
                                </td>
                                <td>
                                    <form action="{{ route('approve', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Xác nhận
                                        </button>
                                    </form>
                                    <form action="{{ route('reject', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i> Không xác nhận
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('detailPost', $post->id) }}">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
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