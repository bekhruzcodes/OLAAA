<?php
require_once "../App/core.php";

function getAllListings()
{
    $host = "localhost";
    $username = "root";
    $password = "Kenc1k06"; 
    $database = "playground_db"; 

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $_SESSION['user_id'] = 2; 
    $sql = "SELECT * FROM listings WHERE seller_id = '{$_SESSION['user_id']}'";
    $result = $connection->query($sql);

    $listings = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $listings[] = $row;
        }
    }

    $connection->close();

    return $listings;
}

$listings = getAllListings();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OLAAA</title>

    <link rel="icon" href="../Public/img/core-img/favicon.ico">
    <link rel="stylesheet" href="../Public/css/core-style.css">
    <link rel="stylesheet" href="../Public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table img {
            border-radius: 5px;
        }
        h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        h5 {
            color: #dc3545;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <!-- Main Content Wrapper Start -->
    <div class="main-content-wrapper d-flex clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                        <div class="container">
                            <a class="navbar-brand" href="main.php">
                                <img src="../Public/img/core-img/logo.png" alt="Logo" style="width: 100px;">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="main.php">Home</a>
                                    </li>
                                    
                                    <?php
                                    $_SESSION['user_role'] = 'admin'; // Simulating user role
                                    if($_SESSION['user_role'] == 'admin' && isset($_SESSION['user_role'])) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="users.php">Users</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="add_category.php">Add Category</a>
                                        </li>
                                    <?php } ?>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_products.php">Add Product</a>
                                    </li>
                                </ul>
                                <?php include "../App/components/links.php" ?>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Listings Table Area Start -->
        <div class="container">
            <h2 class="mt-4">Listings</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Category ID</th>
                        <th>Seller ID</th>
                        <th>Created At</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(empty($listings)) { ?>
                        <tr><td colspan="10"><h5>No Product Found with <?= $_SESSION['user_id']?> user id</h5></td></tr>
                    <?php } 
                    foreach ($listings as $listing): ?>
                        <tr>
                            <td><img src="<?= isset($listing['image_url']) ? $listing['image_url'] : 'default-image.png' ?>" alt="Listing Image" style="width: 100px; height: auto;"></td>
                            <td><?= isset($listing['title']) ? $listing['title'] : 'No Title' ?></td>
                            <td><?= isset($listing['description']) ? $listing['description'] : 'No description available' ?></td>
                            <td>$<?= isset($listing['price']) ? number_format($listing['price'], 2) : 'N/A' ?></td>
                            <td><?= isset($listing['status']) ? $listing['status'] : 'N/A' ?></td>
                            <td><?= isset($listing['location']) ? $listing['location'] : 'Unknown' ?></td>
                            <td><?= isset($listing['category_id']) ? $listing['category_id'] : 'N/A' ?></td>
                            <td><?= isset($listing['seller_id']) ? $listing['seller_id'] : 'N/A' ?></td>
                            <td><?= isset($listing['created_at']) ? $listing['created_at'] : 'N/A' ?></td>
                            <td><?= isset($listing['quantity']) ? $listing['quantity'] : 'N/A' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Listings Table Area End -->
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../Public/js/plugins.js"></script>
    <script src="../../Public/js/active.js"></script>
</body>

</html>
