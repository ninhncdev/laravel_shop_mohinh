@extends('admin.layouts.main_layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tạo mới danh mục</h4>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">

                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form
                            action="{{route('category.store')}}"
                            method="post">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label
                                            for="name"
                                            class="form-label">Tên danh mục</label>
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
                                            for="parent_id"
                                            class="form-label">Danh mục cha</label>
                                        <select
                                            name="parent_id"
                                            id="parent_id"
                                            class="form-control">
                                            <option value="">-- Không có --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
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
