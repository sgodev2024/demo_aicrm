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
                    <a href="#">Danh sách</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách thương hiệu</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row mb-3">
                                    <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                        <a class="btn btn-primary" href="{{ route('admin.brand.addForm') }}">Thêm thương
                                            hiệu</a>
                                        {{-- <form action="{{ route('admin.brand.findBySupplier') }}" method="GET"
                                            class="form-inline">
                                            <div class="form-group mb-2">
                                                <label for="supplier" class="sr-only">Nhà cung cấp</label>
                                                <select class="form-control mr-2" id="supplier" name="supplier_id">
                                                    <option value="">Chọn nhà cung cấp</option>
                                                    @foreach ($supplier as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mb-2">Tìm</button>
                                        </form> --}}
                                        <form action="{{ route('admin.brand.findByName') }}" method="GET"
                                            class="form-inline">
                                            <div class="form-group mb-2">
                                                <label for="name" class="sr-only">Tên</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Nhập tên" value="{{ old('name') }}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-12" id="delete-selected-container" style="display: none;">
                                        <button id="btn-delete-selected" class="btn" style="background: rgb(242, 91, 91); color: white" data-model='Brand'> Xóa </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="brand-table">
                                        @include('admin.brand.table', ['brand' => $brand])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="pagination">
                                        {{ $brand->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault(); // Prevent the default link behavior

            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                var brandId = $(this).data('id'); // Ensure this is properly set in your HTML
                var deleteUrl = '{{ route('admin.brand.delete', ['id' => ':id']) }}';
                deleteUrl = deleteUrl.replace(':id', brandId);

                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật bảng thương hiệu
                            $('#brand-table').html(response.table);
                            $('#pagination').html(response
                            .pagination); // Ensure you include pagination in the response
                            $.notify({
                                icon: 'icon-bell',
                                title: 'Thương hiệu',
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
                                title: 'Thương hiệu',
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
                            title: 'Thương hiệu',
                            message: 'Xóa thương hiệu thất bại!',
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
    </script>

    @if (session('success'))
        <script>
            $(document).ready(function() {
                $.notify({
                    icon: 'icon-bell',
                    title: 'Thương hiệu',
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
        </script>
    @endif
    @if (session('error'))
        <script>
            $(document).ready(function() {
                $.notify({
                    icon: 'icon-bell',
                    title: 'Thương hiệu',
                    message: '{{ session('error') }}',
                }, {
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    time: 1000,
                });
            });
        </script>
    @endif
@endsection
