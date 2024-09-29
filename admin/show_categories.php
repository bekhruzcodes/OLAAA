<?php
require_once "../App/core.php";

function get_categories() {
    $host = "localhost";
    $username = "root";
    $password = "Kenc1k06";
    $database = "playground_db";

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT category_name, description FROM categories";
    $result = $connection->query($sql);

    $categories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    $connection->close();
    return $categories;
}

$categories = get_categories();
$add_category = add_category();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Category</title>

    <link rel="icon" href="../Public/img/core-img/favicon.ico">
    <link rel="stylesheet" href="../Public/css/core-style.css">
    <link rel="stylesheet" href="../Public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 40px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, .25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }

        .category-list {
            margin-top: 30px;
        }

        .category-item {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                    <div class="container">
                        <a class="navbar-brand" href="index.php">
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
    <div class="container mt-5">
        <h2>Add Category</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>

        <!-- Display Categories -->
        <div class="category-list">
            <h3>Existing Categories</h3>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <div class="category-item">
                        <h5><?php echo htmlspecialchars($category['category_name']); ?></h5>
                        <p><?php echo htmlspecialchars($category['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No categories found.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Main Content Wrapper End -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
