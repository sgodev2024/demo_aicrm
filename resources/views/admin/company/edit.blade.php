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
                    <a href="{{ route('admin.company.index') }}">Nhà cung cấp</a>
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
                        <h4 class="card-title" style="text-align: center;color:white">Thông tin nhà cung cấp số
                            {{ $companies->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

                                <form id="editclient" action="{{ route('admin.company.update', ['id' => $companies->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Tên người liên hệ:</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $companies->name }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $companies->email }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="bank_id">Ngân hàng:</label>
                                                <select name="bank_id" id="bank_id" class="form-select form-select-sm @error('bank_id') is-invalid @enderror">
                                                    <option value="">-------- Chọn ngân hàng --------</option>
                                                    @foreach ($bank as $item)
                                                        <option value="{{ $item->id }}" @if ($companies->bank_id == $item->id) selected @endif>
                                                            {{ $item->shortName . ' - ' . $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('bank_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Địa chỉ:</label>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $companies->address }}">
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Số điện thoại:</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $companies->phone }}">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="tax_number">Mã số thuế:</label>
                                                <input type="text" class="form-control @error('tax_number') is-invalid @enderror" id="tax_number" name="tax_number" value="{{ $companies->tax_number }}">
                                                @error('tax_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="bank_account">Số tài khoản:</label>
                                                <input type="text" class="form-control @error('bank_account') is-invalid @enderror" id="bank_account" name="bank_account" value="{{ $companies->bank_account }}">
                                                @error('bank_account')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="city_id">Khu vực:</label>
                                                <select name="city_id" id="city_id" class="form-select form-select-sm @error('city_id') is-invalid @enderror">
                                                    <option value="">-------- Chọn khu vực --------</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}" @if ($companies->city_id == $city->id) selected @endif>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('city_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="note">Ghi chú:</label>
                                                <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note">{{ $companies->note }}</textarea>
                                                @error('note')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Xác nhận</button>
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
@endsection
