<?php

// session_start();

include "../core.php";

$conn = connectToDatabase();

// Initialize the cart in the session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    echo $productId . "<br>";
    echo $quantity;

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$productId])) {
        // If it is, update the quantity
        $_SESSION['cart'][$productId] += $quantity;
        
    } else {
        // Otherwise, add it to the cart
        $_SESSION['cart'][$productId] = $quantity;
    }
    echo "<pre>";
    print_r($_SESSION['cart']);
    echo  "</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Amado - Furniture Ecommerce Template | Cart</title>

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
                            <input type="search" name="search" id="search" placeholder="Type your keyword...">
                            <button type="submit"><img src="../../Public/img/core-img/search.png" alt=""></button>
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

        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="cart-title mt-50">
                            <h2>Shopping Cart</h2>
                        </div>

                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Assume $conn is already established

                                    $totalPrice = 0;
                                    if (!empty($_SESSION['cart'])) {
                                        $productIds = array_keys($_SESSION['cart']);
                                        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

                                        $query = "SELECT listing_id, title, price, image_url FROM listings WHERE id IN ($placeholders)";
                                        $stmt = $conn->prepare($query);

                                        if ($stmt) {
                                            $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            while ($product = $result->fetch_assoc()) {
                                                $quantity = $_SESSION['cart'][$product['listing_id']]; // Change 'id' to 'listing_id'
                                                $totalPrice += $product['price'] * $quantity;

                                                // Output product details here
                                                echo "<tr>";
                                                echo "<td class='cart_product_img'><a href='#'><img src='" . htmlspecialchars($product['image_url']) . "' alt='Product'></a></td>"; // Change 'image' to 'image_url'
                                                echo "<td class='cart_product_desc'><h5>" . htmlspecialchars($product['title']) . "</h5></td>"; // Change 'name' to 'title'
                                                echo "<td class='price'><span>$" . number_format($product['price'], 2) . "</span></td>";
                                                echo "<td class='qty'><p>" . $quantity . "</p></td>";
                                                echo "</tr>";
                                            }


                                            $stmt->close();
                                        } else {
                                            // Handle error
                                            error_log("Failed to prepare statement: " . $conn->error);
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="cart-summary">
                            <h5>Cart Total</h5>
                            <ul class="summary-table">
                                <li><span>subtotal:</span> <span>$<?php echo number_format($totalPrice, 2); ?></span></li>
                                <li><span>delivery:</span> <span>Free</span></li>
                                <li><span>total:</span> <span>$<?php echo number_format($totalPrice, 2); ?></span></li>
                            </ul>
                            <div class="cart-btn mt-100">
                                <a href="checkout.php" class="btn amado-btn w-100">Checkout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Newsletter Area Start ##### -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <!-- Newsletter Text -->
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe for a <span>25% Discount</span></h2>
                        <p>Nulla ac convallis lorem, eget euismod nisl. Donec in libero sit amet mi vulputate consectetur. Donec auctor interdum purus, ac finibus massa bibendum nec.</p>
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
    <?php include "../components/footer.php" ?>
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