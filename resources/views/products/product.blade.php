<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sản Phẩm</title>

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
    
    <!-- Bộ lọc sản phẩm -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Danh Sách Sản Phẩm</h2>
        <div class="row">
            <!-- Bộ lọc bên phải -->
            <div class="col-md-3">
                <form action="/products/{{ $idPage }}" method="get">
                    @csrf
                    <div class="mb-3">
                        <label for="sort" class="form-label">Sắp xếp theo:</label>
                        <select class="form-select" name="sort" id="sort">
                            <option value="default">Mặc định</option>
                            <option value="low-high">Giá: Thấp → Cao</option>
                            <option value="high-low">Giá: Cao → Thấp</option>
                            <option value="a-z">Tên: A → Z</option>
                            <option value="z-a">Tên: Z → A</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </form>
            </div>
            <!-- Danh sách sản phẩm -->
            <div class="col-md-9">
                <div class="row">
                    @foreach ($productInPage as $product )
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="card h-100 shadow-sm border-0">
                                <a href="/product/{{ $product->id }}" class="d-block">
                                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top img-fluid rounded-top" alt="Sản phẩm 1" style="width: 100%; height: 250px; object-fit: cover;">
                                </a>
                                <div class="card-body text-center p-3">
                                    <h6 class="card-title fw-bold text-truncate">{{ $product->name }}</h6>
                                    <p class="fw-bold text-black mb-2">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                                    <p class="card-text small text-muted text-truncate">{{ $product->describe }}</p>
                                    <a href="#" class="btn btn-sm btn-primary w-100">Mua ngay</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Phân trang -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Trước</a>
                        </li>
                        @for ($i = 1 ; $i <= $numberPage ; $i++ )
                            <li class="page-item {{ $i == $idPage ? 'active' : '' }}"><a class="page-link" href="/products/{{ $i }}">{{ $i }}</a></li>
                        @endfor
                        <li class="page-item">
                            <a class="page-link" href="#">Tiếp</a>
                        </li>
                    </ul>
                </nav>
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