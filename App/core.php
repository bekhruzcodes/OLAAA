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
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);
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
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);

        return [];
    }
}

function getProductsByCategoryId($categoryId)
{

    $conn = connectToDatabase();

    if ($conn === null) {
        return [];
    }

    $stmt = $conn->prepare("SELECT * FROM listings WHERE category_id = ?");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function filterByWord($products, $word)
{
    return array_filter($products, function ($product) use ($word) {
        $word = strtolower($word);
        return stripos($product['title'], $word) !== false ||
            stripos($product['about'], $word) !== false ||
            stripos($product['location'], $word) !== false;
    });
}


function filterByLastWeek($products, $weekDate)
{
    $weekDate = new DateTime($weekDate);
    $weekDate->modify('-7 days');

    return array_filter($products, function ($product) use ($weekDate) {
        $productDate = new DateTime($product['time']);
        return $productDate >= $weekDate;
    });
}

function sortByDateDesc($products){
    usort($products, function ($a, $b) {
        return strtotime($b['time']) - strtotime($a['time']);
    });
    return $products;
}


function filterByPriceRange($products, $minPrice = null, $maxPrice = null)
{
    return array_filter($products, function ($product) use ($minPrice, $maxPrice) {
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


function GetCategories()
{
    $conn = connectToDatabase();

    if ($conn === null) {
        return [];
    }
    try {

        $sql = "SELECT * FROM categories";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $catgories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $catgories;
    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] SQL query error in select ALL Catgories: " . $e->getMessage() . "\n\n";
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);

        return [];
    }
}


function getRating($id)
{
    $conn = connectToDatabase();

    if ($conn === null) {
        return [];
    }

    try {
        $sql = "SELECT ROUND(AVG(rating), 0) as 'rating' FROM `reviews` WHERE listing_id  = :id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['rating'];
    } catch (Throwable $e) {

        $errorMessage = "[" . date("Y-m-d H:i:s") . "] SQL query error in select Single product rating: " . $e->getMessage() . "\n\n";
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);
        return 0;
    }
}


function getSingleProduct($id)
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
                listings.status != 'inactive'
                AND listings.listing_id = :id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product['rating'] = getRating($id);
            return $product;
        } else {

            return [];
        }
    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] SQL query error in select Single product: " . $e->getMessage() . "\n\n";
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);

        return [];
    }
}


function getProductReviews($id)
{
    $conn = connectToDatabase();

    if ($conn === null) {
        return [];
    }

    try {
        $sql = "SELECT 
        reviews.review_id AS 'id',
        users.name AS 'user', 
        reviews.review_text AS 'text' , 
        reviews.rating, 
        reviews.user_id, 
        DATE(reviews.created_at) AS 'time'  
        FROM `reviews`
        LEFT JOIN users ON users.id = reviews.user_id
        WHERE listing_id = :id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            
        return $reviews ;
      
    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] SQL query error in select product Reviews: " . $e->getMessage() . "\n\n";
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);

        return [];
    }
}

function insertReview($user_id, $listing_id, $rating, $text){
    $conn = connectToDatabase();
    if ($conn === null) {
        return [];
    }
    try {
        $sql = "INSERT INTO `reviews`
        ( `user_id`, `listing_id`, `rating`, `review_text`) 
        VALUES 
        (:user_id, :listing_id, :rating, :r_text);";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":listing_id", $listing_id);
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":r_text", $text);
        $stmt->execute();
       
    } catch (\Throwable $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error in inserting new Review to Database: " . $e->getMessage() . "\n\n";
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);

    }
    
}



if (isset($_GET['search']) && !empty($_GET['search_inp'])) {
    $pattern = $_GET['search_inp'];
    $products = getSearchedProducts($pattern);
    $_SESSION['products'] = $products;
}


if (isset($_GET['single_id'])) {
    $id = $_GET['single_id'];

    try {
        $_SESSION['single_product'] = getSingleProduct($id);
        $_SESSION['product_reviews'] = getProductReviews($id);
        header("Location:Views/product-details.php");
        exit();
    } catch (Throwable $e) {

        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error in setting single product and its reviews to SESSION: " . $e->getMessage() . "\n\n";
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['starChosen'])) {
    $_SESSION['starChosen'] = $_POST['starChosen'];

}


if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submitReview'])) {
    $submit_review_text = $_POST['reviewTextInput'];
    $productId = $_POST['productId'];
    $starChosen = isset($_SESSION['starChosen'])? $_SESSION['starChosen'] : 5 ;
    $cur_user = 1;

    try {

        insertReview($cur_user,$productId,$starChosen, $submit_review_text );

    } catch (Throwable $e) {

        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error in inserting new Review: " . $e->getMessage() . "\n\n";
        file_put_contents("../" . ERROR_FILE, $errorMessage, FILE_APPEND);
    }

}
