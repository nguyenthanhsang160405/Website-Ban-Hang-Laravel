<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Báo Cáo Tổng Hợp - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background: #f8f9fa; }
    .sidebar {
      min-height: 100vh;
      background: #343a40;
      color: #fff;
    }
    .sidebar a { color: #fff; text-decoration: none; }
    .sidebar .nav-link.active { background-color: #0d6efd; }
    .content { padding: 20px; }
    .card-summary { border-left: 5px solid #0d6efd; }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-2 d-none d-md-block sidebar">
        <div class="position-sticky pt-3">
          @include('admin.menu')
        </div>
      </nav>

      <!-- Nội dung chính -->
      <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 content">
        <h1 class="h2">Báo Cáo Tổng Hợp</h1>

        <!-- Thống kê tổng quan -->
        <div class="row my-4">
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Người dùng</h5>
                <p class="fs-4">{{ $totalUsers }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Sản phẩm</h5>
                <p class="fs-4">{{ $totalProducts }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Đơn hàng</h5>
                <p class="fs-4">{{ $totalOrders }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Tổng doanh thu</h5>
                <p class="fs-4 text-success">{{ number_format($totalRevenue, 0, ',', '.') }} đ</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row my-4">
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Tổng doanh thu ngày</h5>
                <p class="fs-4 text-success">{{ number_format($revenueByDay, 0, ',', '.') }} đ</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Tổng doanh thu tuần</h5>
                <p class="fs-4 text-success">{{ number_format($revenueByWeek, 0, ',', '.') }} đ</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Tổng doanh thu tháng</h5>
                <p class="fs-4 text-success">{{ number_format($revenueByMonth, 0, ',', '.') }} đ</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-summary shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Tổng doanh thu năm</h5>
                <p class="fs-4 text-success">{{ number_format($revenueByYear, 0, ',', '.') }} đ</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Biểu đồ thống kê doanh thu -->
        <h4 class="mt-4">Thống kê sản phẩm bán ra theo tháng</h4>
        <canvas id="productMonthChart" height="100"></canvas>
        <h4 class="mt-4">Thống kê sản phẩm bán ra theo năm</h4>
        <canvas id="productYearChart" height="100"></canvas>
        <h4 class="mt-4">Thống kê doanh thu theo tháng</h4>
        <canvas id="totalYearMonth" height="100"></canvas>
      </main>
    </div>
  </div>

  <script>
    const productMonthData = @json($productSellByMonth);
    const productYearData = @json($productSellByYear);
    const totalYearMonth = @json($totalYearMonth);

    const monthLabels = productMonthData.map(m => 'Tháng ' + m.month);
    const quantityValuesMonth = productMonthData.map(m => m.total_order);

    const yearLabels = productYearData.map( element => 'Năm '+element.year );
    const quantityValuesYear = productYearData.map(m => m.total_order);

    const yearMonth = totalYearMonth.map(element => element.month+'/'+element.year)
    const totalValuesYearMonth = totalYearMonth.map(m => m.total_order);

  
    new Chart(document.getElementById('productMonthChart'), {
      type: 'bar',
      data: {
        labels: monthLabels,
        datasets: [{
          label: 'Đơn hàng',
          data: quantityValuesMonth,
          backgroundColor: 'rgba(255, 99, 132, 0.6)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Số lượng sản phẩm'
            }
          }
        }
      }
    });
    new Chart(document.getElementById('productYearChart'), {
      type: 'bar',
      data: {
        labels: yearLabels,
        datasets: [{
          label: 'Sản phẩm bán ra',
          data: quantityValuesYear,
          backgroundColor: 'green',
          borderColor: 'green',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Số lượng sản phẩm'
            }
          }
        }
      }
    });
    new Chart(document.getElementById('totalYearMonth'), {
      type: 'bar',
      data: {
        labels: yearMonth,
        datasets: [{
          label: 'Tổng doanh thu',
          data: totalValuesYearMonth,
          backgroundColor: 'green',
          borderColor: 'green',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Số lượng sản phẩm'
            }
          }
        }
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>