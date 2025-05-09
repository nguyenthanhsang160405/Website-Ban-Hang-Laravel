<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt Lại Mật Khẩu - Shop Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <!-- Thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Shop Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @include('menu');
            </div>
        </div>
    </nav>

    <!-- Container đặt lại mật khẩu -->
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="row w-100">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Đặt Lại Mật Khẩu</h3>
                    </div>
                    <div class="card-body">
                        <form action="/changePassword" method="post">
                            @csrf
                            <div class="mb-3">
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="code" class="form-label">Mã xác nhận</label>
                                <input type="text" name="code" class="form-control" id="code" placeholder="Nhập mã xác nhận" value="{{ old('code') }}">
                                <input type="hidden" name="email" class="form-control" id="code" placeholder="Nhập mã xác nhận" value="{{ session('email') }}">
                            </div>
                            <div class="mb-3">
                                @error('passwordd')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                <input type="password" name="passwordd" class="form-control" id="newPassword" placeholder="Nhập mật khẩu mới" value="{{ old('passwordd') }}" >
                            </div>
                            <div class="mb-3">
                                @error('confirmpassword')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" name="confirmpassword" class="form-control" id="confirmPassword" placeholder="Xác nhận mật khẩu mới" value="{{ old('confirmpassword') }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đặt Lại Mật Khẩu</button>
                            @error('error')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Quay lại <a href="login.html">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chân trang -->
    <footer class="bg-dark text-white text-center p-3">
        &copy; 2025 Shop Online. All rights reserved.
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
