<?php
session_start();

define("ERROR_FILE", "C:/xampp/htdocs/My_folder/Funday/Olaaa/errors.txt");



// index.php call
if (isset($_SESSION['products']) and !empty($_SESSION['products'])) {
    $products = $_SESSION['products'];
    unset($_SESSION['products']);
} else {
    $products = getTopProducts();
}



$categories = GetCategories();

if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    $products = getProductsByCategoryId($categoryId); 
    $products = addRatings($products);

    
} else{
    $products = addRatings($products);

}






// TEMP CART SIMULATION START

$totalPrice = 0;
$cart = null;

if (isset($_SESSION['user_id'])) {
    $cart = getUserCart($_SESSION['user_id']);

} else if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];

} else {
    $_SESSION['cart'] = [];
    $cart = [];
}

if (!empty($cart)) {
    $inCart = getProductsByIds($cart);
    $totalPrice = cartTotal($inCart, $cart);

} else {
    $inCart = [];
}

$inCartCount = count($inCart);
$delivery = ($totalPrice>0)? 299 : 0;




function addRatings($products){
    foreach($products as &$product){
        $product['rating'] = getRating($product['id']);

    }
    return $products;
}


function cartTotal($inCart, $cart){
    $totalPrice = 0;
    foreach ($inCart as $product) {
        $totalPrice += $product['price'] * $cart[$product['id']];
    }

    return $totalPrice;
}


function logError($message) {
    $backtrace = debug_backtrace();
    $caller = $backtrace[0];
    $file = $caller['file'];
    $line = $caller['line'];
    $errorMessage = "Error: $message in $file on line $line\n\n";
    file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);
    

}

function getUserCart($userId) {
    $cart = [];
    $pdo = connectToDatabase();
    $stmt = $pdo->prepare("SELECT listing_id, quantity FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cart[$row['listing_id']] = $row['quantity'];
    }
    
    return $cart;
}

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
        logError($e->getMessage());
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
        logError($e->getMessage());
        return [];
    }
}

function getTopProducts($limit = 6)
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
                    listings.status,
                    AVG(r.rating) AS avg_rating
                FROM 
                    listings 
                LEFT JOIN 
                    categories 
                ON 
                    categories.category_id = listings.category_id 
                LEFT JOIN 
                    reviews r 
                ON 
                    listings.listing_id = r.listing_id
                WHERE 
                    listings.status != 'inactive'
                GROUP BY listings.listing_id
                ORDER BY avg_rating DESC
                LIMIT :need;
                ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":need", $limit, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        logError($e->getMessage());

        return [];
    }
}


function getProductsByIds($cart)
{
    $conn = connectToDatabase();

    if ($conn === null) {
        return [];
    }

    // Get the keys (IDs) from the cart array
    $ids = array_keys($cart);
    
    // Prepare a string with placeholders for the IDs
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

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
                    AND listings.listing_id IN ($placeholders);";

        $stmt = $conn->prepare($sql);
        
        // Bind the IDs to the placeholders
        $stmt->execute($ids);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        logError($e->getMessage());
        return [];
    }
}


function getThisWeeksProducts()
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
                AND 
                    listings.created_at >= NOW() - INTERVAL 7 DAY;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        logError($e->getMessage());

        return [];
    }
}


function getProductsByCategoryId($categoryId)
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
                    listings.category_id = ? 
                    AND listings.status != 'inactive';";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$categoryId]);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        logError($e->getMessage());
        return [];
    }
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


function filterByLastWeek($products)
{
    $weekDate = new DateTime();
    $weekDate->modify('-7 days');

    return array_filter($products, function ($product) use ($weekDate) {
        $productDate = new DateTime($product['time']);
        return $productDate >= $weekDate;
    });
}

