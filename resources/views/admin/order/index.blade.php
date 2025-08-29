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
                    <a href="#">Đơn hàng</a>
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
                        <h4 class="card-title" style="text-align: center; color:white">Báo cáo đơn hàng</h4>
                    </div>

                    <div class="card-body">
                        <div class="">
                            <!-- Filter Form -->
                            <form action="{{ route('admin.order.index') }}" method="GET">
                                <div class="row">
                                    <!-- Start Date Input -->
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date">Ngày bắt đầu</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                               value="{{ request('start_date') }}">
                                    </div>

                                    <!-- End Date Input -->
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date">Ngày kết thúc</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                               value="{{ request('end_date') }}">
                                    </div>

                                    <!-- Phone / Name / Email Input -->
                                    {{-- <div class="col-md-4 mb-3">
                                        <label for="phone">Tìm số điện thoại</label>
                                        <input type="text" name="search" id="phone" class="form-control"
                                               placeholder="Nhập tên, số điện thoại hoặc email"
                                               value="{{ request('search') }}">
                                    </div> --}}
                                </div>

                                <div class="row">
                                    <div class="text-center mt-2">
                                        <div class="d-inline-block">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="d-inline-block ml-2">
                                            <button type="button"
                                                onclick="window.location.href='{{ route('admin.order.index') }}'"
                                                class="btn btn-danger"><i class="fa fa-refresh"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- End Filter Form -->

                            <!-- Table -->
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="basic-datatables"
                                            class="display table table-striped table-hover dataTable" role="grid"
                                            aria-describedby="basic-datatables_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>STT</th>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Nhân viên</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Khách hàng</th>
                                                    <th>Trạng thái</th>
                                                    <th>Tổng tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($orders as $order)
                                                    <tr>
                                                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->index + 1 }}</td>
                                                        <td>
                                                            <a style="color: black; font-weight:bold"
                                                                href="{{ route('admin.order.detail', ['id' => $order->id]) }}">{{ $order->id }}</a>
                                                        </td>
                                                        <td>
                                                            <a style="color:black"
                                                                href="">
                                                                {{ $order->user->name ?? '' }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $order->created_at->format('d/m/y') }}</td>
                                                        <td>
                                                            {{-- <a style="color:black" --}}
                                                                {{-- href="{{ route('admin.client.detail', ['id' => $order->client->id]) }}"> --}}
                                                                {{ $order->client ? $order->client->name : '' }}
                                                            {{-- </a> --}}
                                                        </td>
                                                        <td>
                                                            @if ($order->status == 1)
                                                                <span class="badge badge-success">Đã thanh toán</span>
                                                            @else
                                                                <span class="badge badge-danger">Công nợ</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($order->total_money) }} vnđ</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có đơn hàng nào</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        {{ $orders->appends(request()->query())->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
