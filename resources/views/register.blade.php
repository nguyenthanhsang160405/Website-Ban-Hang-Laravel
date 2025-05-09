<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Ký - Shop Online</title>
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

    <!-- Container đăng ký căn giữa dọc -->
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="row w-100">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Đăng Ký</h3>
                    </div>
                    <div class="card-body">
                        <form action="/actionRegister" method="post">
                            @csrf
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Họ và tên</label>
                                <input type="text" name="name" class="form-control" id="fullName" placeholder="Nhập họ và tên" required>
                            </div>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email" required>
                            </div>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required>
                            </div>
                            @error('password_confirm')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirm" class="form-control" id="confirmPassword" placeholder="Xác nhận mật khẩu" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Bạn đã có tài khoản? <a href="/login">Đăng nhập ngay</a></p>
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