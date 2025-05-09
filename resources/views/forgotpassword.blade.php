<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quên Mật Khẩu - Shop Online</title>
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

    <!-- Container quên mật khẩu -->
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="row w-100">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Quên Mật Khẩu</h3>
                    </div>
                    <div class="card-body">
                        <form action="/confirmCode" method="post">
                            @csrf
                            <div class="mb-3">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email của bạn" value="{{ old('email') }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Gửi Yêu Cầu</button>
                            @error('error')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Quay lại <a href="/login">Đăng nhập</a></p>
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