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
                    <a href="#">Sửa</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white;">Danh mục số {{ $category->id }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <form action="{{ route('admin.category.update', ['id' => $category->id]) }}"
                                    id='editcategory' method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-12">
                                                <label for="example-text-input" class="form-label">Danh Mục</label>
                                                <input class="form-control" id="name" name="name"
                                                    value="{{ $category->name }}" type="text">
                                                <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                        style="font-weight: 500" id="name_error"></span> </div>
                                            </div>
                                            <div class="mb-12">
                                                <label for="example-text-input" class="form-label">Mô tả</label>
                                                <textarea class="form-control" name="description" id="description" rows="4">{!! $category->description !!}</textarea>
                                                <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                        style="font-weight: 500" id="description_error"></span> </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div style="margin: 20px; text-align: center">
                                                <button type="button" onclick="editcategory(event)"
                                                    class="btn btn-primary w-md">Xác nhận</button>
                                            </div>
                                        </div>
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
        function submitForm() {
            document.getElementById('editcategory').submit();
        }
        CKEDITOR.replace('description');
        var validateorder = {
            'name': {
                'element': document.getElementById('name'),
                'error': document.getElementById('name_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E015')
                }, ]
            },
            'description': {
                'element': document.getElementById('description'),
                'error': document.getElementById('description_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E016')
                }, ]
            },

        }

        function editcategory(event) {
            event.preventDefault();
            if (validateAllFields(validateorder)) {
                submitForm();
            }
        }
    </script>
@endsection
