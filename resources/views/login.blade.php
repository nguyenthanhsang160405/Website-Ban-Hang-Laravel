<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Nhập - Shop Online</title>
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

    <!-- Container đăng nhập được căn giữa dọc với chiều cao 90vh -->
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
        <div class="row w-100">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Đăng Nhập</h3>
                    </div>
                    <div class="card-body">
                        <form action="/login/actionLogin" method="post">
                            @csrf
                            <div class="mb-3">

                                <label for="email" class="form-label">Email</label>
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Nhập email của bạn..." required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input name="password" type="password" value="{{ old('password') }}" class="form-control" id="password" placeholder="Nhập mật khẩu..." required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Nhớ đăng nhập</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                            <a href="{{ route('auth.google') }}" class="btn btn-danger btn-lg">
                                <i class="fab fa-google"></i> Đăng nhập bằng Google
                            </a>
                            @if ($errors->has('chung'))
                                <p class="text-danger">{{ $errors->first('chung') }}</p>
                            @endif
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Bạn chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
                        <p><a href="/forgetPassword">Quên mật khẩu?</a></p>
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