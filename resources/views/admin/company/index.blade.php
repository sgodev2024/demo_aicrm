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
                    <a href="{{ route('admin.company.index') }}">Danh sách</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="color: white; text-align: center">Danh sách nhà cung cấp</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="basic-datatables_length">
                                            <a class="btn btn-primary" href="{{ route('admin.company.add') }}">
                                                Thêm nhà cung cấp
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <form action="{{ route('admin.company.filter') }}" method="GET">
                                            <div class="dataTables_filter">
                                                <div class="input-group">
                                                    <select name="city_id" id="city_id"
                                                        class="form-control form-control-sm">
                                                        <option value="">Khu vực</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="name_filter"
                                                        class="form-control form-control-sm" placeholder="Nhập tên NCC"
                                                        value="{{ old('name') }}">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-6" id="delete-selected-container" style="display: none;">
                                        <button id="btn-delete-selected" class="btn" style="background: rgb(242, 91, 91); color: white" data-model='Company'> Xóa </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="company-table">
                                        @include('admin.company.table', ['companies' => $companies])
                                    </div>
                                    <div class="col-sm-12" id="pagination">
                                        @if ($companies instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                            {{ $companies->links('vendor.pagination.custom') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết

            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                var companyID = $(this).data('id'); // Đảm bảo điều này được thiết lập chính xác trong HTML của bạn
                var deleteUrl = '{{ route('admin.company.delete', ['id' => ':id']) }}';
                deleteUrl = deleteUrl.replace(':id', companyID);

                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật bảng công ty
                            $('#company-table').html(response.table);
                            $('#pagination').html(response
                                .pagination); // Đảm bảo bạn bao gồm phân trang trong phản hồi
                            $.notify({
                                icon: 'icon-bell',
                                title: 'Nhà cung cấp',
                                message: response.message,
                            }, {
                                type: 'success',
                                placement: {
                                    from: "bottom",
                                    align: "right"
                                },
                                time: 1000,
                            });
                        } else {
                            $.notify({
                                icon: 'icon-bell',
                                title: 'Nhà cung cấp',
                                message: response.message,
                            }, {
                                type: 'danger',
                                placement: {
                                    from: "bottom",
                                    align: "right"
                                },
                                time: 1000,
                            });
                        }
                    },
                    error: function(xhr) {
                        $.notify({
                            icon: 'icon-bell',
                            title: 'Nhà cung cấp',
                            message: 'Xóa công ty thất bại!',
                        }, {
                            type: 'danger',
                            placement: {
                                from: "bottom",
                                align: "right"
                            },
                            time: 1000,
                        });
                    }
                });
            }
        });

        @if (session('success'))
            $(document).ready(function() {
                $.notify({
                    icon: 'icon-bell',
                    title: 'Nhà cung cấp',
                    message: '{{ session('success') }}',
                }, {
                    type: 'secondary',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    time: 1000,
                });
            });
        @endif
    </script>
@endsection
