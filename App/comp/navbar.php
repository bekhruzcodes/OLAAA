<!-- Mobile Nav (max width 767px)-->
<div class="mobile-nav">
    <!-- Navbar Brand -->
    <div class="amado-navbar-brand">
        <a href="index.php"><img src="../../Public/img/core-img/ola.png" alt=""></a>
    </div>
    <!-- Navbar Toggler -->
    <div class="amado-navbar-toggler">
        <span></span><span></span><span></span>
    </div>
</div>

<!-- Header Area Start -->
<header class="header-area clearfix">
    <!-- Close Icon -->
    <div class="nav-close">
        <i class="fa fa-close" aria-hidden="true"></i>
    </div>
    <!-- Logo -->
    <div class="logo" style="margin-top: -50px; margin-bottom: -30px;">
        <a href="index.php"><img src="../../Public/img/core-img/ola.png" alt=""></a>
    </div>
    <!-- Amado Nav -->
    <nav class="amado-nav">
        <ul>
            <li class="<?= isset($home_active) ? $home_active : "" ?>"><a href="index.php">Home</a></li>
            <li class="<?= isset($shop_active) ? $shop_active : "" ?>"><a href="shop.php">Shop</a></li>
            <li class="<?= isset($product_active) ? $product_active : "" ?>" style="<?= (!isset($_SESSION['single_product'])) ? 'display:none;' : '' ?>"><a href="product-details.php">Product</a></li>
            <li class="<?= isset($cart_active) ? $cart_active : "" ?>"><a href="cart.php">Cart</a></li>
            <li class="<?= isset($profile_active) ? $profile_active : "" ?>"><a href="profile.php">Profile</a></li>
            <li>
                <form method="POST" action="../auth.php">
                    <button type="submit" name="logout">Log Out</button>
                </form>
            </li>

        </ul>
    </nav>
    <!-- Button Group -->
    <div class="amado-btn-group mt-30 mb-100">
        <?=($inCartCount > 0 and !isset($check_active)) ? "<a href='checkout.php' id='animate-checkout' class='btn amado-btn mb-15'>Checkout</a>" : "" ?>
       
        <form action="" method="POST">
            <button type="submit" name="newthisweek" class="btn amado-btn active">New this week</button>
        </form>
    </div>
    <!-- Cart Menu -->
    <div class="cart-fav-search mb-100">
        <a href="cart.php" class="cart-nav"><img src="../../Public/img/core-img/cart.png" alt=""> Cart <span>(<?= isset($inCartCount) ? $inCartCount : 0 ?>)</span></a>
        <a href="#" class="fav-nav"><img src="../../Public/img/core-img/favorites.png" alt=""> Favourite</a>
        <a href="#" class="search-nav"><img src="../../Public/img/core-img/search.png" alt=""> Search</a>
    </div>
    <!-- Social Button -->
    <div class="social-info d-flex justify-content-between">
        <a href="https://t.me/Bek_and_dev" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i></a>
        <a href="https://www.pinterest.com/bekhruzbekmirzaliev744/" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
        <a href="https://github.com/kenc1k" target="_blank"><i class="fa fa-github" aria-hidden="true"></i></a>
        <a href="https://www.linkedin.com/in/ravshanbek-ilhomov-2701a5263/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
    </div>
</header>
<!-- Header Area End -->