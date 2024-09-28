<?php
session_start();

define("ERROR_FILE", "../errors.txt");


function connectToDatabase()
{

    $database = "playground_db";
    $user = "root";
    $password = "";
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
                    listings.status != 'inactive';";


        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] SQL query error in select ALL products: " . $e->getMessage() . "\n\n";
        file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);

        return [];
    }
}



function filterByWord($products, $word) {
    return array_filter($products, function($product) use ($word) {
        $word = strtolower($word);
        return stripos($product['title'], $word) !== false ||
               stripos($product['about'], $word) !== false ||
               stripos($product['location'], $word) !== false;
    });
}


function filterByLastWeek($products, $weekDate) {
    $weekDate = new DateTime($weekDate);
    $weekDate->modify('-7 days'); 

    return array_filter($products, function($product) use ($weekDate) {
        $productDate = new DateTime($product['time']);
        return $productDate >= $weekDate;
    });
}

function sortByDateDesc($products) {
    usort($products, function($a, $b) {
        return strtotime($b['time']) - strtotime($a['time']);
    });
    return $products;
}


function filterByPriceRange($products, $minPrice = null, $maxPrice = null) {
    return array_filter($products, function($product) use ($minPrice, $maxPrice) {
        $price = $product['price'];
        if (!is_null($minPrice) && $price < $minPrice) return false;
        if (!is_null($maxPrice) && $price > $maxPrice) return false;
        return true;
    });
}


function getSearchedProducts($pattern = "", $date = false, $priceRange = null)
{
    
    if (empty($pattern) && !$date && empty($priceRange)) {
        return []; 
    }

    
    if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
        $_SESSION['products'] = getAllProducts();
    }

    $products = $_SESSION['products'];


    if (!empty($pattern)) {
        $products = filterByWord($products, $pattern);
    }

    if ($date) {
        $products = sortByDateDesc($products);
    }

    if (!empty($priceRange) && is_array($priceRange)) {
        $minPrice = isset($priceRange['min']) ? $priceRange['min'] : null;
        $maxPrice = isset($priceRange['max']) ? $priceRange['max'] : null;
        $products = filterByPriceRange($products, $minPrice, $maxPrice);
    }

    return $products;
}



if(isset($_GET['search']) && !empty($_GET['search_inp'])){
    $pattern = $_GET['search_inp'];
    $products = getSearchedProducts($pattern);
    $_SESSION['products'] = $products; 
}


if (isset($_GET['single_id'])) {
    $id = $_GET['single_id'];
 
        $products = getAllProducts();
        
        foreach ($products as $product) {

            if ($product['id'] == $id) {
                $_SESSION['single_product'] = $product;
                header("Location: Views/product-details.php");
                exit();
            }
        }
  
}
