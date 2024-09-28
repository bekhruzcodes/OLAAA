<?php 

require_once 'core.php'; 

function loginUser($email, $password) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
      
        
    }
    return false; // manaa ushaaa comment
}

function registerUser($email, $password) {
    $conn = connectToDatabase();
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    return $stmt->execute(['email' => $email, 'password' => $hashedPassword]);
}

function logoutUser() {
    session_start();
    session_unset(); 
    session_destroy();
}


?>