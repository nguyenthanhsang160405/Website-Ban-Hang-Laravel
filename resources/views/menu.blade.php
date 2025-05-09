<ul class="navbar-nav ms-auto">
    <li class="nav-item"><a class="nav-link" href="/">Trang Chủ</a></li>
    <li class="nav-item"><a class="nav-link" href="/products/1">Sản Phẩm</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Liên Hệ</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Bài Viết</a></li>
    <li class="nav-item"><a class="nav-link" href="/cart">Giỏ hàng</a></li>
    <li class="nav-item"><a class="nav-link" href="/chat">Chat với AI</a></li>
    @if (Auth::user())
        <li class="nav-item"><a class="nav-link" href="/accountUser">Tài Khoản</a></li>
        <li class="nav-item"><a class="nav-link" href="/logout">Xin chào, {{ Auth::user()->name }}, Đăng Xuất</a></li>
    @else
        <li class="nav-item"><a class="nav-link" href="/login">Đăng Nhập</a></li>
    @endif
</ul>