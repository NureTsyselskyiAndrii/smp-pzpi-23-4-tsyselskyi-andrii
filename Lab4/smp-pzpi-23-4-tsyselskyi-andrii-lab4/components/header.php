<header>
    <a href="/">
        <span class="nav-icon">🏠</span> Home
    </a>
    <a href="/products">
        <span class="nav-icon">📦</span> Products
    </a>
    <?php if (isset($_SESSION['username'])) : ?>
    <a href="/cart">
        <span class="nav-icon">🛒</span> Cart
    </a>
    <a href="/myprofile">
        <span class="nav-icon">👤</span> Profile
    </a>
    <a href="/logout">
        <span class="nav-icon">🔓</span> Logout
    </a>
    <?php else : ?>
    <a href="/login">
        <span class="nav-icon">🔐</span> Login
    </a>
    <?php endif; ?>
</header>