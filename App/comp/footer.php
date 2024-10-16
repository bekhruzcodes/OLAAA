    <!-- ##### Newsletter Area Start ##### -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <!-- Newsletter Text -->
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe for a <span>25% Discount</span></h2>
                        <p>Get this special welcome discount and enjoy your shopping in Olaaa. Stay tuned for more products and amazing news from Olaaa</p>
                    </div>
                </div>
                <!-- Newsletter Form -->
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
                        <div class="footer-logo mr-50" style="margin-bottom: -100px; margin-top: -60px;">
                            <a href="index.php"><img src="../../Public/img/core-img/olaaa.png" alt="image"></a>
                        </div>
                        <!-- Copywrite Text -->
                        <p class="copywrite">
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> & Re-distributed by <a href="https://themewagon.com/" target="_blank">Themewagon </a>& <a href="https://t.me/Bek_and_dev">Given a life by Error-404</a>
                        </p>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-8">
                    <div class="single_widget_area">
                        <div class="footer_menu">
                            <nav class="navbar">
                                <!-- Remove justify-content-end from navbar -->
                                <ul class="navbar-nav d-flex ml-auto">
                                    <li class="nav-item <?= isset($home_active) ? $home_active : "" ?>">
                                        <a class="nav-link" href="index.php">Home</a>
                                    </li>
                                    <li class="nav-item <?= isset($shop_active) ? $shop_active : "" ?>">
                                        <a class="nav-link" href="shop.php">Shop</a>
                                    </li>
                                    <li class="nav-item <?= isset($product_active) ? $product_active : "" ?>">
                                        <a class="nav-link" href="product-details.php">Product</a>
                                    </li>
                                    <li class="nav-item <?= isset($cart_active) ? $cart_active : "" ?>">
                                        <a class="nav-link" href="cart.php">Cart</a>
                                    </li>
                                    <li class="nav-item <?= isset($check_active) ? $check_active : "" ?>">
                                        <a class="nav-link" href="checkout.php">Checkout</a>
                                    </li>
                                </ul>
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
    <!-- My own custom js -->
    <script src="../../Public/js/myadds.js"></script>

    </body>

    </html>