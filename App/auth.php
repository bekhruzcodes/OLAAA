<?php
require_once 'core.php';

function loginUser($email, $password)
{


    try {
        $conn = connectToDatabase();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email ");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && (password_verify($password, $user['password']))) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            return true;
        }

        return false;

    } catch (PDOException $e) {
        logError($e->getMessage());
        return false;
    }

}


function registerUser($name, $email, $password)
{
    try {

        $conn = connectToDatabase();
        $hashedPassword = password_hash($password, true);
        $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
        return $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'name' => $name]);
    } catch (PDOException $e) {
        logError($e->getMessage());
    }
}

function logoutUser()
{
    session_unset();
    session_destroy();
}

function rememberUser($email)
{
    try {
        setcookie('email', $email, time() + 259200, "/", "", true, true);
    } catch (PDOException $e) {
        logError($e->getMessage());
    }
}



###  MAIN


// Logging User In
if (isset($_POST['log_user'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $login = loginUser($email, $password);

        if ($login) {
            if (isset($_POST['remember'])) {
                rememberUser($email);
            }
            header("Location:Views/index.php");
            exit();
        } else {

            logError("Failed to log user in form processing");
            header("Location:Views/login.php");
            exit();
        }
    }
}

// Register User
if (isset($_POST['sign_user'])) {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (registerUser($name, $email, $password)) {
        header("Location:Views/login.php");
        exit();
    } else {

        logError("Failed to register new user while processing form");
    }
}


// Logging Out User
if (isset($_POST['logout_user'])) {
    logoutUser();
}
