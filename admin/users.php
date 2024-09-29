<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users List</title>
    <link rel="icon" href="../Public/img/core-img/favicon.ico">
    <link rel="stylesheet" href="../Public/css/core-style.css">
    <link rel="stylesheet" href="../Public/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add your custom styles here */
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1em;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .alert {
            margin-top: 20px;
        }

        /* Optional: Style for the buttons */
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
    </style>
</head>

<body>
    <div class="main-content-wrapper d-flex clearfix">
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
            <h2>Users List</h2>
            <?php
            $host = "localhost";
            $username = "root";
            $password = "Kenc1k06";
            $database = "playground_db";

            // Create connection
            $connection = new mysqli($host, $username, $password, $database);

            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Fetch all users
            $sql = "SELECT * FROM users";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Contact Info</th><th>Created At</th></tr></thead><tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['role']}</td>
                        <td>{$row['contact_info']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<div class='alert alert-warning'>No users found.</div>";
            }

            $connection->close();
            ?>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