function sortByDateDesc($products)
{
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
        $minPrice = isset($priceRange['min']) ? floatval($priceRange['min']) : 10;
        $maxPrice = isset($priceRange['max']) ? floatval($priceRange['max']) : 100000;
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
        logError($e->getMessage());
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
        logError($e->getMessage());
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
        logError($e->getMessage());
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


        return $reviews;
    } catch (PDOException $e) {
        logError($e->getMessage());
        return [];
    }
}



function insertReview($user_id, $listing_id, $rating, $text)
{
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
    } catch (Throwable $e) {
        logError($e->getMessage());
    }
}


function addToCart() {
    $db = connectToDatabase();
    $product_id = $_POST['addtocart'];
    $quantity = isset($_POST['quantity'])?$_POST['quantity'] : 1;

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // Add to database cart
        $query = "INSERT INTO cart (user_id, listing_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$user_id, $product_id, $quantity, $quantity]);
    } else {
        // Use session cart for non-logged users
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity; // Update quantity
        } else {
            $_SESSION['cart'][$product_id] = $quantity; // Add new item
        }
    }
    return true;
}


function updateCart() {
    $db = connectToDatabase();
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($quantity == 0) {
        removeFromCart();
    }

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND listing_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$quantity, $user_id, $product_id]);
    } else {
        // Update session cart for non-logged users
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
    return true;
}

function removeFromCart() {
    $db = connectToDatabase();
    $product_id = $_POST['product_id'];

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "DELETE FROM cart WHERE user_id = ? AND listing_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$user_id, $product_id]);
    } else {
        // Remove from session cart for non-logged users
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    return true;
}

function mergeCarts() {
    $db = connectToDatabase();
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id && isset($_SESSION['cart'])) {
        $session_cart = $_SESSION['cart'];
        foreach ($session_cart as $product_id => $quantity) {
            $query = "INSERT INTO cart (user_id, listing_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = ?";
            $stmt = $db->prepare($query);
            $stmt->execute([$user_id, $product_id, $quantity, $quantity]);
        }
        // Clear session cart after merging
        unset($_SESSION['cart']);
        return true;
    } else {
        return false;
    }
}






if (isset($_GET['search']) && !empty($_GET['search_inp'])) {
    $pattern = $_GET['search_inp'];
    $products = getSearchedProducts($pattern);
    $_SESSION['products'] = $products;
    header("Location: index.php");
    exit();
}


if (isset($_POST['newthisweek']) ) {

    if ( isset($_SESSION['products'])&& !empty($_SESSION['products'])) {
        $_SESSION['products'] = filterByLastWeek($_SESSION['products'] );
    } else {
        $_SESSION['products'] = getThisWeeksProducts();
    }
    header("Location: index.php");
    exit();
   
}



if (isset($_GET['single_id'])) {
    $id = $_GET['single_id'];

    try {
        $_SESSION['single_product'] = getSingleProduct($id);
        $_SESSION['product_reviews'] = getProductReviews($id);
        header("Location:Views/product-details.php");
        exit();
    } catch (Throwable $e) {
        logError($e->getMessage());
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['starChosen'])) {
    $_SESSION['starChosen'] = $_POST['starChosen'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submitReview'])) {
    $submit_review_text = $_POST['reviewTextInput'];
    $productId = $_POST['submitReview'];
    $starChosen = isset($_SESSION['starChosen']) ? $_SESSION['starChosen'] : 5;
    $cur_user = 1;

    try {

        insertReview($cur_user, $productId, $starChosen, $submit_review_text);
    } catch (Throwable $e) {

        logError($e->getMessage());

    }
    $_SESSION['product_reviews'] = getProductReviews($productId);
    header("Location: product-details.php");
    exit();
}

if(isset($_POST['addtocart'])){
   addToCart();

    
    if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
        // Redirect to the referring page
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        // Fallback redirect if HTTP_REFERER is not set
        header("Location: product-details.php"); 
    }
    exit(); 

}

// Catch the AJAX request 
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['product_id']) and isset($_POST['quantity'])) {
    updateCart();
}