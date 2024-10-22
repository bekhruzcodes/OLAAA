<?php 
include_once "../comp/head.php";  
$categories =GetCategories();
$shop_active = "active";

// Check if category ID is passed in the URL
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];

    // Query to get products based on the selected category
    $products = getProductsByCategoryId($categoryId); // You need to implement this function

    // Display the products here
    // foreach ($products as $product) {
    //     // Example of how to display the product
    //     echo "<div class='product'>";
    //     echo "<h3>" . $product['product_name'] . "</h3>";
    //     echo "<p>Price: " . $product['price'] . "</p>";
    //     echo "</div>";
    // }
} else {
    // If no category is selected, show all products or a default category
    // $products = getAllProducts(); // Implement this function to get all products

}
?>





<body>
    <?php include_once "../comp/search_box.php"?>

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

    <?php include_once "../comp/navbar.php"?>

        <div class="shop_sidebar_area">

            <!-- ##### Single Widget ##### -->
            <div class="widget catagory mb-50">
                <!-- Widget Title -->
                <h6 class="widget-title mb-30">Catagories</h6>

                <!--  Catagories  -->
                <!-- Catagories Menu -->
            <div class="catagories-menu">
                <ul>
                    <?php foreach($categories as $category){ ?>
                        <!-- Add category ID as query parameter -->
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
                        <div data-min="10" data-max="1000" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="10" data-value-max="1000" data-label-result="">
                            <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                        </div>
                        <div class="range-price">$10 - $1000</div>
                    </div>
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
                                <p>Showing 1-8 0f 25</p>
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
                                            <option value="8" <?= (isset($_GET['limit']) && $_GET['limit'] == 8) ? 'selected' : '' ?>>8</option>
                                            <option value="16" <?= (isset($_GET['limit']) && $_GET['limit'] == 16) ? 'selected' : '' ?>>16</option>
                                            <option value="32" <?= (isset($_GET['limit']) && $_GET['limit'] == 32) ? 'selected' : '' ?>>32</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Single Product Area -->
                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                                <img src="../../Public/img/product-img/product2.jpg" alt="">
                                <!-- Hover Thumb -->
                                <img class="hover-img" src="../../Public/img/product-img/product2.jpg" alt="">
                            </div>

                            <!-- Product Description -->
                            <div class="product-description d-flex align-items-center justify-content-between">
                                <!-- Product Meta Data -->
                                <div class="product-meta-data">
                                    <div class="line"></div>
                                    <p class="product-price">$180</p>
                                    <a href="product-details.php">
                                        <h6>Modern Chair</h6>
                                    </a>
                                </div>
                                <!-- Ratings & Cart -->
                                <div class="ratings-cart text-right">
                                    <div class="ratings">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                    <div class="cart">
                                        <a href="cart.php" data-toggle="tooltip" data-placement="left" title="Add to Cart"><img src="../../Public/img/core-img/cart.png" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

<!-- Pagination -->
                <div class="row">
                    <div class="col-12">
                        <!-- Pagination -->
                        <nav aria-label="navigation">
                            <ul class="pagination justify-content-end mt-50">
                                <li class="page-item active"><a class="page-link" href="#">01.</a></li>
                                <li class="page-item"><a class="page-link" href="#">02.</a></li>
                                <li class="page-item"><a class="page-link" href="#">03.</a></li>
                                <li class="page-item"><a class="page-link" href="#">04.</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer ##### -->
    <?php include_once "../comp/footer.php"?>