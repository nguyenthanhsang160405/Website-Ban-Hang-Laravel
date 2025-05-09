<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản Lý Người Dùng - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1 class="h2">Quản Lý Người Dùng</h1>
        <a class="btn btn-sm btn-primary" href="/adduser">Thêm người dùng</a>

        <div class="table-responsive">
          <br>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Vai trò</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $index => $user)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->phone }}</td>
                  <td>{{ $user->role }}</td>
                  <td>
                    <a class="btn btn-sm btn-primary" href="/user/{{ $user->id }}">Sửa</a>
                    <a class="btn btn-sm btn-danger" href="/user/delete/{{ $user->id }}">Xóa</a>
                  </td>
                </tr>
              @endforeach
              <!-- Thêm các dòng dữ liệu khác nếu cần -->
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>