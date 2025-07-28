@extends('admin.layout.index')
@section('content')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .form-label {
            font-weight: 500;
        }

        .form-control,
        .form-select {
            border-radius: 5px;
            box-shadow: none;
        }

        .add_product>div {
            margin-top: 20px;
        }

        .modal-footer {
            justify-content: center;
            border-top: none;
        }

        textarea.form-control {
            height: auto;
        }

        #description {
            border-radius: 5px;
        }
    </style>

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
                    <a href="{{ route('admin.product.store') }}">Sản phẩm</a>
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Thêm sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <form action="{{ route('admin.product.add') }}" method="POST" enctype="multipart/form-data"
                                    id="addproduct">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 add_product">
                                            <div>
                                                <label for="placeholderInput" class="form-label">Tên sản phẩm <font
                                                        color="red">*</font></label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    id="name" value="{{ old('name') }}">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="brand_id" class="form-label">Thương hiệu</label>
                                                <select class="form-control @error('brand_id') is-invalid @enderror"
                                                    name="brand_id" id="brand_id">
                                                    <option value="">Chọn thương hiệu</option>
                                                    @foreach ($brand as $item)
                                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="example-text-input" class="form-label">Loại Danh Mục<span
                                                        class="text text-danger">*</span></label>
                                                <select class="form-control @error('category_id') is-invalid @enderror"
                                                    name="category_id" id="category_id">
                                                    <option value="">Chọn danh mục</option>
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="example-search-input" class="form-label">Đơn vị <span
                                                        class="text text-danger">*</span></label>
                                                <input class="form-control @error('product_unit') is-invalid @enderror"
                                                    name="product_unit" type="text" id="product_unit"
                                                    value="{{ old('product_unit') }}">
                                                @error('product_unit')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-6 add_product">
                                            <div>
                                                <label for="example-search-input" class="form-label">Giá nhập <span
                                                        class="text text-danger">*</span></label>
                                                <input min='1'
                                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                                    type="number" id="price" value="{{ old('price') }}">
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="example-search-input" class="form-label">Giá bán <span
                                                        class="text text-danger">*</span></label>
                                                <input min='1'
                                                    class="form-control @error('priceBuy') is-invalid @enderror"
                                                    name="priceBuy" type="number" id="priceBuy"
                                                    value="{{ old('priceBuy') }}">
                                                @error('priceBuy')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="example-text-input" class="form-label">Ảnh sản phẩm<span
                                                        class="text text-danger">*</span></label>
                                                <input id="images" class="form-control" type="file" name="images[]"
                                                    multiple accept="image/*">
                                                @error('images')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-lg-12 add_product">
                                            <div>
                                                <label class="form-label" for="">Mô tả </label>
                                                <textarea id="description" class="form-control cols="30" rows="10" name="description">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer m-2">
                                        <button type="submit" class="btn btn-primary w-md">
                                            Xác nhận
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        CKEDITOR.replace('description');
    </script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">


    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#brand_id').select2({
                tags: true,
                placeholder: "Chọn hoặc thêm mới",
                allowClear: true
            });
        });
    </script>
@endsection
