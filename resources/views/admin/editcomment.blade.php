<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thêm Bình Luận - Admin</title>
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
        <h1 class="h2">Thêm Bình Luận</h1>
        
        @if(session('tb'))
          <div class="alert alert-success">{{ session('tb') }}</div>
        @endif
        
        <form method="POST" action="/comment/update/{{ $comment->id }}">
          @csrf
          <div class="mb-3">
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="content" class="form-label">Nội dung bình luận</label>
            <textarea class="form-control" id="content" name="content" rows="4">{{ $comment->comments }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary">Sửa</button>
          <a href="#" onclick="history.back()" class="btn btn-secondary">Hủy</a>
        </form>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>