<?php include_once "../comp/head.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart_active = "active";

?>

<body>
    <?php include_once "../comp/search_box.php" ?>

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <?php include_once "../comp/navbar.php" ?>

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
                                    <?php foreach($inCart as $cartItem){?>
                                    <tr id="cart-item-row-<?=$cartItem['id']?>">
                                        <td class="cart_product_img">
                                            <a href="#"><img src="../../<?=$cartItem['image']?>" alt="Product"></a>
                                        </td>
                                        <td class="cart_product_desc">
                                            <h5><?=$cartItem['title']?></h5>
                                        </td>
                                        <td class="price">
                                            <span id="item-price">$<?=$cartItem['price']?></span>
                                        </td>
                                        <td class="qty">
                                            <div class="qty-btn d-flex" id="cart-item">
                                                <p>Qty</p>
                                                <div class="quantity">
                                                    <span class="qty-minus" onclick="decreaseQty(<?=$cartItem['id']?>, <?=$cartItem['price']?>)"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                                    <input type="number" class="qty-text" id="qty-<?=$cartItem['id']?>" step="1" min="1" max="300" name="quantity" value="1" readonly>
                                                    <span class="qty-plus" onclick="increaseQty(<?=$cartItem['id']?>, <?=$cartItem['price']?>)"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="cart-summary">
                            <h5>Cart Total</h5>
                            <ul class="summary-table">
                                <li><span>subtotal:</span> <span id="subtotal-price">$<?=$totalPrice?></span></li>
                                <li><span>delivery:</span> <span id="shipping-fee"><?=($delivery>0)? "$"."{$delivery}" : 'Free'?></span></li>
                                <li><span>total:</span> <span id="total-price">$<?=$totalPrice+$delivery?></span></li>
                            </ul>
                            <div class="cart-btn mt-100">
                                <a href="cart.php" class="btn amado-btn w-100">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer ##### -->
    <?php include_once "../comp/footer.php" ?>