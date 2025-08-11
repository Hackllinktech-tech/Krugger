<?php
// Ensure no whitespace before this PHP block!

// Start session only if none is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$username = $_SESSION['username'];

// Handle logout before any HTML output!
if (isset($_POST['logout'])) {
    session_destroy();
    setcookie('username', '', time() - 3600, "/");
    setcookie('session_token', '', time() - 3600, "/");
    header("Location: ./login/");
    exit;
}

// TODO: Add backend logic for updating profile and credentials

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #5f2c82 0%, #49a09d 100%);
            position: relative;
            overflow: hidden;
        }
        .mountains-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            z-index: 0;
            pointer-events: none;
        }
        .dashboard-container {
            position: relative;
            z-index: 1;
            width: 400px;
            max-width: 95vw;
            padding: 2.5rem 2rem 2rem 2rem;
            margin: 80px auto;
            border-radius: 24px;
            background: rgba(255,255,255,0.14);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.20);
            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
            border: 1px solid rgba(255,255,255,0.18);
        }
        h1 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 1px;
            text-align: center;
        }
        .tabs {
            display: flex;
            margin-bottom: 2rem;
            border-radius: 14px;
            overflow: hidden;
            background: rgba(255,255,255,0.14);
        }
        .tab {
            flex: 1;
            padding: 0.8rem 0.5rem;
            text-align: center;
            cursor: pointer;
            color: #fff;
            font-size: 1.08rem;
            font-weight: 500;
            background: none;
            border: none;
            transition: background 0.2s, color 0.2s;
        }
        .tab.active {
            background: linear-gradient(90deg,#7b2ff2,#f357a8);
            color: #fff;
        }
        .tab:not(.active):hover {
            background: rgba(255,255,255,0.24);
            color: #f357a8;
        }
        .tab-content {
            display: none;
            animation: fadeIn 0.55s;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0;}
            to { opacity: 1;}
        }
        label {
            display: block;
            color: #fff;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.7rem;
            border-radius: 14px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.9);
            color: #7b2ff2;
            font-size: 1rem;
            margin-bottom: 0.9rem;
            box-shadow: 0 1px 8px 0 rgba(31, 38, 135, 0.06);
            transition: background 0.2s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            background: rgba(255,255,255,1);
        }
        button[type="submit"], .logout-btn {
            width: 100%;
            padding: 0.8rem;
            border-radius: 16px;
            border: none;
            background: linear-gradient(90deg,#7b2ff2,#f357a8);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.8rem;
            box-shadow: 0 2px 12px 0 rgba(31,38,135,.07);
            transition: background 0.18s, transform 0.15s;
        }
        button[type="submit"]:hover, .logout-btn:hover {
            background: linear-gradient(90deg,#f357a8,#7b2ff2);
            transform: translateY(-2px) scale(1.03);
        }
        .profile-info {
            color: #fff;
            text-align: left;
            margin-bottom: 1.5rem;
        }
        .profile-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(45deg,#7b2ff2,#f357a8);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <svg class="mountains-bg" viewBox="0 0 100 100" preserveAspectRatio="none">
        <defs>
            <linearGradient id="mountain-gradient" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#7b2ff2"/>
                <stop offset="100%" stop-color="#f357a8"/>
            </linearGradient>
        </defs>
        <path d="M0,80 Q20,60 40,80 Q60,100 80,80 Q90,70 100,80 L100,100 L0,100 Z"
              fill="url(#mountain-gradient)" opacity="0.8"/>
        <circle cx="80" cy="25" r="8" fill="#fff8" />
        <circle cx="15" cy="18" r="0.6" fill="#fff"/>
        <circle cx="25" cy="10" r="0.7" fill="#fff"/>
        <circle cx="40" cy="22" r="0.5" fill="#fff"/>
        <circle cx="60" cy="17" r="0.6" fill="#fff"/>
        <circle cx="70" cy="8" r="0.5" fill="#fff"/>
        <circle cx="90" cy="15" r="0.7" fill="#fff"/>
    </svg>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <div class="tabs">
            <button class="tab active" data-tab="home"><i class="fas fa-home"></i> Home</button>
            <button class="tab" data-tab="profile"><i class="fas fa-user"></i> Manage Profile</button>
            <button class="tab" data-tab="credentials"><i class="fas fa-key"></i> Update Credentials</button>
            <button class="tab" data-tab="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
        <div class="tab-content active" id="home">
            <p style="color:#fff; text-align:center;">This is your dashboard. Use the tabs above to manage your account.</p>
        </div>
        <div class="tab-content" id="profile">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <strong>Username:</strong> <?php echo htmlspecialchars($username); ?><br>
                <!-- Add more profile info here -->
            </div>
            <button type="button" onclick="alert('Profile editing not implemented yet');">Edit Profile</button>
        </div>
        <div class="tab-content" id="credentials">
            <form method="post" action="">
                <label for="new-username">New Username</label>
                <input type="text" id="new-username" name="new_username" maxlength="30" placeholder="Enter new username">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" maxlength="255" placeholder="Enter new password">
                <button type="submit" name="update_credentials">Update Credentials</button>
            </form>
            <!-- Add backend logic for credentials update -->
        </div>
        <div class="tab-content" id="logout">
            <form method="post" action="">
                <button type="submit" name="logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
            });
        });
    </script>
</body>
</html>
