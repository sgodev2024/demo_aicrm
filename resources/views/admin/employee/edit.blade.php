@extends('admin.layout.index')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Nhân viên</a>
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
                        <h4 class="card-title" style="text-align: center; color:white">Thông tin nhân viên số
                            {{ $user->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

                                <form method="post" action="{{ route('admin.staff.update', ['id' => $user->id]) }}"
                                    id="editemployee">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user-name">Tên:</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $user->name }}">
                                                <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                        style="font-weight: 500" id="name_error"></span> </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="user-email">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}">
                                                <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                        style="font-weight: 500" id="email_error"></span> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user-address">Địa chỉ:</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ $user->address }}">
                                                <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                        style="font-weight: 500" id="address_error"></span> </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="user-phone">Số điện thoại:</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{ $user->phone }}">
                                                <div class="col-lg-9"><span class="invalid-feedback d-block"
                                                        style="font-weight: 500" id="phone_error"></span> </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="storage">Nơi làm việc:</label>
                                                <select class="form-control" name="storage_id" id="storage" required>
                                                    <!-- Initial option displaying current user's storage location -->
                                                    <option value="{{ $user->storage_id ?? '' }}">
                                                        {{ $user->storage->name ?? 'Chọn nơi làm việc' }}
                                                    </option>
                                                    <!-- Loop through storage locations to populate options -->
                                                    @foreach ($storage as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ isset($user->storage_id) && $user->storage_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <!-- Display error message if any -->
                                                <div class="col-lg-9">
                                                    <span class="invalid-feedback d-block" style="font-weight: 500"
                                                        id="storage_error"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center mt-4">
                                        <div>
                                            <button type="buttom" onclick="editemployee(event)"
                                                class="btn btn-primary w-md">Lưu</button>
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

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        function submitForm() {
            document.getElementById('editemployee').submit();
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

            'storage': {
                'element': document.getElementById('storage'),
                'error': document.getElementById('storage_error'),
                'validations': [{
                    'func': function(value) {
                        return checkRequired(value);
                    },
                    'message': generateErrorMessage('E046')
                }, ]
            }
        }

        function editemployee(event) {
            event.preventDefault();
            if (validateAllFields(validateorder)) {
                submitForm();
            }
        }
    </script>
@endsection
