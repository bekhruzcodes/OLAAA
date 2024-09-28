<?php 


function connectToDatabase(){
    $database = "playground_db";
    $user = "root";
    $password = "";
    $host = "localhost";
    $errorFile = "errors.txt";

    try {
      
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;

    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Database connection error: " . $e->getMessage() . "\n\n";
        file_put_contents($errorFile, $errorMessage, FILE_APPEND);
        return null;
    }
}

function getAllProducts() {
    $conn = connectToDatabase();

    if ($conn === null) {
        return [];  
    }

    try {
    
        $sql = "SELECT * FROM listings";
        $stmt = $conn->query($sql);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;  
    } catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] SQL query error in select all products: " . $e->getMessage() . "\n\n";
        file_put_contents('errors.txt', $errorMessage, FILE_APPEND);

        return []; 
    }
}



?>

