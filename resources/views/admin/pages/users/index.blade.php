@extends('admin.layouts.main_layout')

@section('content')
    <div class="row bg-white p-3">
        <div class="col-lg-12">
            <h2>Danh sách người dùng</h2>
            <a
                href="{{ route('users.create') }}"
                class="btn btn-primary mb-3">Tạo mới người dùng</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->value }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-danger">Ngừng</span>
                            @endif
                        </td>
                        <td>
                            <a
                                href="{{ route('users.show', $user) }}"
                                class="btn btn-info btn-sm">Chi tiết</a>
                            <a
                                href="{{ route('users.edit', $user) }}"
                                class="btn btn-warning btn-sm">Sửa</a>
                            <form
                                action="{{ route('users.destroy', $user) }}"
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
                @endforeach
                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>
@endsection
