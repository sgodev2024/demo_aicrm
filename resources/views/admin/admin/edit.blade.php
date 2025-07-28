@extends('admin.layout.index')

@section('content')
    <style>
        .avatar {
            width: 75px !important;
            height: 75px !important;
            border-radius: 50% !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }
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
                    <a href="#">Trang cá nhân</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Sửa</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center" style="color:white">Thông tin Admin</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.update', ['id' => $admin->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- First Column -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Tên</label>
                                        <input id="name" class="form-control @error('name') is-invalid @enderror"
                                            name="name" type="text" value="{{ old('name', $admin->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" type="text" value="{{ old('phone', $admin->phone) }}"
                                            required>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Second Column -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input id="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" type="email" value="{{ old('email', $admin->email) }}"
                                            required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="img_url" class="form-label">Ảnh đại diện</label>
                                        <div class="custom-file">
                                            <input id="img_url"
                                                class="custom-file-input @error('img_url') is-invalid @enderror"
                                                type="file" name="img_url" accept="image/*">
                                            <label class="custom-file-label" for="img_url">Chọn ảnh</label>
                                        </div>
                                        @error('img_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <img id="profileImage"
                                            src="{{showImage(auth()->user()->img_url) }}"
                                            alt="image profile" class="avatar">
                                    </div>
                                </div>
                                <!-- Buttons Row -->
                                <div class="col-lg-12 d-flex justify-content-between">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">
                                            <i class="fas fa-check-circle"></i> Xác nhận
                                        </button>
                                        <button type="button" class="btn btn-primary w-md ms-2" data-bs-toggle="modal"
                                            data-bs-target="#changePasswordModal">
                                            <i class="fas fa-key"></i> Đổi mật khẩu
                                        </button>
                                    </div>
                                    <div>
                                        <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <button class="btn btn-danger w-md"
                                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="{{ route('admin.changePassword') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="current-password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="current-password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new-password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control @error('newPassword') is-invalid @enderror"
                                id="new-password" name="newPassword" required>
                            @error('newPassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm-password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control @error('confirmPassword') is-invalid @enderror"
                                id="confirm-password" name="confirmPassword" required>
                            @error('confirmPassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check-circle"></i> Xác
                            nhận</button>
                    </form>
                    <!-- Display Server-Side Messages -->
                    <div id="changePasswordMessage"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#changePasswordForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#changePasswordMessage').html(
                                '<div class="alert alert-success mt-3">' + response
                                .message + '</div>');
                        } else {
                            $('#changePasswordMessage').html(
                                '<div class="alert alert-danger mt-3">' + response.message +
                                '</div>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        $('#changePasswordMessage').html(
                            '<div class="alert alert-danger mt-3">Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau.</div>'
                        );
                    },
                    complete: function() {
                        $('#changePasswordModal').modal('show');
                    }
                });
            });

            $('#img_url').change(function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
    @if (session('success'))
        <script>
            $(document).ready(function() {
                $.notify({
                    icon: 'icon-bell',
                    title: 'Thông báo',
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
    <script>
        document.getElementById('img_url').addEventListener('change', function(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endsection
