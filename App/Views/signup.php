<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration Olaaa</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/signup.css">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action = "../auth.php" method = "POST">
        <h3>Register</h3>

        <label for="name">Full Name</label>
        <input type="text" placeholder="Full Name" name="name" id="name" required>

        <label for="email">Email</label>
        <input type="email" placeholder="Email" name="email" id="email" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="password" required>

        <button type="submit" name = "sign_user">Register</button>

        <div class="center">
            <p>Already have an account ? <a href="login.php" class="link-text">Login</a></p>
        </div>

    </form>
</body>
</html>
