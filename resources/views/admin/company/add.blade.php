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
                    <a href="#">Thêm</a>
                </li>
            </ul>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:#fff">Thêm nhà cung cấp mới</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.company.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new-supplier-name">Tên người liên hệ:</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="new-supplier-name" name="name"
                                            >
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new-supplier-email">Email:</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="new-supplier-email" name="email"
                                            >
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new-supplier-phone">Số điện thoại:</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="new-supplier-phone" name="phone">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_name" class="form-label">Ngân hàng</label>
                                        <select name="bank_id" id="bank_id" class="form-control form-control-sm @error('bank_id') is-invalid @enderror">
                                            <option value="">-------- Chọn ngân hàng --------</option>
                                            @foreach ($bank as $item)
                                                <option @if (isset($data) && isset($data->bank_id) && $data->bank_id == $item->id) selected @endif
                                                    value="{{ $item->id }}">
                                                    {{ $item->shortName . ' - ' . $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new-supplier-phone">Số tài khoản:</label>
                                        <input type="text" class="form-control @error('bank_account') is-invalid @enderror" id="new-supplier-phone"
                                            name="bank_account">
                                            @error('bank_account')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new-supplier-phone">Địa chỉ:</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="new-supplier-phone" name="address">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new-supplier-phone">Mã số thuế:</label>
                                        <input type="text" class="form-control @error('tax_number') is-invalid @enderror" id="new-supplier-phone"
                                            name="tax_number">
                                            @error('tax_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="city_name" class="form-label">Khu vực</label>
                                        <select name="city_id" id="city_id" class="form-select form-select-sm @error('city_id') is-invalid @enderror">
                                            <option value="">-------- Chọn khu vực --------</option>
                                            @foreach ($cities as $city)
                                                <option @if (isset($data) && isset($data->city_id) && $data->city_id == $city->id) selected @endif
                                                    value="{{ $city->id }}">
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
                                        <label for="new-supplier-phone">Ghi chú:</label>
                                        <textarea class="form-control @error('note') is-invalid @enderror" id="new-supplier-phone" name="note"></textarea>
                                        @error('note')
                                            <span class="text-danger">{{ $message }}</span>

                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
