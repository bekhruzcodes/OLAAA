<?php
include_once "../comp/head.php";

$product = $_SESSION['single_product'];

$empty_reviews = [['user' => "OLAAA", 'text' => "No reviews yet :)", 'rating' => 0, 'time' => date("Y-m-d",)]];
$product_reviews = ($_SESSION['product_reviews']) ? $_SESSION['product_reviews'] : $empty_reviews;

$product_active = "active";

?>



<body>
    <?php include_once "../comp/search_box.php" ?>

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <?php include_once "../comp/navbar.php" ?>

        <!-- Product Details Area Start -->
        <div class="single-product-area section-padding-100 clearfix">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(../../<?= $product['image'] ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="1" style="background-image: url(../../<?= $product['image'] ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="2" style="background-image: url(../../<?= $product['image'] ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="3" style="background-image: url(../../<?= $product['image'] ?>);">
                                    </li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="img/product-img/pro-big-1.jpg">
                                            <img class="d-block w-100" src="../../<?= $product['image'] ?>" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/pro-big-2.jpg">
                                            <img class="d-block w-100" src="../../<?= $product['image'] ?>" alt="Second slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/pro-big-3.jpg">
                                            <img class="d-block w-100" src="../../<?= $product['image'] ?>" alt="Third slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/pro-big-4.jpg">
                                            <img class="d-block w-100" src="../../<?= $product['image'] ?>" alt="Fourth slide">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product Container HTML -->
                    <div class="col-12 col-lg-5" id="productContainer">
                        <div class="single_product_desc">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <form action="product-details.php"></form>
                                <p class="product-price">$<?= $product['price'] ?></p>
                                <a href="product-details.php">
                                    <h6><?= $product['title'] ?></h6>
                                </a>
                                <!-- Ratings & Review -->
                                <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                    <div class="ratings">
                                        <?php for ($i = 1; $i < 6; $i++) { ?>
                                            <i class="<?= ($i > $product['rating']) ? 'fa fa-star-o' : 'fa fa-star' ?>" aria-hidden="true"></i>
                                        <?php }; ?>
                                    </div>
                                    <div class="review">
                                        <a href="" id="writeReviewLink">Reviews</a>
                                    </div>
                                </div>
                                <!-- Availability -->
                                <p class="avaibility"><i class="fa fa-circle" style="<?= ($product['status'] == "sold") ? 'color: #ee0000 !important;' : '' ?>"></i> <?= $product['status'] ?></p>
                            </div>

                            <div class="short_overview my-5">
                                <p><?= $product['about'] ?></p>
                            </div>

                            <!-- Add to Cart Form -->
                            <form class="cart clearfix" method="POST">
                                <div class="cart-btn d-flex mb-50">
                                    <p>Quantity</p>
                                    <div class="quantity">
                                        <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="quantity" value="1" readonly>
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <button type="submit" name="addtocart" value="<?=$product['id']?>" class="btn amado-btn">Add to cart</button>
                            </form>
                        </div>
                    </div>

                    <!-- Reviews Form HTML (Initially Hidden) -->
                    <div class="col-12 col-lg-5 d-none" id="reviewsContainer">
                        <div class="single_product_reviews">
                            <!-- Reviews Carousel -->
                            <div class="reviews-carousel">
                                <div class="reviews-carousel-inner">
                                    <?php foreach ($product_reviews as $review) { ?>
                                        <div class="review-card">
                                            <div class="review-content">
                                                <h3 class="reviewer-name"><?= $review['user'] ?></h3>
                                                <div class="ratings">
                                                    <?php for ($i = 1; $i < 6; $i++) { ?>
                                                        <i class="<?= ($i > $review['rating']) ? 'fa fa-star-o' : 'fa fa-star' ?>" aria-hidden="true"></i>
                                                    <?php }; ?>
                                                </div>
                                                <p class="review-text"><?= $review['text'] ?></p>
                                                <p class="review-date"><?= $review['time'] ?></p>
                                            </div>

                                        </div>
                                    <?php } ?>
                                </div>

                                <!-- Carousel Controls -->
                                <div class="carousel-controls" style="<?= (count($product_reviews) == 1) ? 'display: none !important;' : '' ?>">
                                    <button class="carousel-control prev" >
                                        <i class="fa fa-chevron-left"></i>
                                    </button>
                                    <button class="carousel-control next" >
                                        <i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>

                            </div>

                            <!-- Review Form -->
                            <div class="write-review my-5">
                                <h5>Write Your Review</h5>
                                <!-- Star Rating Input -->
                                <div class="star-rating mb-3">
                                    <div class="rating-stars">
                                        <i class="fa fa-star-o" data-star="1" onclick="rateProduct(1)" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" data-star="2" onclick="rateProduct(2)" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" data-star="3" onclick="rateProduct(3)" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" data-star="4" onclick="rateProduct(4)" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" data-star="5" onclick="rateProduct(5)" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <form  method="POST">
                                    <!-- Review Text Input -->
                                    <div class="review-input">
                                        <textarea name="reviewTextInput" id="reviewText" class="responsive-textarea" rows="4" placeholder="Share your experience..."></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="submit-review mt-3">
                                        <!-- Back Button as Icon -->
                                        <button type="button" class="btn amado-btn " id="goBackButton"><i class="fa fa-arrow-left" style="cursor: pointer;"></i>&nbsp; Go back</button>
                                        <button type="submit" name="submitReview" class="btn amado-btn" value="<?=$product['id']?>" onclick="submitReview()">Submit &nbsp;<i class="fa fa-arrow-right" style="cursor: pointer;"></i></button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        <!-- Product Details Area End -->
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer ##### -->
    <?php include_once "../comp/footer.php" ?>