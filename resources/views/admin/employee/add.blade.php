@extends('admin.layout.index')
@section('content')
 
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ 'admin.dashboard' }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.staff.store') }}">Nhân viên</a>
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
                        <h4 class="card-title" style="text-align: center; color:white">Thêm nhân viên mới</h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <form action="{{ route('admin.staff.add') }}" id="addemployee" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="new-user-name">Tên:</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        required>
                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="name_error"></span> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-user-email">Email:</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        required>
                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="email_error"></span> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-user-phone">Số điện thoại:</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        name="phone">
                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="phone_error"></span> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-user-address">Địa chỉ:</label>
                                                    <input type="text" class="form-control" id="address"
                                                        name="address">
                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="address_error"></span> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="new-user-password">Nơi làm việc</label>
                                                    <select class="form-control" name="storage" id="storage" required>
                                                        <option value="">Chọn kho hàng</option>
                                                        @foreach ($storage as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="storage_error"></span> </div>
                                                </div>
                                                  <div class="form-group">
                                                    <label for="new-user-password">Vai trò</label>
                                                    <select class="form-control" name="role_id" id="role_id" required>
                                                        <option value="">Chọn vai trò</option>
                                                        @foreach ($role as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="role_id_error"></span> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-user-password">Mật khẩu:</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" required>
                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="password_error"></span> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-user-password-confirm">Xác nhận mật khẩu:</label>
                                                    <input type="password" class="form-control" name="password_confirm"
                                                        id="password_confirm" required>

                                                    <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                            style="font-weight: 500" id="password_confirm_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="margin: 20px">
                                        <button style="text-align: center;" type="button" onclick="addemployee(event)"
                                            class="btn btn-primary">Thêm nhân
                                            viên</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('validator/validator.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        function submitForm() {
            document.getElementById('addemployee').submit();
        }
        var validateorder = {
            'name': {
                'element': document.getElementById('name'),
                'error': document.getElementById('name_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E037')
                }, ]
            },
            'email': {
                'element': document.getElementById('email'),
                'error': document.getElementById('email_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E038')
                }, ]
            },

            'phone': {
                'element': document.getElementById('phone'),
                'error': document.getElementById('phone_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E039')
                }, ]
            },

            'address': {
                'element': document.getElementById('address'),
                'error': document.getElementById('address_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E040')
                }, ]
            },


            'password': {
                'element': document.getElementById('password'),
                'error': document.getElementById('password_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E001')
                }, ]
            },

            'password_confirm': {
                'element': document.getElementById('password_confirm'),
                'error': document.getElementById('password_confirm_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E041')
                }, ]
            },

            'storage': {
                'element': document.getElementById('storage'),
                'error': document.getElementById('storage_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E046')
                }, ]
            },
             'role_id': {
                'element': document.getElementById('role_id'),
                'error': document.getElementById('role_id_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E047')
                }, ]
            }

        }

        function addemployee(event) {
            event.preventDefault();
            if (validateAllFields(validateorder)) {
                submitForm();
            }
        }
    </script>
@endsection
