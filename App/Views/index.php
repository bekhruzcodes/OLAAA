<?php

include_once "../comp/head.php"; 

$home_active = "active";

?>




<body>
    <?php include_once "../comp/search_box.php"?>

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

    <?php include_once "../comp/navbar.php"?>

        <!-- Product Catagories Area Start -->
        <div class="products-catagories-area clearfix">
            <div class="amado-pro-catagory clearfix">

                <!-- Single Catagory -->
                <?php foreach ($products as $product): ?>
                    <div class="single-products-catagory clearfix">
                        <a href="../core.php?single_id=<?= $product['id']?>">
                            <img src="../../<?= $product['image'] ?>" alt="png">
                            <div class="hover-content">
                                <div class="line"></div>
                                <p>From $<?= $product['price'] ?></p>
                                <h4><?= $product['title'] ?></h4>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>



            </div>
        </div>
        <!-- Product Catagories Area End -->
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer ##### -->
    <?php include_once "../comp/footer.php"?>