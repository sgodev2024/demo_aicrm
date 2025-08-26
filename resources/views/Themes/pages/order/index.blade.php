@extends('Themes.layout_staff.app')

@section('content')
    <div class="container-fluid mx-2 mt-3">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-3">
                <a href="/ban-hang  " class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-backward"></i></a>
                <h4 class="card-title mb-0">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <div class="d-flex justify-content-end align-items-center">
                        <input type="text" name="search" class="form-control me-2" style="width: 300px;"
                            placeholder="Nhập tên chi nhánh">

                        <button type="button" class="btn btn-outline-secondary" id="btn-reset"> <i class="fa-solid fa-rotate"></i></button>
                    </div>
                </div>

                <div id="table-wrapper">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $(function() {
            let currentPage = 1
            let searchText = '';

            $(document).on('click', 'a.page-link', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');
                let page = new URL(url).searchParams.get("page");

                fetchOrders(page, searchText);
            });

            function debounce(fn, delay = 500) {
                let timer;
                return function(...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => fn.apply(this, args), delay);
                };
            }

            $('input[name="search"]').on('input', debounce(function() {
                searchText = $(this).val();
                fetchOrders(1, searchText); // reset về page 1 khi search
            }));

            $('#btn-reset').click(function() {
                fetchOrders()
            })

            const fetchOrders = (page = 1, search) => {
                $.ajax({
                    url: window.location.pathname,
                    method: 'GET',
                    data: {
                        page,
                        s: search
                    },
                    success: (res) => {
                        $('#table-wrapper').html(res.html);
                    },
                    error: (xhr) => {
                        console.log(xhr);
                    }
                })
            }

            fetchOrders();
        })
    </script>
@endpush

@push('style')
    <style>
        table tr th {
            font-size: 12px;
            text-transform: uppercase;
        }
    </style>
@endpush
