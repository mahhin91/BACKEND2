@extends('adminLayouts.app')

@section('content')
<div class="container-fluid px-0">
    <h1 class="mb-4">Danh sách tác giả</h1>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Ảnh đại diện</th>
                            <th>Số lượng bài viết</th>
                            <th>Danh sách bài viết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($authors as $author)
                            <tr>
                                <td>{{ $author->id }}</td>
                                <td>{{ $author->name }}</td>
                                <td>{{ $author->email }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $author->avatar) }}" alt="Ảnh đại diện" class="rounded-circle" width="48" height="48" style="object-fit:cover; border:2px solid #e2e8f0;">
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $author->posts_count }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.authors.posts', $author->id) }}">
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
                {{ $authors->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
