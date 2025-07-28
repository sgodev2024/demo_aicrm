@extends('admin.layout.index')

@section('content')

    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.brand.store') }}">Thương hiệu</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Sửa</a>
                </li>
            </ul>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="color:white">Thương hiệu số {{ $brand->id }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brand.update', ['id' => $brand->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand-name">Tên:</label>
                                        <input type="text" class="form-control" id="brand-name" name="name"
                                            value="{{ $brand->name }}">
                                    </div>


                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand-logo">Logo:</label>
                                        <input type="file" class="form-control" id="brand-logo" name="images">
                                        <img class="img-fluid" src="{{ showImage($brand->logo) }}" alt="Brand Logo" class="brand-logo">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="save-brand-details">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
