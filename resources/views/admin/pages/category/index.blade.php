@extends('admin.layouts.main_layout')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-lg-12">
            <h2>Danh sách danh mục</h2>
            <a
                href="{{ route('category.create') }}"
                class="btn btn-primary mb-3">Tạo mới danh mục</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Danh mục cha</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            {{ $category->parent ? $category->parent->name : '—' }}
                        </td>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-danger">Ngừng</span>
                            @endif
                        </td>
                        <td>
                            <a
                                href="{{ route('category.show', $category) }}"
                                class="btn btn-info btn-sm">Chi tiết</a>
                            <a
                                href="{{ route('category.edit', $category) }}"
                                class="btn btn-warning btn-sm">Sửa</a>
                            <form
                                action="{{ route('category.destroy', $category) }}"
                                method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xoá người dùng?')">Xoá
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="7"
                            class="text-center">Không có danh mục nào
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
