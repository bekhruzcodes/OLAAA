<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core.php';  
$categories = GetCategorie();

// Set default values for pagination and price filtering
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4; // Default 12 products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// $minPrice = isset($_GET['min_price']) ? (int)$_GET['min_price'] : null;
// $maxPrice = isset($_GET['max_price']) ? (int)$_GET['max_price'] : null;

$minPrice = 120;
$maxPrice = 120000;

if (isset($_GET['category_id'])) {
    $categoryId = (int)$_GET['category_id'];
    $totalProducts = countAllProducts( $categoryId, $minPrice, $maxPrice); // Count products with price filter if provided
    $totalPages = ceil($totalProducts / $limit);

    $products = getProducts( $categoryId, $start, $limit, $minPrice, $maxPrice);

} elseif (isset($_GET['allcategories']) && $_GET['allcategories'] === 'true') {
    $totalProducts = countAllProducts( null, $minPrice, $maxPrice);
    $totalPages = ceil($totalProducts / $limit);

    $products = getProducts( null, $start, $limit, $minPrice, $maxPrice);

} else {
    $totalProducts = countAllProducts( null, $minPrice, $maxPrice);
    $totalPages = ceil($totalProducts / $limit);

    $products = getProducts( null, $start, $limit, $minPrice, $maxPrice);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title  -->
    <title>Amado - Furniture Ecommerce Template | Shop</title>

    <!-- Favicon  -->
    <link rel="icon" href="../../Public/img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="../../Public/css/core-style.css">
    <link rel="stylesheet" href="../../Public/style.css">

</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="#" method="get">
                            <input type="search" name="search_inp" id="search" placeholder="Type your keyword...">
                            <button type="submit" name="search"><img src="../../Public/img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="index.php"><img src="../../Public/img/core-img/logo.png" alt=""></a>
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
            <div class="logo">
                <a href="index.php"><img src="../../Public/img/core-img/logo.png" alt=""></a>
            </div>
            <!-- Amado Nav -->
            <?php
            include "../components/nav.php";
            ?>
            <!-- Button Group -->
            <div class="amado-btn-group mt-30 mb-100">
                <a href="#" class="btn amado-btn mb-15">%Discount%</a>
                <a href="#" class="btn amado-btn active">New this week</a>
            </div>
            <!-- Cart Menu -->
            <div class="cart-fav-search mb-100">
                <a href="cart.php" class="cart-nav"><img src="../../Public/img/core-img/cart.png" alt=""> Cart <span>(0)</span></a>
                <a href="#" class="fav-nav"><img src="../../Public/img/core-img/favorites.png" alt=""> Favourite</a>
                <a href="#" class="search-nav"><img src="../../Public/img/core-img/search.png" alt=""> Search</a>
            </div>
            <!-- Social Button -->
            <?php include "../components/links.php" ?>

        </header>
        <!-- Header Area End -->

        <div class="shop_sidebar_area">

            <!-- ##### Single Widget ##### -->
            <div class="widget catagory mb-50">
                <!-- Widget Title -->
                 <a class="widget-title mb-30" href="shop.php?allcategories=true">Categories</a>

                <!--  Catagories  -->
                <div class="catagories-menu">
                    <ul>
                        <?php foreach($categories as $category){ ?>
                            <li><a href="shop.php?category_id=<?= $category['category_id'] ?>"><?= $category['category_name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>

            </div>

            <!-- ##### Single Widget ##### -->
            <div class="widget price mb-50">
    <!-- Widget Title -->
                <h6 class="widget-title mb-30">Price</h6>

                <div class="widget-desc">
                    <div class="slider-range">
                        <div id="slider" data-min="10" data-max="1000" data-unit="$" class="slider-range-price" 
                            data-value-min="10" data-value-max="1000" data-label-result="">
                            <div class="ui-slider-range"></div>
                            <span class="ui-slider-handle" tabindex="0"></span>
                            <span class="ui-slider-handle" tabindex="0"></span>
                        </div>
                        <div class="range-price">$10 - $1000</div>
                    </div>
                    <button class = 'btn btn-warning' id="setPriceButton">Search With Price</button>
                </div>
            </div>

        </div>

        <div class="amado_product_area section-padding-100">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                            <!-- Total Products -->
                            <div class="total-products">
                                <p>Showing <?= ($start + 1) ?>-<?= min($start + $limit, $totalProducts) ?> of <?= $totalProducts ?></p>
                            </div>
                            <!-- Sorting -->
                            <div class="product-sorting d-flex">
                                <div class="sort-by-date d-flex align-items-center mr-15">
                                    <p>Sort by</p>
                                    <form action="#" method="get">
                                        <select name="select" id="sortBydate">
                                            <option value="value">Date</option>
                                            <option value="value">Newest</option>
                                            <option value="value">Popular</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="view-product d-flex align-items-center">
                                    <p>View</p>
                                    <form action="" method="GET">
                                        <select name="limit" id="viewProduct" onchange="this.form.submit()">
                                            <option value="4" <?= (isset($_GET['limit']) && $_GET['limit'] == 4) ? 'selected' : '' ?>>4</option>
                                            <option value="6" <?= (isset($_GET['limit']) && $_GET['limit'] == 6) ? 'selected' : '' ?>>6</option>
                                            <option value="12" <?= (isset($_GET['limit']) && $_GET['limit'] == 12) ? 'selected' : '' ?>>12</option>
                                            <option value="24" <?= (isset($_GET['limit']) && $_GET['limit'] == 24) ? 'selected' : '' ?>>24</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <?php if(!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                                <div class="single-product-wrapper">
                                    <!-- Product Image -->
                                    <div class="product-img">
                                        <img src="<?= $product['image_url'] ?>" alt="<?= $product['title'] ?>">
                                    </div>
                                    <!-- Product Description -->
                                    <div class="product-description d-flex align-items-center justify-content-between">
                                        <!-- Product Meta Data -->
                                        <div class="product-meta-data">
                                            <div class="line"></div>
                                            <p class="product-price">$<?= $product['price'] ?></p>
                                            <a href="product-details.php?product_id=<?= $product['listing_id'] ?>">
                                                <h6><?= $product['title'] ?></h6>
                                            </a>
                                        </div>
                                        <!-- Ratings & Cart -->
                                        <div class="ratings-cart text-right">
                                            <div class="ratings">
                                                <?php
                                                    for($i = 0;$i < $product['rating'];$i++){ ?>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                    <?php }

                                                ?>
                                                <!-- <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i> -->
                                            </div>
                                            <div class="cart">
                                                <a href="add-to-cart.php?product_id=<?= $product['listing_id'] ?>" data-toggle="tooltip" data-placement="left" title="Add to Cart"><img src="../../Public/img/core-img/cart.png" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products found</p>
                    <?php endif; ?>

                </div>

                <nav aria-label="navigation">
    <ul class="pagination justify-content-end mt-50">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>"><<</a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">>></a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Newsletter Area Start ##### -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe for a <span>25% Discount</span></h2>
                        <p>Nullam eu ante vel est convallis dignissim. Fusce suscipit quam et turpis eleifend vitae malesuada magna congue.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="newsletter-form mb-100">
                        <form action="#" method="post">
                            <input type="email" name="email" class="nl-email" placeholder="Your E-mail">
                            <input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Newsletter Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row align-items-center">
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-4">
                    <div class="single_widget_area">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="index.php"><img src="../../Public/img/core-img/logo2.png" alt=""></a>
                        </div>
                        <!-- Copywrite Text -->
                        <p class="copywrite">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-8">
                    <div class="single_widget_area">
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <nav class="navbar navbar-expand-lg justify-content-end">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent"
                                    aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i
                                        class="fa fa-bars"></i></button>
                                <div class="collapse navbar-collapse" id="footerNavContent">
                                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="shop.php">Shop</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="product-details.php">Product</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cart.php">Cart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="checkout.php">Checkout</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="../../Public/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="../../Public/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="../../Public/js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="../../Public/js/plugins.js"></script>
    <!-- Active js -->
    <script src="../../Public/js/active.js"></script>

</body>

</html>
