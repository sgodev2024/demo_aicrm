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
                    <a href="#">Danh sách</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách danh mục</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="basic-datatables_length">
                                            <a class="btn btn-primary" href="{{ route('admin.category.add') }}">Thêm danh
                                                mục</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <form action="{{ route('admin.category.findName') }}" method="GET">
                                            <div id="basic-datatables_filter" class="dataTables_filter">
                                                <label>Tìm kiếm:
                                                    <input name="name" type="search"
                                                        class="form-control form-control-sm" placeholder=""
                                                        aria-controls="basic-datatables">
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="mb-2" id="delete-selected-container" style="display: none;">
                                    <button id="btn-delete-selected" class="btn" style="background: rgb(242, 91, 91); color: white" data-model='Categories'> Xóa </button>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="category-table">
                                        @include('admin.category.table', ['category' => $category])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="pagination">
                                        {{ $category->links('vendor.pagination.custom') }}
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
        $(document).ready(function() {
            // Xử lý link xóa danh mục
            $(document).on('click', '.btn-delete', function() {
                if (confirm('Bạn có chắc chắn muốn xóa?')) {
                    var categoryId = $(this).data('id');
                    var deleteUrl = '{{ route('admin.category.delete', ['id' => ':id']) }}';
                    deleteUrl = deleteUrl.replace(':id', categoryId);

                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Cập nhật bảng danh mục
                                $('#category-table').html(response.table);
                                $('#pagination').html(response.pagination);
                                $.notify({
                                    icon: 'icon-bell',
                                    title: 'Danh mục',
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
                                    title: 'Danh mục',
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
                                title: 'Danh mục',
                                message: 'Xóa danh mục thất bại!',
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
        });
    </script>
@endsection
