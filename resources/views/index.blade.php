<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang Chủ Bán Hàng</title>
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
    
    <!-- Banner -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('storage/Black Red Minimalist Fashion Product Introduction Landscape Banner (1).png') }}" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/Black White Bold Simple Fashion Product Promotion Landscape Banner.png')}}" class="d-block w-100" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/Green Beige Simple Fashion Promotion Landscape Banner (1).png') }}" class="d-block w-100" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <!-- Danh mục sản phẩm -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Sản Phẩm Nổi Bật</h2>
        <div class="row">
            @foreach ($products as $product )
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card h-100 shadow-sm border-0">
                        <a href="/product/{{ $product->id }}" class="d-block">
                            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top img-fluid rounded-top" alt="Sản phẩm 1" style="width: 100%; height: 250px; object-fit: cover;">
                        </a>
                        <div class="card-body text-center p-3">
                            <h6 class="card-title fw-bold text-truncate">{{ $product->name }}</h6>
                            <p class="fw-bold text-black mb-2">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                            <p class="card-text small text-muted text-truncate">{{ $product->describe }}</p>
                            @if ($product->quantity <= 0)
                                <a href="#" class="btn btn-sm btn-primary w-100">Hết Hàng</a>
                            @else
                                <a href="#" class="btn btn-sm btn-primary w-100">Mua ngay</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Chân trang -->
    <footer class="bg-dark text-white text-center p-3 mt-4">
        &copy; 2025 Shop Online. All rights reserved.
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
