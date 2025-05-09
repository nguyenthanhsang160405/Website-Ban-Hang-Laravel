<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giỏ Hàng</title>
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

    <!-- Nội dung Giỏ Hàng -->
    <div class="container mt-4 h-100 vh-100" >
        <h2 class="text-center mb-4">Giỏ Hàng Của Bạn</h2>
        <div class="table-responsive">
            @php
                $totalCart = 0;
            @endphp
            @unless(!$carts)
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Size</th>
                            <th>Tổng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>              
                        @if(Auth::check())
                            @foreach ($carts as $index => $cart)
                                @php
                                    $totalPrice = $cart->price * $cart->quantity;
                                    $totalCart += $totalPrice;
                                   
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $cart->name }}</td>
                                    <td><img src="{{ asset('storage/'.$cart->image)}}" width="100px" alt=""></td>
                                    <td>{{  number_format($cart->price)  }}đ</td>
                                    <td>
                                        <input type="number" onchange="updateCart({{ $cart->id }},this.value)" value="{{ $cart->quantity }}" min="1" class="form-control"  style="width: 80px;">
                                    </td>
                                    <td>{{ $cart->size }}</td>
                                    <td>{{  number_format($totalPrice) }}</td>
                                    <td>
                                        <a href="/deleteCart/{{ $cart->id }}" class="btn btn-danger btn-sm">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($carts as $index => $cart)
                                @php
                                    $totalPrice = $cart['price'] * $cart['quantity'];
                                    $totalCart += $totalPrice;
                                @endphp
                                
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $cart['name'] }}</td>
                                    <td><img src="{{asset('storage/'.$cart['image'])}}" width="100px" alt=""></td>
                                    <td>{{  number_format($cart['price'])  }}đ</td>
                                    <td>
                                        <input type="number" onchange="updateCart({{ $index }},this.value)" value="{{ $cart['quantity'] }}" min="1" class="form-control" style="width: 80px;">
                                    </td>
                                    <td>{{ $cart['size'] }}</td>
                                    <td>{{  number_format($totalPrice)}}đ</td>
                                    <td>
                                        <a href="/deleteCart/{{ $index }}" class="btn btn-danger btn-sm">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif   
                    </tbody>
                </table>
            @endunless
            @empty($carts)
                <h2 text-aligin="center" >Bạn không có sản phẩm nào trong giỏ hàng!</h2>
            @endempty
        </div>
        
        <!-- Tóm tắt giỏ hàng -->
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng tiền</h5>
                        <p class="card-text fs-4">{{ number_format($totalCart)}}đ</p>
                        <a href="/payment" class="btn btn-primary btn-lg w-100">Thanh toán</a>
                        @error('error_cart')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chân trang -->
    <footer class="bg-dark text-white text-center p-3 mt-4">
        &copy; 2025 Shop Online. All rights reserved.
    </footer>
    <script>
        function updateCart(cartId, quantity) {
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin', // Đảm bảo gửi cookie xác thực // Thiếu cái này CSRF Token có thể bị bỏ qua
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload(); // Cập nhật lại trang
            })
            .catch(error => console.error('Lỗi:', error));  
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>