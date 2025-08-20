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
                    <a href="">Nhân viên</a>
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
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách nhân viên</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Form nhập số điện thoại -->
                                        <form action="{{ route('admin.branch.store') }}" method="GET" class="d-flex"
                                            role="search">
                                            <input type="text" name="search" class="form-control me-2" style="width: 300px;"
                                                placeholder="Nhập tên, điện thoại, email " value="{{ request('search') }}">
                                            <button class="btn btn-outline-primary" type="submit">  <i class="fas fa-search"></i></button>
                                            <a class="btn btn-outline-danger mx-2" href="{{ route('admin.branch.store') }}">  <i class="fas fa-sync-alt"></i></a>
                                        </form>

                                        <!-- Nút Thêm mới -->
                                        <a class="btn btn-primary" href="{{ route('admin.branch.addForm') }}">Thêm mới</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3" id="delete-selected-container" style="display: none;">
                                            <button id="btn-delete-selected" class="btn" style="background: rgb(242, 91, 91); color: white" data-model='User'> Xóa </button>
                                        </div>


                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 p-0">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="staff-table-container">
                                            <table id="staff-table" class="table table-hover">
                                                <!-- Table content will be dynamically updated via AJAX -->
                                                @include('admin.branch.table', ['user' => $user])
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="pagination">
                                        {{ $user->links('vendor.pagination.custom') }}
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
            // Handle delete button click
            $(document).on('click', '.btn-delete', function() {
                if (confirm('Bạn có chắc chắn muốn xóa?')) {
                    var userId = $(this).data('id');
                    var deleteUrl = '{{ route('admin.branch.delete', ['id' => ':id']) }}';
                    deleteUrl = deleteUrl.replace(':id', userId);

                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update the table and pagination with the new HTML
                                $('#staff-table-container').html(response.table);
                                $('#pagination').html(response.pagination);

                                $.notify({
                                    icon: 'icon-bell',
                                    title: 'Nhân viên',
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
                                    title: 'Nhân viên',
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
                                title: 'Nhân viên',
                                message: 'Xóa nhân viên thất bại!',
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
                $.notify({
                    icon: 'icon-bell',
                    title: 'Nhân viên',
                    message: '{{ session('success') }}',
                }, {
                    type: 'secondary',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    time: 1000,
                });
            @endif
        });
    </script>
@endsection
