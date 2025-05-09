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
        <h1 class="h2">Quản Lý Sản Phẩm</h1>
        <a class="btn btn-sm btn-primary" href="/addproduct">Thêm sản phẩm</a>
        <br><br>
        <form action="/listproduct" method="GET" class="flex flex-wrap gap-4 items-center">
          <select name="category_id" class="px-3 py-2 border rounded-lg">
            <option value="">Tất cả danh mục</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
            @endforeach
          </select>
          <!-- Tìm kiếm theo tên -->
          <input type="text" name="keyword" placeholder="Tìm tên sản phẩm..." value="{{ request('keyword') }}"
              class="px-3 py-2 border rounded-lg" />
      
          <!-- Lọc theo danh mục -->
          
      
          <!-- Sắp xếp -->
          <select name="sort" class="px-3 py-2 border rounded-lg">
              <option value="">Sắp xếp theo</option>
              <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
              <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
          </select>
      
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tìm kiếm</button>
      </form>
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
                <th>Tên</th>
                <th>Ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Mô tả</th>
                <th>Danh mục</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $index => $product)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $product->name }}</td>
                  <td> <img width="50px" src="{{ asset('storage/'.$product->image) }}" alt=""></td>
                  <td>{{ number_format($product->price) }}đ</td>
                  <td>{{ $product->quantity }}</td>
                  <td>{{ $product->describe }}</td>
                  @foreach ($categories as $category )
                    @if ($category->id == $product->category_id)
                      <td>{{ $category->title }}</td>  
                    @endif
                  @endforeach
                  <td>
                    <a class="btn btn-sm btn-primary" href="/product/edit/{{ $product->id }}">Sửa</a>
                    <a class="btn btn-sm btn-danger" href="/product/delete/{{ $product->id }}">Xóa</a>
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
                  <li class="page-item {{ $i == $idPage ? 'active' : '' }}"><a class="page-link" href="/listproduct/{{ $i }}?category_id={{ request('category_id') }}&keyword={{ request('keyword') }}&sort={{ request('sort') }}">{{ $i }}</a></li>
              @endfor
              <li class="page-item">
                  <a class="page-link" href="#">Tiếp</a>
              </li>
          </ul>
          <ul>
            {{ $products->links() }}
          </ul>
      </nav>
      </main>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>