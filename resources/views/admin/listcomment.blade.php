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
        <h1 class="h2">Quản Lý Bình Luận</h1>
        <a class="btn btn-sm btn-primary" href="/addcomment">Thêm bình luận</a>
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif  
        @if(session('errorerror'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="table-responsive">
          <br>
          <table style="text-align: center" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>STT</th>
                <th>Nội dung</th>
                <th>Sản phẩm</th>
                <th>Người dùng</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($comments as $index => $comment)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $comment->comments}}</td>
                  <td>{{ $comment->product->name }}</td>
                  <td>{{ $comment->user->name }}</td>
                  <td>
                    <a class="btn btn-sm btn-primary" href="/comment/edit/{{ $comment->id }}">Sửa</a>
                    <a class="btn btn-sm btn-danger" href="/comment/delete/{{ $comment->id }}/{{ $idPage }}">Xóa</a>
                  </td>
                </tr>
              @endforeach
              <!-- Thêm các dòng dữ liệu khác nếu cần -->
            </tbody>
          </table>
        </div>
        <nav aria-label="Page navigation" class="mt-4">
          <ul class="pagination justify-content-center">
              <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">Trước</a>
              </li>
              @for ($i = 1 ; $i <= $totalPage ; $i++ )
                  <li class="page-item {{ $i == $idPage ? 'active' : '' }}"><a class="page-link" href="/listproduct/{{ $i }}">{{ $i }}</a></li>
              @endfor
              <li class="page-item">
                  <a class="page-link" href="#">Tiếp</a>
              </li>
          </ul>
      </nav>
      </main>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>