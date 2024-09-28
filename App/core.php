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


?>

