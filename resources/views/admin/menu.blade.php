<ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link" href="#">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/listcategory/1">Danh mục sản phẩm</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  {{ Route::is('admin') ? 'active' : ''}}" href="/admin">Quản lý người dùng</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Route::is('admin.listproduct*') ? 'active' : ''}}" href="/listproduct">Quản lý sản phẩm</a>
    </li>
    <li class="nav-item">
      <a class="nav-link"  href="/listorder" {{ Route::is('listorder') ? 'style=background-color:#0d6efd' : '' }}>Quản lý đơn hàng</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Route::is('admin.comment*') ? 'active' : '' }}" href="/listcomment/1">Bình Luận</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Route::is('pageReport') ? 'active' : '' }}" href="/admin/repost">Báo cáo</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="settings.html">Cài đặt</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/logout">Đăng xuất</a>
    </li>
  </ul>