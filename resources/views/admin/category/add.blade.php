@extends('admin.layout.index')
@section('content')

    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs ">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.category.index') }}">Danh mục</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Thêm</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách danh mục</h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <form action="{{ route('admin.category.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="col-form-label form-label">Tên danh mục:</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="col-form-label form-label">Mô tả:</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                            rows="4"></textarea>
                                        @error('description')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> --}}
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
