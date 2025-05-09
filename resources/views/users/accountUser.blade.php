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
      <h2 class="text-center mb-4">Quản Lý Tài Khoản Người Dùng</h2>
      <div class="row">
        <!-- Sidebar điều hướng -->
        <div class="col-md-3">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-info-list" data-bs-toggle="list" href="#list-info" role="tab">Thông tin cá nhân</a>
            <a class="list-group-item list-group-item-action" id="list-orders-list" data-bs-toggle="list" href="#list-orders" role="tab">Đơn hàng của tôi</a>
            <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab">Cài đặt tài khoản</a>
          </div>
        </div>
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-success">{{ session('error') }}</div>
        @endif
        <!-- Nội dung chính bên phải -->
        <div class="col-md-9">
          <div class="tab-content" id="nav-tabContent">
            <!-- Thông tin cá nhân -->
            <div class="tab-pane fade show active" id="list-info" role="tabpanel">
              <div class="card mb-4">
                <div class="card-header">
                  Thông tin cá nhân
                </div>
                <div class="card-body">
                  <form action="/update-accout/{{ $user->id }}" method="post">
                    @csrf
                    <div class="mb-3">
                      @error('name')
                        {{ $message }}
                      @enderror
                      <label for="fullname" class="form-label">Họ và tên</label>
                      <input 
                        type="text" 
                        class="form-control" 
                        name="name"
                        id="fullname" 
                        value="@isset( $user->name ){{ $user->name }}@endisset">
                    </div>
                    <div class="mb-3">
                      @error('email')
                        {{ $message }}
                      @enderror
                      <label for="email" class="form-label">Email</label>
                      <input 
                      type="email" 
                      class="form-control" 
                      id="email" 
                      value="@isset( $user->email ){{ $user->email }}@endisset" disabled>
                    </div>
                    <div class="mb-3">
                      @error('phone')
                        {{ $message }}
                      @enderror
                      <label for="phone" class="form-label">Số điện thoại</label>
                      <input type="text" name="phone" class="form-control" id="phone" value="@isset( $user->phone ){{ $user->phone }}@endisset">
                    </div>
                    <div class="mb-3">
                      @error('address')
                        {{ $message }}
                      @enderror
                      <label for="address" class="form-label">Địa chỉ</label>
                      <textarea class="form-control"  name="address" id="address" rows="3">@isset( $user->address ){{ $user->address }}@endisset</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- Đơn hàng của tôi -->
            <div class="tab-pane fade" id="list-orders" role="tabpanel">
              <div class="card mb-4">
                <div class="card-header">
                  Đơn hàng của tôi
                </div>
                <div class="card-body">
                  
                   
                  
                  @empty(!$orders)
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Mã đơn hàng</th>
                          <th>Ngày đặt</th>
                          <th>Trạng thái</th>
                          <th>Tổng tiền</th>
                          <th>Chi tiết</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($orders as $order)
                          <tr>
                            <td>DH{{ $order->id }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                              @if ($order->status_order === 'pending')
                                Đang chờ
                              @elseif ($order->status_order === 'processing')
                                Đang xử lý
                              @elseif ($order->status_order === 'progressing')
                                Đang giao hàng
                              @elseif ($order->status_order === 'completed')
                                Đã giao
                              @else
                                Đã hủy
                              @endif
                            </td>
                            <td>{{  number_format($order->total_order,0,'.')  }}đ</td>
                            <td><a href="/detail-order-user/{{ $order->id }}" class="btn btn-sm btn-primary">Xem</a>@if ($order->paypal_response !=null)
                              <a href="{{ $order->paypal_response }}" class="btn btn-sm btn-warning">Thanh Toán</a>
                            @endif</td>
                            
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  @endempty
                  @empty($orders)
                    <h1>Bạn hiện chưa có đơn hàng nào!</h1>
                  @endempty
                </div>
              </div>
            </div>
            <!-- Cài đặt tài khoản -->
            <div class="tab-pane fade" id="list-settings" role="tabpanel">
              <div class="card mb-4">
                <div class="card-header">
                  Cài đặt tài khoản
                </div>
                <div class="card-body">
                  <form action="/update-password-acccount/{{ $user->id }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>@error('password_old')
                        {{ $message }}
                      @enderror
                      <input type="password" name="password_old" class="form-control" id="currentPassword" value="{{ old('password_old') }}">
                    </div>
                    <div class="mb-3">
                      <label for="newPassword" class="form-label">Mật khẩu mới</label>@error('password_new')
                      {{ $message }}
                      @enderror
                      <input type="password" name="password_new" class="form-control" id="newPassword" value="{{ old('password_new') }}">
                    </div>
                    <div class="mb-3">
                      <label for="confirmNewPassword" class="form-label">Xác nhận mật khẩu mới</label>@error('password_confirm')
                      {{ $message }}
                      @enderror
                      <input type="password" name="password_confirm" class="form-control" id="confirmNewPassword" value="{{ old('password_confirm') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                  </form>
                </div>
              </div>
            </div>
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