@extends('admin.layout.index')

@section('content')


    <style>
        /* #reportDateRange {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 500;
        }

        #reportDateRange span {
            font-weight: 700;
            color: #007bff;
        }

        /* Loader */
        .loader {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #007bff;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #error {
            color: red;

        }

        .modal-dialog {
            margin: 0 auto;
            max-width: 500px;
        }

        .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        } */
    </style>

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
                    <a href="#">Báo cáo lợi nhuận</a>
                </li>
            </ul>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 style="color: white; text-align: center" class="card-title">Báo cáo lợi nhuận</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="storageSelect">Chọn kho:</label>
                                <select id="storageSelect" class="form-control">
                                    <option value="">--- Chọn kho ---</option>
                                    @foreach ($storages as $storage)
                                        <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="periodSelect">Chọn thời gian:</label>
                                <select id="periodSelect" class="form-control">
                                    <option value="">--- Chọn thời gian ---</option>
                                    <option value="1">Hôm nay</option>
                                    <option value="2">Tuần này</option>
                                    <option value="3">Tháng này</option>
                                    <option value="4">Quý này</option>
                                    <option value="5">Năm này</option>
                                    <option value="6">Chọn ngày</option>
                                </select>
                            </div>

                            <div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog"
                                aria-labelledby="dateRangeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="dateRangeModalLabel">Chọn khoảng thời gian</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="startDate">Ngày bắt đầu:</label>
                                                <input type="date" id="startDate" class="form-control">
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="endDate">Ngày kết thúc:</label>
                                                <input type="date" id="endDate" class="form-control">
                                            </div>
                                        </div>
                                        <div>
                                            <p id="error"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="applyDateRange" class="btn btn-primary">Áp
                                                dụng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="loader" id="loader"></div>
                        </div>

                        <div class="table-responsive">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px">
                                <span id="itemCount">Số lượng mặt hàng: 0</span>
                                {{-- <div style="display: flex">
                                    <button id="exportPdf" class="btn btn-primary" style="display: none;">Xuất PDF</button>
                                </div> --}}
                            </div>

                            <table class="table table-hover" id="reportTable">
                                <thead>
                                    <tr>
                                        <th>Mã hàng</th>
                                        <th>Tên hàng</th>
                                        <th>SL Bán</th>
                                        <th>Doanh thu</th>
                                        <th>Tổng vốn</th>
                                        <th>Lợi nhuận</th>
                                        <th>Tỷ suất</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBody">
                                    <!-- Dữ liệu sẽ được chèn vào đây qua AJAX -->
                                </tbody>
                            </table>
                            <div id="pagination" class="d-flex justify-content-end mt-3"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.17/jspdf.plugin.autotable.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('admin.profit.getProfitReport') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // var exportPdfBtn = $('#exportPdf');
                    updateTable(response.product);
                    // exportPdfBtn.show();
                }
            });
            $('#storageSelect').change(function() {
                var storageId = $('#storageSelect').val();
                var periodSelect = $('#periodSelect');
                var period = $('#periodSelect').val('');
                var tableBody = $('#reportTableBody');
                const paginationContainer = $('#pagination');
                paginationContainer.empty();

                var itemCount = $('#itemCount');
                var error = $('#error');
                tableBody.empty();
                itemCount.text('Số lượng mặt hàng: 0');

                if (storageId) {
                    periodSelect.off('change').on('change', function() {
                        var period = periodSelect.val();
                        if (period == 6) {
                            $('#dateRangeModal').modal('show');
                            $('#applyDateRange').click(function() {

                                var startDate = $('#startDate').val();
                                var endDate = $('#endDate').val();
                                if (startDate && endDate) {
                                    $('#dateRangeModal').modal('hide');
                                    $.ajax({
                                        url: '{{ route('admin.profit.getProfitReportByFilter') }}',
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            storage_id: storageId,
                                            filter: period,
                                            startDate: startDate,
                                            endDate: endDate
                                        },
                                        success: function(response) {
                                            updateTable(response.product);
                                            // exportPdfBtn.show();
                                        }
                                    });
                                } else {
                                    error.html('Nhập đủ thông tin !');
                                }

                            })

                        } else {
                            $.ajax({
                                url: '{{ route('admin.profit.getProfitReportByFilter') }}',
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    storage_id: storageId,
                                    filter: period,
                                },
                                success: function(response) {
                                    updateTable(response.product);
                                    // exportPdfBtn.show();
                                }
                            });
                        }

                        // exportPdfBtn.off('click').click(function() {
                        //     if (period == 6) {
                        //         var startDate = $('#startDate').val();
                        //         var endDate = $('#endDate').val();
                        //         $.ajax({
                        //             url: '{{ route('admin.profit.getProfitReportByFilterPDF') }}',
                        //             type: 'POST',
                        //             data: {
                        //                 _token: '{{ csrf_token() }}',
                        //                 storage_id: storageId,
                        //                 filter: period,
                        //                 startDate: startDate,
                        //                 endDate: endDate
                        //             },
                        //             xhrFields: {
                        //                 responseType: 'blob'
                        //             },
                        //             success: function(response) {
                        //                 var link = document.createElement('a');
                        //                 var url = window.URL.createObjectURL(
                        //                     response);
                        //                 link.href = url;
                        //                 link.download = 'profit_report.pdf';
                        //                 document.body.appendChild(link);
                        //                 link.click();
                        //                 window.URL.revokeObjectURL(url);
                        //                 document.body.removeChild(link);
                        //             }
                        //         });

                        //     } else {
                        //         $.ajax({
                        //             url: '{{ route('admin.profit.getProfitReportByFilterPDF') }}',
                        //             type: 'POST',
                        //             data: {
                        //                 _token: '{{ csrf_token() }}',
                        //                 storage_id: storageId,
                        //                 filter: period,
                        //             },
                        //             xhrFields: {
                        //                 responseType: 'blob'
                        //             },
                        //             success: function(response) {
                        //                 var link = document.createElement('a');
                        //                 var url = window.URL.createObjectURL(
                        //                     response);
                        //                 link.href = url;
                        //                 link.download = 'profit_report.pdf';
                        //                 document.body.appendChild(link);
                        //                 link.click();
                        //                 window.URL.revokeObjectURL(url);
                        //                 document.body.removeChild(link);
                        //             }
                        //         });
                        //     }

                        // })


                    });
                }
            });

            let currentPage = 1;
            const itemsPerPage = 10;
            let fullList = [];

            function updateTable(list) {
                fullList = list; // lưu danh sách đầy đủ để phân trang
                currentPage = 1;
                renderPage(currentPage);
                setupPagination();
            }

            function renderPage(page) {
                var error = $('#error');
                var tableBody = $('#reportTableBody');
                var itemCount = $('#itemCount');

                error.html('');
                tableBody.empty();
                itemCount.text('Số lượng mặt hàng: ' + fullList.length);

                let startIndex = (page - 1) * itemsPerPage;
                let endIndex = startIndex + itemsPerPage;
                let paginatedItems = fullList.slice(startIndex, endIndex);

                paginatedItems.forEach(function(item) {
                    if (!item.product) return;

                    var newRow = `
                    <tr>
                        <td>${item.product.code}</td>
                        <td>${item.product.name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.product.price_buy * item.quantity}</td>
                        <td>${item.product.price * item.quantity}</td>
                        <td>${item.product.price_buy * item.quantity - item.product.price * item.quantity }</td>
                        <td>${(100 * (item.product.price_buy * item.quantity - item.product.price * item.quantity) / (item.product.price_buy * item.quantity)).toFixed(2)}%</td>
                    </tr>`;
                    tableBody.append(newRow);
                });
            }

            function setupPagination() {
                const totalPages = Math.ceil(fullList.length / itemsPerPage);
                const paginationContainer = $('#pagination');
                paginationContainer.empty();

                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = $(`<button class="btn btn-sm btn-outline-primary mx-1">${i}</button>`);
                    if (i === currentPage) {
                        pageBtn.addClass('active');
                    }

                    pageBtn.on('click', function() {
                        currentPage = i;
                        renderPage(currentPage);
                        setupPagination();
                    });

                    paginationContainer.append(pageBtn);
                }
            }


            $('.close').click(function() {
                $('#dateRangeModal').modal('hide');
            });

            // Khởi tạo sự kiện cho storageSelect
            $('#storageSelect').trigger('change');
        });
    </script>
@endsection
