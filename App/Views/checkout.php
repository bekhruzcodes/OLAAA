<?php include_once "../comp/head.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$check_active = "active";
?>

<body>
    <?php include_once "../comp/search_box.php" ?>

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <?php include_once "../comp/navbar.php" ?>

        <div class="cart-table-area section-padding-10" style="margin-bottom:4% !important;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="checkout_details_area mt-50 clearfix">

                            <div class="cart-title">
                                <h2>Checkout</h2>
                            </div>

                            <form action="../core.php" method="POST" id="checkoutForm">
                                <div class="row">
                                    <!-- Full Name Input hidden at the beginning -->
                                    <div class="col-12 mb-3" id="fullNameContainer" style="display: none;">
                                        <input type="text" class="form-control" name="fullNameCOD" id="fullNameCOD" placeholder="Full Name" required>
                                    </div>

                                    <div id="card-info" class="col-12 mb-3">
                                        <input type="number" class="form-control" name="cardNumber" id="cardNumber" placeholder="Card number" minlength="16" maxlength="16" required>
                                    </div>
                                    <div id="card-holder" class="col-md-6 mb-3">
                                        <input type="text" class="form-control" name="cardHolder" placeholder="Card holder" required>
                                    </div>
                                    <div id="exp-date" class="col-md-6 mb-3">
                                        <input type="date" class="form-control" name="expDate" id="expDate" placeholder="Expiring date" required>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <select class="w-100" name="country" id="country">
                                            <option value="uz">Uzbekistan</option>
                                            <option value="usa">United States</option>
                                            <option value="uk">United Kingdom</option>
                                            <option value="ger">Germany</option>
                                            <option value="fra">France</option>
                                            <option value="ind">India</option>
                                            <option value="aus">Australia</option>
                                            <option value="bra">Brazil</option>
                                            <option value="cana">Canada</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control mb-3" name="street_address" id="street_address" placeholder="Address" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" name="zipCode" id="zipCode" placeholder="Zip Code" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="number" class="form-control" name="phone_number" id="phone_number" min="0" placeholder="Phone No" required>
                                    </div>
                                </div>
                                <input type="hidden" name="checkoutSubmit" value="1">
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="cart-summary">
                            <h5>Cart Total</h5>
                            <ul class="summary-table">
                                <li><span>subtotal:</span> <span>$<?= $totalPrice ?></span></li>
                                <li><span>delivery:</span> <span>$<?= $delivery ?></span></li>
                                <li><span>total:</span> <span>$<?= $totalPrice + $delivery ?></span></li>
                            </ul>

                            <div class="payment-method">
                                <!-- Cash on delivery -->
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="cod" onchange="togglePaymentMethod()">
                                    <label class="custom-control-label" for="cod">Cash on Delivery</label>
                                </div>
                            </div>

                            <div class="cart-btn mt-100">
                                <button type="button" <?=($totalPrice==0)? 'disabled': '' ?> class="btn amado-btn w-100" name="checkoutSubmit" onclick="validateAndSubmit();">Checkout</button>
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