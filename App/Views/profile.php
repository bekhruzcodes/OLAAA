<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLAAA</title>
    <link rel="icon" href="../../Public/img/core-img/favicon.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-card {
            background-color: white;
          
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .profile-header {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #FFD700;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar img {
            width: 60%;
            height: 60%;
            object-fit: cover;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            margin-top: 30px;
        }

        .user-email {
            color: #FFD700;
            margin-bottom: 20px;
        }

        .about-section {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #f8f8f8;
            padding: 20px;
          
            text-align: center;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background-color: #FFD700;
            
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

      

        .stat-label {
            color: #666;
            font-size: 14px;
        }

     

        .personal-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .info-value {
            color: #666;
            padding: 12px;
            background-color: #f8f8f8;
            
            transition: all 0.2s;
        }

        .info-value:hover {
            background-color: #FFD700;
    
        }

        .log-out {
            display: inline-block;
            background-color: #FFD700;
            color: #333;
            padding: 12px 24px;
           width: 49.4%;
            text-decoration: none;
            margin-top: 20px;
            cursor: pointer;
            border: none;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.2s;
        }

        .log-out:hover {
            background-color: #333;
            color: white;
      
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .avatar {
                width: 100px;
                height: 100px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .personal-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='white' d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" alt="Profile">
            </div>
            <div class="user-details">
                <h1 class="user-name">Yuki Hayashi</h1>
                
                <div class="about-section">
                    <strong> Hello Yuki</strong> So far your journey with us is astonishing, we hope you keep enjoying OLAAA 
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">24</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">$2,156</div>
                <div class="stat-label">Total Spent</div>
            </div>
            <!-- <div class="stat-card">
                <div class="stat-value">4.9</div>
                <div class="stat-label">Rating</div>
            </div> -->
            <div class="stat-card">
                <div class="stat-value">15</div>
                <div class="stat-label">Reviews</div>
            </div>
        </div>

        <div class="personal-info">
            <div class="info-group">
                <div class="info-label">Phone</div>
                <div class="info-value">+1 234 567 890</div>
            </div>
            <div class="info-group">
                <div class="info-label">Website URL</div>
                <div class="info-value">www.example.com</div>
            </div>
            <div class="info-group">
                <div class="info-label">Street</div>
                <div class="info-value">123 Design Street</div>
            </div>
            <div class="info-group">
                <div class="info-label">City</div>
                <div class="info-value">Design City</div>
            </div>
            <div class="info-group">
                <div class="info-label">State</div>
                <div class="info-value">Design State</div>
            </div>
            <div class="info-group">
                <div class="info-label">Zip Code</div>
                <div class="info-value">12345</div>
            </div>
        </div>
        <button class="log-out" onclick="window.location.href='index.php'">Go back</button>
        <button class="log-out" onclick="logOut()">Log Out</button>
    </div>

    <script>
        function logOut() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = '../auth.php?logout=1';
            }
        }
    </script>
</body>
</html>