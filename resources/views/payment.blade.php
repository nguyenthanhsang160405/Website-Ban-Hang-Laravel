<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh Toán</title>
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
    
    <!-- Nội dung Thanh Toán -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Thanh Toán</h2>
        <div class="row">
            <!-- Form thông tin thanh toán -->
            <div class="col-md-7">
                <form action="/actionPayment" method="POST">
                    @csrf
                    <h4>Thông tin giao hàng</h4>
                    <div class="mb-3">
                        @error('name')
                            {{ $message }}
                        @enderror
                        <label for="fullName" class="form-label">Họ và tên</label>
                        <input type="text" name="name" class="form-control" id="fullName" placeholder="Nhập họ và tên của bạn" value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        @error('email')
                            {{ $message }}
                        @enderror
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email của bạn" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        @error('phone')
                            {{ $message }}
                        @enderror
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Nhập số điện thoại của bạn" value="{{ old('phone') }}">
                    </div>
                    <div class="mb-3">
                        @error('address')
                            {{ $message }}
                        @enderror
                        <label for="address" class="form-label">Địa chỉ giao hàng</label>
                        <textarea name="address" class="form-control" id="address" rows="3" placeholder="Nhập địa chỉ giao hàng của bạn">{{ old('address') }}</textarea>
                    </div>
                    
                    <h4>Phương thức thanh toán</h4>
                    <div class="mb-3">
                        @error('payment')
                            {{ $message }}
                        @enderror
                        <select class="form-select" name="payment" id="paymentMethod" >
                            <option value="">Chọn phương thức thanh toán</option>
                            @foreach ($methodPayment as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                            <option value="card">Thẻ tín dụng / Thẻ ghi nợ</option>
                        </select>
                    </div>
                    
                    <!-- Thông tin thẻ (hiển thị khi chọn 'card') -->
                    <div class="mb-3" id="cardDetails" style="display: none;">
                        <label for="cardNumber" class="form-label">Số thẻ</label>
                        <input type="text" class="form-control" id="cardNumber" placeholder="Nhập số thẻ của bạn">
                    </div>
                    <div class="mb-3" id="cardExpiry" style="display: none;">
                        <label for="cardExpiryInput" class="form-label">Ngày hết hạn</label>
                        <input type="text" class="form-control" id="cardExpiryInput" placeholder="MM/YY">
                    </div>
                    <div class="mb-3" id="cardCVC" style="display: none;">
                        <label for="cardCVCInput" class="form-label">Mã CVV</label>
                        <input type="text" class="form-control" id="cardCVCInput" placeholder="CVV">
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="total_order" value="{{ $totalPrice }}">
                    @error('user_id')
                        {{ $message }}
                     @enderror
                     @error('total_order')
                        {{ $message }}
                     @enderror
                    <button type="submit" class="btn btn-primary btn-lg w-100">Đặt Hàng</button>
                </form>
            </div>
            
            <!-- Bảng tóm tắt đơn hàng -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        Tóm tắt đơn hàng
                    </div>
                    <div class="card-body">
                        <p class="card-text">Sản phẩm: {{ $quantity }} sản phẩm</p>
                        <p class="card-text">Tạm tính: {{ number_format($totalPrice,0,',') }}đ</p>
                        <p class="card-text">Phí vận chuyển: $10.00</p>
                        <hr>
                        <h5 class="card-title">Tổng cộng: {{ number_format($totalPrice,0,',') }}đ</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chân trang -->
    <footer class="bg-dark text-white text-center p-3 mt-4">
        &copy; 2025 Shop Online. All rights reserved.
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hiển thị/Ẩn thông tin thẻ dựa trên phương thức thanh toán
        document.getElementById('paymentMethod').addEventListener('change', function() {
            var cardDetails = document.getElementById('cardDetails');
            var cardExpiry = document.getElementById('cardExpiry');
            var cardCVC = document.getElementById('cardCVC');
            if (this.value === 'card') {
                cardDetails.style.display = 'block';
                cardExpiry.style.display = 'block';
                cardCVC.style.display = 'block';
            } else {
                cardDetails.style.display = 'none';
                cardExpiry.style.display = 'none';
                cardCVC.style.display = 'none';
            }
        });
    </script>
</body>
</html>