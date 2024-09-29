<?php
require_once "../App/core.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_POST['seller_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];
    $location = $_POST['location'];

    $image_url = '';
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == UPLOAD_ERR_OK) {
        $uploads_dir = '../uploads';
        $tmp_name = $_FILES['image_url']['tmp_name'];
        $name = basename($_FILES['image_url']['name']);
        $image_url = "$uploads_dir/$name";
        move_uploaded_file($tmp_name, $image_url);
    }

    $host = "localhost";
    $username = "root";
    $password = "Kenc1k06";
    $database = "playground_db";

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $stmt = $connection->prepare("INSERT INTO listings (seller_id, title, description, price, category_id, image_url, status, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdisss", $seller_id, $title, $description, $price, $category_id, $image_url, $status, $location);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Product added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $connection->close();
}

$host = "localhost";
$username = "root";
$password = "Kenc1k06";
$database = "playground_db";

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$categories = [];
$result = $connection->query("SELECT category_id, category_name FROM categories");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Product</title>

    <link rel="icon" href="../Public/img/core-img/favicon.ico">
    <link rel="stylesheet" href="../Public/css/core-style.css">
    <link rel="stylesheet" href="../Public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    

</head>

<body>

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
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_category.php">Add Category</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="add_products.php">Add Product</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="users.php">Users</a>
                                    </li>
                                </ul>
                                <?php include "../App/components/links.php" ?>
                            </div>
                        </div>
                    </nav>

                </div>
            </div>
        </div>

        <div class="container">
            <h2>Add Product</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="seller_id">Seller ID</label>
                    <input type="number" class="form-control" id="seller_id" name="seller_id" required>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="" disabled selected>Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image_url">Image</label>
                    <input type="file" class="form-control-file" id="image_url" name="image_url" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>