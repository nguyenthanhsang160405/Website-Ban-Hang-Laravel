<header>
    This is header
</header>
<nav>
    <a class="{{ request()->is('products') ? 'active' : 'cc' }}" href="">Home</a>
    <a class="{{ request()->is('products') ? 'active' : 'cc' }}" href="{{ route('products') }}">Shop</a>
    <a class ="{{ request()->is('products') ? 'active' : 'cc' }}" href="">About</a>
    <a class="{{ request()->is('products') ? 'active' : 'cc' }}" href="">Contact</a>
    <a class="{{ request()->is('products') ? 'active' : 'cc' }}" href="">Blog</a>
</nav>