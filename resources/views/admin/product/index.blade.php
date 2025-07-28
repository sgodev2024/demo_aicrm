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
                    <a href="{{ route('admin.product.store') }}">Sản phẩm</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ Route('admin.product.store') }}">Danh sách</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: center; color:white">Danh sách sản phẩm</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <div class="row">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-start">
                                            <div class="dataTables_length" id="basic-datatables_length">
                                                <a class="btn btn-primary" href="{{ route('admin.product.addForm') }}">Thêm
                                                    sản
                                                    phẩm</a>

                                                <a class="btn btn-primary"
                                                    href="{{ route('admin.product.formimport') }}">Import
                                                    excel</a>
                                                <a class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exportModal">Export
                                                    excel</a>


                                                <div class="modal fade" id="exportModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="exportModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exportModalLabel">Xuất file danh
                                                                    sách sản phẩm</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" id="category_kho">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <h6><strong>Danh sách danh mục</strong></h6>
                                                                        <!-- Tiêu đề cho danh mục -->
                                                                        <div class="form-check mb-3">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="selectAllCategories">
                                                                            <label class="form-check-label"
                                                                                for="selectAllCategories"
                                                                                style="font-size: 14px">
                                                                                Chọn tất cả danh mục
                                                                            </label>
                                                                        </div>
                                                                        <form id="checkboxForm_category">
                                                                            <div class="row">
                                                                                @foreach ($category as $item)
                                                                                    <div class="col-lg-6 mb-2">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                name='category[]'
                                                                                                type="checkbox"
                                                                                                value="{{ $item->id }}"
                                                                                                id="checkbox{{ $item->id }}">
                                                                                            <label class="form-check-label"
                                                                                                for="checkbox{{ $item->id }}">
                                                                                                {{ $item->name }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <h6><strong>Danh sách thương hiệu</strong></h6>
                                                                        <!-- Tiêu đề cho thương hiệu -->
                                                                        <div class="form-check mb-3">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="selectAllBrands">
                                                                            <label class="form-check-label"
                                                                                for="selectAllBrands"
                                                                                style="font-size: 14px">
                                                                                Chọn tất cả thương hiệu
                                                                            </label>
                                                                        </div>
                                                                        <form id="checkboxForm_brand">
                                                                            <div class="row">
                                                                                @foreach ($brand as $item)
                                                                                    <div class="col-lg-6 mb-2">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                name='brand[]'
                                                                                                type="checkbox"
                                                                                                value="{{ $item->id }}"
                                                                                                id="checkbox{{ $item->id }}">
                                                                                            <label class="form-check-label"
                                                                                                for="checkbox{{ $item->id }}">
                                                                                                {{ $item->name }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <h6><strong>Danh sách nhà cung cấp</strong></h6>
                                                                        <!-- Tiêu đề cho nhà cung cấp -->
                                                                        <div class="form-check mb-3">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="selectAllCompanies">
                                                                            <label class="form-check-label"
                                                                                for="selectAllCompanies"
                                                                                style="font-size: 14px">
                                                                                Chọn tất cả nhà cung cấp
                                                                            </label>
                                                                        </div>
                                                                        <form id="checkboxForm_company">
                                                                            <div class="row">
                                                                                @foreach ($companies as $item)
                                                                                    <div class="col-lg-6 mb-2">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input"
                                                                                                name='company[]'
                                                                                                type="checkbox"
                                                                                                value="{{ $item->id }}"
                                                                                                id="checkbox{{ $item->id }}">
                                                                                            <label class="form-check-label"
                                                                                                for="checkbox{{ $item->id }}">
                                                                                                {{ $item->name }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Hủy</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    id="exportproduct" data-dismiss="modal">Xuất</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 d-flex justify-content-end">
                                            <form action="{{ route('admin.product.productFilter') }}" method="GET"
                                                class="d-flex">
                                                <div class="dataTables_filter">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sl"
                                                            name="name" placeholder="Nhập tên sản phẩm"
                                                            value="{{ old('name') }}">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary" type="submit">  <i class="fa fa-search"></i></button>
                                                        </span>
                                                        <a class="btn btn-danger" href="{{route('admin.product.store')  }}"> <i class="fa fa-sync"></i></a>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="col-sm-12 col-md-6" id="delete-selected-container" style="display: none;">
                                            <button id="btn-delete-selected" class="btn" style="background: rgb(242, 91, 91); color: white" data-model='Product'> Xóa </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="product-table">
                                        @include('admin.product.table', ['products' => $product])
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" id="pagination">
                                        {{ $product->links('vendor.pagination.custom') }}
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
    <script>
        $(document).ready(function() {
            //Accordion functionality
            $('.accordion-button').click(function() {
                $(this).next('.accordion-content').slideToggle();
                $(this).toggleClass('active');
            });

            // Handle delete button click
            $(document).on('click', '.btn-delete', function() {
                if (confirm('Bạn có chắc chắn muốn xóa?')) {
                    var productId = $(this).data('id');
                    var deleteUrl = '{{ route('admin.product.delete', ['id' => ':id']) }}';
                    deleteUrl = deleteUrl.replace(':id', productId);

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
                                $('#product-table').html(response.table);
                                $('#pagination').html(response.pagination);

                                $.notify({
                                    icon: 'icon-bell',
                                    title: 'Sản phẩm',
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
                                    title: 'Sản phẩm',
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
                                title: 'Sản phẩm',
                                message: 'Xóa sản phẩm thất bại!',
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
                    title: 'Sản phẩm',
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

    <!-- Đảm bảo bạn đã bao gồm jQuery trong dự án của bạn -->

    <script>
        document.getElementById('selectAllCategories').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('#checkboxForm_category .form-check-input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        document.getElementById('selectAllBrands').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('#checkboxForm_brand .form-check-input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        document.getElementById('selectAllCompanies').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('#checkboxForm_company .form-check-input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#exportproduct').on('click', function() {
                const selectedCategories = $('#checkboxForm_category input[type="checkbox"]:checked')
                    .map(function() {
                        return $(this).val();
                    }).get();

                const selectedBrands = $('#checkboxForm_brand input[type="checkbox"]:checked')
                    .map(function() {
                        return $(this).val();
                    }).get();

                const selectedCompanies = $('#checkboxForm_company input[type="checkbox"]:checked')
                    .map(function() {
                        return $(this).val();
                    }).get();

                const exportUrl = '{{ route('admin.product.export1') }}';
                $.ajax({
                    url: exportUrl,
                    method: 'GET',
                    data: {
                        categories: JSON.stringify(selectedCategories),
                        brands: JSON.stringify(selectedBrands),
                        companies: JSON.stringify(selectedCompanies)
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        const url = window.URL.createObjectURL(new Blob([data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'products.xlsx');
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        $('#checkboxForm_category input[type="checkbox"]').prop('checked',
                            false);
                    },
                    error: function(xhr, status, error) {
                        console.error('Có lỗi xảy ra:', error);
                    }
                });
            });
        });
    </script>
@endsection
