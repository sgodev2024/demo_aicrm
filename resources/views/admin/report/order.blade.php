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
                    <a href="#">Báo cáo</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Hôm nay</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <!-- Today's Orders Section -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách đơn hàng hôm nay</h4>
                    </div>

                    <div class="card-body">
                        <div class="">
                            <!-- Table for Orders -->
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="basic-datatables"
                                            class="display table table-striped table-hover dataTable" role="grid"
                                            aria-describedby="basic-datatables_info">
                                            <thead>
                                                <tr role="row">
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
                                                        <td>
                                                            <a style="color: black; font-weight:bold"
                                                                href="{{ route('admin.order.detail', ['id' => $order->id]) }}">{{ $order->id }}</a>
                                                        </td>
                                                        <td>
                                                            <a style="color:black"
                                                                href="{{ route('admin.staff.edit', ['id' => $order->user->id]) }}">
                                                                {{ $order->user->name ?? '' }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                        <td>
                                                            <a style="color:black"
                                                                href="{{ route('admin.client.detail', ['id' => $order->client->id]) }}">
                                                                {{ $order->client->name ?? '' }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if ($order->status == 1)
                                                                <span class="badge badge-success">Đã thanh toán</span>
                                                            @else
                                                                <span class="badge badge-danger">Công nợ</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($order->total_money) }} VND</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có đơn hàng nào</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination for Orders -->
                                        {{ $orders->appends(['orders_page' => $orders->currentPage()])->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Products Section -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách sản phẩm bán được hôm nay
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="">
                            <!-- Table for Product Sales -->
                            <div id="products-sales-table_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="products-sales-table"
                                            class="display table table-striped table-hover dataTable" role="grid">
                                            <thead>
                                                <tr role="row">
                                                    <th>Tên sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Tổng tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($productSales as $productId => $sales)
                                                    @php
                                                        $product = $products->get($productId);
                                                    @endphp
                                                    @if ($product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ $sales['quantity'] }}</td>
                                                            <td>{{ number_format($sales['total']) }} VND</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Pagination for Products -->
                                        {{ $productSales->appends(['products_page' => $productSales->currentPage()])->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Button -->
        <div class="text-center mt-4">
            <button type="button" id="exportorders" class="btn btn-primary">Xuất báo cáo hàng ngày</button>
        </div>
    </div>

    <!-- Include SheetJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#exportorders').on('click', function() {
                // Fetch data from the server for the daily report
                const exportUrl = '{{ route('admin.report.orders.getDailyOrderData') }}';

                $.ajax({
                    url: exportUrl,
                    method: 'GET',
                    xhrFields: {
                        responseType: 'blob' // To receive data as a blob
                    },
                    success: function(data) {
                        // Create a URL for the blob
                        const url = window.URL.createObjectURL(new Blob([data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'daily_report.xlsx');
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        alert('Có lỗi xảy ra khi xuất báo cáo.');
                    }
                });
            });
        });
    </script>
@endsection
