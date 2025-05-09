<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chỉnh Sửa Người Dùng - Admin</title>
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
        <h1 class="h2">Chỉnh sửa sản phẩm</h1>
        
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-success">{{ session('error') }}</div>
        @endif
        <form method="POST" action="/product/update/{{ $product->id }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="name" class="form-label">Tên</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
          </div>
          <div class="mb-3">
            @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="phone" class="form-label">Giá</label>
            <input type="number" class="form-control" id="phone" name="price" value="{{ $product->price }}">
          </div>
          <div class="mb-3">
            @error('quantity')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="phone" class="form-label">Số lượng:</label>
            <input type="number" name="quantity" class="form-control" id="phone" value="{{ $product->quantity }}">
          </div>
          <div class="mb-3">
            @error('describe')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="phone" class="form-label">Mô tả:</label>
            <input type="text" name="describe" class="form-control" id="phone" value="{{ $product->describe }}">
          </div>
          <div class="mb-3">
            @error('category_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="role" class="form-label">Danh mục</label>
            <select class="form-select" id="" name="category_id">
                @empty(!$categories)
                  @foreach ($categories as $category )
                    @if($category->id == $product->category_id)
                      <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endif
                  @endforeach
                  @foreach ($categories as $category )
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                  @endforeach
                @endempty
            </select>
          </div>
          <div class="mb-3">
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="email" class="form-label">Hình ảnh</label><br>
            <img width="80px" src="{{ asset('storage/'.$product->image) }}" alt=""><br>
            <input type="file" class="form-control" id="email" name="image" value="{{ old('email') }}">
          </div>
          <button type="submit" class="btn btn-primary">Sửa</button>
          <a href="user_management.html" class="btn btn-secondary">Hủy</a>
        </form>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
