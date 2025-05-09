<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thêm Người Dùng - Admin</title>
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
      <nav class="col-md-2 d-none d-md-block sidebar">
        <div class="position-sticky pt-3">
          @include('admin.menu')
        </div>
      </nav>
      <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 content">
        <h1 class="h2">Thêm Người Dùng</h1>
        
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form method="POST" action="/users/store">
          @csrf
          <div class="mb-3">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="name" class="form-label">Họ và Tên</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
          </div>
          <div class="mb-3">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
          </div>
          <div class="mb-3">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="phone" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="phone" name="password" value="{{ old('password') }}">
          </div>
          <div class="mb-3">
            @error('password_confirm')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="phone" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirm" class="form-control" id="phone" value="{{ old('password_confirm') }}">
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select class="form-select" id="role" name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Thêm</button>
          <a href="user_management.html" class="btn btn-secondary">Hủy</a>
        </form>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
