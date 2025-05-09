<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi Tiết Sản Phẩm - Sản phẩm 1</title>
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
                @include('menu')
            </div>
        </div>
    </nav>
    
    <!-- Nội dung sản phẩm -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid" alt="Sản phẩm 1">
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p class="text-muted">Mã sản phẩm: SP0{{ $product->id }}</p>
                <h3 class="text-danger">${{ $product->price }}</h3>
                <p>Mô tả ngắn: {{ $product->describe }}</p>
                <form action="/addtocart" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="size" class="form-label">Chọn Size</label>
                        <select class="form-select" id="size" name="size">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="image" value="{{ $product->image }}">
                    <input type="hidden" name="id_pro" value="{{ $product->id }}">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" style="width: 100px;">
                    </div>
                    <button class="btn btn-primary">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
        
        <!-- Mô tả chi tiết sản phẩm -->
        <div class="row mt-4">
            <div class="col-12">
                <h4>Chi tiết sản phẩm</h4>
                <p>{{ $product->describe }}</p>
            </div>
        </div>
        
        <!-- Phần bình luận -->
        <div class="row mt-4">
            <div class="col-12">
                @if(session('id_detail_order'))
                    <h4>Bình luận</h4>
                    <form action="/comment" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label for="comment" class="form-label">Viết bình luận:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            <input type="hidden" name="id_detail_order" value="@if (session('id_detail_order'))
                                {{ session('id_detail_order') }}
                            @endif">
                            <input type="hidden" name="product_id" value="{{$product->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                @endif
            </div>
        </div>
        
        <!-- Hiển thị bình luận -->
        <div class="row mt-4">
            <div class="col-12">
                <h4>Danh sách bình luận</h4>
                @foreach ($commentss as $comment)
                    <div class="border p-2 mb-2">
                        <strong>{{ $comment->user->name }}</strong>
                        <p>{{ $comment->comments }}</p>
                        <small class="text-muted">{{ $comment->created_at ? $comment->created_at->diffForHumans() : ''}}</small>
                    </div>
                @endforeach
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
