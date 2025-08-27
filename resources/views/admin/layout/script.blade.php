    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.22.4/sweetalert2.min.js"></script>
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.js') }}"></script>
    <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('assets/js/setting-demo2.js') }}"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>

    <script src="{{ asset('global/js/toastr.js') }}?v={{ filemtime(public_path('global/js/toastr.js')) }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $(function() {
            $(document).on('click', '#check-all', function() {

                let isChecked = $(this).prop('checked');

                $('.checked-item').prop('checked', isChecked)
            })

            $(document).on('click', '.checked-item', function() {
                let total = $('.checked-item').length;
                let checked = $('.checked-item:checked').length;

                $('#check-all').prop('checked', checked === total);
            })
        })

        function handleDestroy(callback, model, id) {
            let ids = $('.checked-item:checked').map((i, el) => $(el).val()).get()

            if (ids.length === 0 && id) {
                ids = [id];
            }

            if (ids.length <= 0) return datgin.warning('Vui lòng chọn ít nhất 1 bản ghi!')

            Swal.fire({
                title: "Xác nhận xóa?",
                text: "Dữ liệu sẽ bị xóa vĩnh viễn và không thể khôi phục.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Vâng, xóa ngay!",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/admin/bulk/delete',
                        method: 'POST',
                        data: {
                            ids,
                            model
                        },
                        success: (res) => {
                            datgin.success(res.message)
                            $('input[type="checkbox"]').prop('checked', false);

                            if (typeof callback === 'function') {
                                callback(); // load lại danh sách sau khi xóa
                            }
                        },
                        error: (xhr) => {
                            datgin.error('Đã có lỗi xảy ra. Vui lòng thử lại sau!');
                        }
                    })
                }
            });
        }

        function handleChangeStatus(callback, model) {

            let ids = $('.checked-item:checked').map((i, el) => $(el).val()).get()

            if (ids.length <= 0) return datgin.warning('Vui lòng chọn ít nhất 1 bản ghi!')

            Swal.fire({
                title: "Xác nhận thay đổi trạng thái?",
                text: "Bạn có chắc chắn muốn cập nhật trạng thái cho các bản ghi đã chọn?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Vâng, cập nhật!",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/bulk/status',
                        method: 'POST',
                        data: {
                            ids,
                            model
                        },
                        success: (res) => {
                            datgin.success(res.message)
                            $('input[type="checkbox"]').prop('checked', false);

                            if (typeof callback === 'function') {
                                callback();
                            }
                        },
                        error: (xhr) => {
                            datgin.error('Đã có lỗi xảy ra. Vui lòng thử lại sau!');
                        }
                    })
                }
            });
        }
    </script>

    @stack('script')
