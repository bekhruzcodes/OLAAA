<?php 
require_once 'core.php'; 

function loginUser($email, $password) {

    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email and password = :password");
    $stmt->execute(['email' => $email,'password' => $password]);
    $user = $stmt->fetchAll(PDO :: FETCH_ASSOC );
    
    
    if ($user && ($password == $user[0]['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
            return true;    
        }
        return false;
}


function registerUser($name , $email, $password) {
    try{

        $conn = connectToDatabase();
        $hashedPassword = md5($password);
        $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
        return $stmt->execute(['email' => $email, 'password' => $hashedPassword ,'name' => $name]);
    }catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error While register COOKIE: " . $e->getMessage() . "\n\n";
        file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);
    }
}

function logoutUser() {
    session_start();
    session_unset(); 
    session_destroy();
}

function rememberUser($email){
    try{
        setcookie('email', $email, time() + 259200, "/", "", true, true);
    }catch (PDOException $e) {
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error While Setting COOKIE: " . $e->getMessage() . "\n\n";
        file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);
    }
}



#MAIN


// Logging In User
if(isset($_POST['log_user'])){
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $password = md5($password);
        $login = loginUser($email,$password);
        
        if($login){
            if(isset($_POST['remember'])){
                rememberUser($email);
            }
            header("Location:Views/index.php");
            exit();
        }else{
            $errorMessage = "[" . date("Y-m-d H:i:s") . "] Erro While Logging In User: " . "\n\n";
            file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);
        }

    }
}

// Register User
if(isset($_POST['sign_user'])){

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if(registerUser($name,$email,$password)){
        header("Location:Views/login.php");
        exit();

    }else{
        $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error While Signing user: " . "\n\n";
        file_put_contents(ERROR_FILE, $errorMessage, FILE_APPEND);
    }
}


// Logging Out User
if(isset($_POST['logout_user'])){
    logoutUser();
}


?>