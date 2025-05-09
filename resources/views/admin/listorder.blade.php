<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản Lý Đơn Hàng - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Arial', sans-serif; }
    .sidebar {
      min-height: 100vh;
      background: #343a40;
      color: #fff;
      padding: 15px;
    }
    .sidebar a { color: #fff; text-decoration: none; }
    .content { padding: 20px; }

    .order-tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .order-tab {
      flex: 1;
      padding: 12px;
      text-align: center;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      border-bottom: 3px solid transparent;
    }
    .order-tab:hover { background: rgba(0, 0, 0, 0.05); }
    .order-tab.active {
      border-bottom: 3px solid #007bff;
      color: #007bff;
    }

    .order-section { display: none; animation: fadeIn 0.3s ease-in-out; }
    .active-section { display: block; }

    .table th { background: #007bff; color: white; text-align: center; }
    .badge { font-size: 14px; padding: 6px 10px; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block sidebar">
      <div class="position-sticky">
        @include('admin.menu')
      </div>
    </nav>

    <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 content">
      <h1 class="h2 text-center">Quản Lý Đơn Hàng</h1>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="order-tabs">
        <div class="order-tab active" data-target="pending-orders">🟡 Đang Chờ</div>
        <div class="order-tab" data-target="processing-orders">🔵 Đang Xử Lý</div>
        <div class="order-tab" data-target="completed-orders">✅ Đã Hoàn Thành</div>
      </div>

      <!-- Đơn hàng đang chờ -->
      <div id="pending-orders" class="order-section active-section">
        <h3 class="text-warning text-center">🟡 Đơn Hàng Đang Chờ</h3>
        <div class="table-responsive">
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>STT</th>
                <th>Mã Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Địa Chỉ</th>
                <th>Tổng Tiền</th>
                <th>Chỉnh Sửa Trạng Thái</th>
                <th>Hành Động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders_pending as $index => $order)
              <tr>
                <form action="order/update-status/{{ $order->id }}" method="post">
                  @csrf
                  <td>{{ $index + 1 }}</td>
                  <td>DH00{{ $order->id }}</td>
                  <td>{{ $order->name }}</td>
                  <td>{{ $order->address }}</td>
                  <td>{{ number_format($order->total_order, 0, ',', '.') }} VNĐ</td>
                  <td>
                    <select name="status" required>
                      <option value="">Chỉnh sửa trạng thái</option>
                      <option value="processing">Đang Xử Lý</option>
                      <option value="cancelled">Hủy đơn hàng</option>
                    </select>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-warning" type="submit">Cập nhật</button>
                    <a class="btn btn-sm btn-primary" href="/order/view/{{ $order->id }}">Xem</a>
                  </td>
                </form>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Đơn hàng đang xử lý -->
      <div id="processing-orders" class="order-section">
        <h3 class="text-info text-center">🔵 Đơn Hàng Đang Xử Lý</h3>
        <div class="table-responsive">
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>STT</th>
                <th>Mã Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Địa Chỉ</th>
                <th>Tổng Tiền</th>
                <th>Trạng thái</th>
                <th>Chỉnh Sửa Trạng Thái</th>
                <th>Hành Động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders_processing as $index => $order)
              <tr>
                <form action="order/update-status/{{ $order->id }}" method="post">
                  @csrf
                  <td>{{ $index + 1 }}</td>
                  <td>DH0{{ $order->id }}</td>
                  <td>{{ $order->name }}</td>
                  <td>{{ $order->address }}</td>
                  <td>{{ number_format($order->total_order, 0, ',', '.') }} VNĐ</td>
                  <td>
                    @if ($order->status_order == 'processing')
                      Đang chuẩn bị hàng
                    @elseif ($order->status_order == 'progressing')
                      Đang giao hàng
                    @endif
                  </td>
                  <td>
                    <select name="status">
                      <option value="">Cập nhật trạng thái</option>
                      @if ($order->status_order === 'processing')
                        <option value="progressing">Đang giao hàng</option>
                      @elseif($order->status_order === 'progressing')
                        <option value="completed">Đã giao hàng</option>
                        <option value="cancelled">Hủy đơn</option>
                      @endif
                    </select>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-warning" type="submit">Cập nhật</button>
                    <a class="btn btn-sm btn-primary" href="/order/view/{{ $order->id }}">Xem</a>
                  </td>
                </form>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Đơn hàng đã hoàn thành -->
      <div id="completed-orders" class="order-section">
        <h3 class="text-success text-center">✅ Đơn Hàng Đã Hoàn Thành</h3>
        <div class="table-responsive">
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>STT</th>
                <th>Mã Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Địa Chỉ</th>
                <th>Tổng Tiền</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders_completed as $index => $order)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>DH0{{ $order->id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ number_format($order->total_order, 0, ',', '.') }} VNĐ</td>
                <td>
                  <a class="btn btn-sm btn-primary" href="/order/view/{{ $order->id }}">Xem</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</div>

<script>
  document.querySelectorAll(".order-tab").forEach(tab => {
    tab.addEventListener("click", function() {
      document.querySelectorAll(".order-tab").forEach(t => t.classList.remove("active"));
      document.querySelectorAll(".order-section").forEach(s => s.classList.remove("active-section"));
      document.getElementById(this.dataset.target).classList.add("active-section");
      this.classList.add("active");
    });
  });
</script>
</body>
</html>