<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login Olaaa</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/login.css">
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form>
        <h3>Login</h3>

        <label for="email">Email</label>
        <input type="email" placeholder="Email" name="email" id="email">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="password">

        <label for="remember">
            <input type="checkbox" id="remember" style="margin-right: 8px;"> Remember Me
        </label>


        <button>Log In</button>

        <div class="center">
            <p>Don't have an account ? <a href="signup.php" class="link-text">Register</a></p>

        </div>

    </form>
</body>

</html>