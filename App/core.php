<?php
define("ERROR_FILE", "../errors.txt");

function connectToDatabase()
{
    
    $database = "playground_db";
    $user = "root";
    $password = "Cyberboy@5";
    $host = "localhost";
    

    try {

        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Database connection error: " . $e->getMessage() . "\n\n";
        file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);
        return null;
    }
}

function getAllProducts()
{
    
    $conn = connectToDatabase();

    if ($conn === null) {
        return [];
    }

    try {

        $sql = "SELECT 
                    listings.listing_id as 'id', 
                    listings.seller_id, 
                    listings.title, 
                    listings.description as 'about', 
                    listings.price, 
                    categories.category_name as 'category', 
                    listings.image_url as 'image', 
                    listings.created_at as 'time', 
                    listings.location, 
                    listings.status
                FROM 
                    listings 
                LEFT JOIN 
                    categories 
                ON 
                    categories.category_id = listings.category_id 
                WHERE 
                    listings.status != 'inactive'; ";


        $stmt = $conn->query($sql);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] SQL query error in select all products: " . $e->getMessage() . "\n\n";
        file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);

        return [];
    }
}
