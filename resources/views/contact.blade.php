<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liên Hệ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    
    <!-- Nội dung trang liên hệ -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Liên Hệ Chúng Tôi</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="/contact/sendEmail" method="post">
                    @csrf
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label class="form-label">Họ và Tên</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nhập họ và tên">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"  placeholder="Nhập email">
                    </div>
                    @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                    </div>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label class="form-label">Nội Dung</label>
                        <textarea name="content" value="{{ old('content') }}" class="form-control" rows="5" placeholder="Nhập nội dung liên hệ"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Gửi Liên Hệ</button>
                    @if(session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    
    <!-- Chân trang -->
    <footer class="bg-dark text-white text-center p-3 mt-4">
        &copy; 2025 Shop Online. All rights reserved.
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>