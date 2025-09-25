@extends('admin.layouts.main_layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tạo mới người dùng</h4>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">

                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form
                            action="{{route('users.store')}}"
                            method="post">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="name"
                                            class="form-label">Tên người dùng</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            value="{{old('name')}}"
                                            id="name">
                                        @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="email"
                                            class="form-label">Email</label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            value="{{old('email')}}"
                                            id="email">
                                        @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="password"
                                            class="form-label">Password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            id="password">
                                        @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="confirmPassword"
                                            class="form-label">Xác nhận Password</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            name="password_confirmation"
                                            id="confirmPassword">
                                        @error('password_confirmation')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="phone"
                                            class="form-label">Số điện thoại</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            name="phone"
                                            value="{{old('phone')}}"
                                            id="phone">
                                        @error('phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="address"
                                            class="form-label">Địa chỉ</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="address"
                                            value="{{old('address')}}"
                                            id="address">
                                        @error('address')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="password"
                                            class="form-label">Role</label>
                                        <select
                                            class="form-select mb-3"
                                            name="role"
                                            aria-label="Default select example">
                                            <option
                                                value="customer"
                                                selected>Khách hàng
                                            </option>
                                            <option value="staff">Nhân viên</option>
                                            <option value="admin">Quản trị viên</option>
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-12 col-md-12">
                                    <div class="form-check form-switch">


                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            name="is_active"
                                            id="SwitchCheck1"
                                            checked>
                                        <label
                                            for="password"
                                            class="form-label">Trạng thái</label>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-12 mt-6">
                                    <div>
                                        <button
                                            class="btn btn-primary"
                                            type="submit">Lưu
                                        </button>
                                        <button class="btn btn-outline-primary">Quay lại</button>
                                    </div>
                                </div>
                            </div>

                            <!--end row-->
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
