<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản Lý Tài Khoản - Shop Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
    }
    /* Wrapper bao bọc toàn bộ trang, đảm bảo min-height bằng 100vh */
    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    /* Nội dung chính có thể co giãn để đẩy footer xuống dưới */
    .content {
      flex: 1;
    }
    .list-group-item.active {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }
    .table-responsive {
      max-height: 70vh; /* Giới hạn chiều cao bảng để tránh tràn */
      overflow-y: auto;
    }
  </style>
</head>
<body>
  <div class="wrapper">
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
    
    <!-- Nội dung chính -->
    <div class="content container mt-4">
      <h2 class="text-center mb-4">Chi tiết đơn hàng</h2>
      
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
          <span>Chi tiết đơn hàng</span>
          <button onclick="history.back()" class="btn btn-secondary btn-sm">⬅ Quay lại</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
              <thead class="table-dark">
                <tr>
                  <th>STT</th>
                  <th>Tên</th>
                  <th>Ảnh</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Size</th>
                  @if($order->status_order == 'completed')
                    <th>Bình luận</th>
                  @endif
                  </tr>
              </thead>
              <tbody>
                @foreach ($detailOrders as $index => $detailOrder)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detailOrder->name }}</td>
                    <td><img width="60" height="60" src="{{ asset('storage/'.$detailOrder->image) }}" alt="Ảnh sản phẩm"></td>
                    <td>{{ number_format($detailOrder->price) }}đ</td>
                    <td>{{ $detailOrder->quantity }}</td>
                    <td>{{ $detailOrder->size }}</td>
                    
                    @if($order->status_order == 'completed')
                      <td>
                        @if ($detailOrder->check_comment === 0)
                          <a href="/goComment/{{ $detailOrder->id }}" class="btn btn-sm btn-primary">Bình luận</a>
                        @else
                          <span class="text-success">Đã Bình luận</span>
                        @endif
                      </td>
                    @endif
                    
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer luôn nằm dưới cùng -->
    <footer class="bg-dark text-white text-center p-3">
      &copy; 2025 Shop Online. All rights reserved.
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </div>
</body>
</html>