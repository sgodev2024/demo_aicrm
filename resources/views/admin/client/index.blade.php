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
                    <a href="{{ route('admin.client.index') }}">Khách hàng</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.client.index') }}">Danh sách</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-start">
                                            <a href="{{ route('admin.client.export') }}" class="btn btn-primary">
                                                Xuất excel danh sách khách hàng
                                            </a>
                                        </div>
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                                            <form action="{{ route('admin.client.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                                <div class="input-group">

                                                    <input type="text" name="search" class="form-control form-control-sl" placeholder="Nhập số điện thoại"
                                                           value="{{ request('search') }}" aria-label="Search" aria-describedby="search-icon">
                                                </div>

                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search me-1"></i>
                                                </button>

                                                <a href="{{ route('admin.client.index') }}" class="btn btn-outline-secondary btn-danger" title="Làm mới">
                                                    <i class="fas fa-arrow-rotate-right" style="color: white"></i> {{-- icon reload --}}
                                                </a>
                                            </form>


                                        </div>
                                        <div class="col-sm-12 col-md-6 mt-2" id="delete-selected-container" style="display: none;">
                                            <button id="btn-delete-selected" class="btn" style="background: rgb(242, 91, 91); color: white" data-model='Client'> Xóa </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="client-table">
                                        @include('admin.client.table', ['clients' => $clients])

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="pagination">
                                        {{ $clients->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript code -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
    @if (session('success'))
        <script>
            $(document).ready(function() {
                $.notify({
                    icon: 'icon-bell',
                    title: 'Khách hàng',
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
@endsection
