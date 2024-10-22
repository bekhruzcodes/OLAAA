<?php
include_once "../comp/head.php";

$shop_active = "active";


?>





<body>
    <?php include_once "../comp/search_box.php" ?>

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <?php include_once "../comp/navbar.php" ?>

        <div class="shop_sidebar_area">

            <!-- ##### Single Widget ##### -->
            <div class="widget catagory mb-50">
                <!-- Widget Title -->
                <h6 class="widget-title mb-30">Catagories</h6>

                <!--  Catagories  -->
                <!-- Catagories Menu -->
                <div class="catagories-menu">
                    <ul>
                        <?php foreach ($categories as $category) { ?>
                            <!-- Add category ID as query parameter -->
                            <li>
                                <a href="shop.php?category_id=<?= $category['category_id'] ?>"
                                    class="<?= (isset($_GET['category_id']) && $_GET['category_id'] == $category['category_id']) ? 'activeCategory' : '' ?>">
                                    <?= $category['category_name'] ?>
                                </a>
                            </li>
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
                                <p>Showing
                                    <?= ($limit * ($pageNumber - 1) + 1) ?> -
                                    <?= ($limit * $pageNumber > $totalProducts) ? $totalProducts : $limit * $pageNumber ?>
                                    of <?= $totalProducts ?>
                                </p>
                            </div>

                            <!-- Sorting -->
                            <div class="product-sorting d-flex">
                                <div class="sort-by-date d-flex align-items-center mr-15">
                                    <p>Sort by</p>
                                    <form action="#" method="get">
                                        <select name="select" id="sortBydate">
                                            <option value="value">New</option>
                                            <option value="value">Cheap</option>
                                            <option value="value">Popular</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="view-product d-flex align-items-center">
                                    <p>View</p>
                                    <form action="../core.php" method="GET">
                                        <select name="limit" id="viewProduct" onchange="this.form.submit()">
                                            <option value="4" <?= ($limit == 4) ? 'selected' : '' ?>>4</option>
                                            <option value="8" <?= ($limit == 8) ? 'selected' : '' ?>>8</option>
                                            <option value="16" <?= ($limit == 16) ? 'selected' : '' ?>>16</option>
                                            <option value="32" <?= ($limit == 32) ? 'selected' : '' ?>>32</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($products as $product) { ?>
                        <!-- Single Product Area -->
                        <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                            <div class="single-product-wrapper">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="../../<?= $product['image'] ?>" alt="Product">
                                    <!-- Hover Thumb -->
                                    <img class="hover-img" src="../../<?= $product['image'] ?>" alt="Image">
                                </div>

                                <!-- Product Description -->
                                <div class="product-description d-flex align-items-center justify-content-between">
                                    <!-- Product Meta Data -->
                                    <div class="product-meta-data">
                                        <div class="line"></div>
                                        <p class="product-price"><?= $product['price'] ?></p>
                                        <a href="../core.php?single_id=<?= $product['id'] ?>">
                                            <h6><?= $product['title'] ?></h6>
                                        </a>
                                    </div>
                                    <!-- Ratings & Cart -->
                                    <div class="ratings-cart text-right">
                                        <div class="ratings">
                                            <?php for ($i = 1; $i < 6; $i++) { ?>
                                                <i class="<?= ($i > $product['rating']) ? 'fa fa-star-o' : 'fa fa-star' ?>" aria-hidden="true"></i>
                                            <?php }; ?>
                                        </div>
                                        <div class="cart">
                                            <form action="cart.php" method="post">
                                                <input type="hidden" name="addtocart" value="<?= $product['id'] ?>">
                                                <button type="submit" data-toggle="tooltip" data-placement="left" title="Add to Cart" style="border: none; background: none;">
                                                    <img src="../../Public/img/core-img/cart.png" alt="">
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-12">
                        <!-- Pagination -->
                        <nav aria-label="navigation">
                            <ul class="pagination justify-content-end mt-50">
                                <?php
                                if ($totalProducts > $limit) {
                                    for ($i = 1; $i <= ceil($totalProducts / $limit); $i += 1) { ?>
                                        <li class="page-item <?= ($i == $pageNumber) ? 'active' : '' ?>"><a class="page-link" href="../core.php?pageNumber=<?= $i ?>"><?= $i ?>.</a></li>

                                <?php }
                                } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer ##### -->
    <?php include_once "../comp/footer.php" ?>