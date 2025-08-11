<?php
// Ensure no whitespace before this PHP block!
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

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    setcookie('username', '', time() - 3600, "/");
    setcookie('session_token', '', time() - 3600, "/");
    header("Location: ./login/");
    exit;
}

// Handle credentials update
if (isset($_POST['update_credentials'])) {
    $new_username = trim($_POST['new_username']);
    $new_password = trim($_POST['new_password']);

    if (!empty($new_username) || !empty($new_password)) {
        if (!empty($new_username)) {
            $stmt = $query->conn->prepare("SELECT id FROM users WHERE username = ? AND username != ?");
            $stmt->bind_param("ss", $new_username, $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<script>alert('Username already taken');</script>";
                $stmt->close();
                goto end_of_php;
            }
            $stmt->close();
        }

        $update_sql = "UPDATE users SET ";
        $params = [];
        $types = "";

        if (!empty($new_username)) {
            $update_sql .= "username = ?, ";
            $params[] = $new_username;
            $types .= "s";
        }
        if (!empty($new_password)) {
            $hashed = password_hash($new_password, PASSWORD_BCRYPT);
            $update_sql .= "password = ?, ";
            $params[] = $hashed;
            $types .= "s";
        }

        $update_sql = rtrim($update_sql, ", ") . " WHERE username = ?";
        $params[] = $username;
        $types .= "s";

        $stmt = $query->conn->prepare($update_sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            if (!empty($new_username)) {
                $_SESSION['username'] = $new_username;
                $username = $new_username;
            }
            echo "<script>alert('Credentials updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating credentials');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in at least one field');</script>";
    }
}

end_of_php:
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - HACKLINK TECH</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="favicon.ico">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #5f2c82 0%, #49a09d 100%);
        margin: 0;
        min-height: 100vh;
        color: white;
    }
    .dashboard-container {
        max-width: 450px;
        background: rgba(255,255,255,0.12);
        padding: 2rem;
        border-radius: 20px;
        margin: 60px auto;
        backdrop-filter: blur(8px);
    }
    h1 {
        text-align: center;
        font-size: 1.8rem;
        font-weight: bold;
        background: linear-gradient(90deg, #ff00ff, #00ffff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 20px rgba(255,255,255,0.6);
    }
    .btn {
        display: block;
        width: 100%;
        padding: 0.9rem;
        margin: 0.6rem 0;
        border: none;
        border-radius: 15px;
        background: linear-gradient(90deg,#7b2ff2,#f357a8);
        color: white;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn:hover {
        background: linear-gradient(90deg,#f357a8,#7b2ff2);
        transform: scale(1.05);
    }
    .coming-soon {
        text-align: center;
        font-size: 1rem;
        margin-top: 20px;
        font-weight: bold;
        color: #fff;
        text-shadow: 0 0 8px #ff00ff, 0 0 12px #00ffff;
        animation: glow 2s ease-in-out infinite alternate;
    }
    @keyframes glow {
        from { text-shadow: 0 0 8px #ff00ff, 0 0 12px #00ffff; }
        to { text-shadow: 0 0 18px #ff00ff, 0 0 24px #00ffff; }
    }
</style>
</head>
<body>
<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

    <button class="btn" onclick="window.location.href='dashboard/details.php'">
        <i class="fas fa-users"></i> Founders
    </button>
    <button class="btn" onclick="window.location.href='info.php'">
        <i class="fas fa-info-circle"></i> Info
    </button>
    <button class="btn" onclick="window.location.href='#'">
        <i class="fas fa-user"></i> Manage Profile
    </button>
    <button class="btn" onclick="window.location.href='#'">
        <i class="fas fa-key"></i> Update Credentials
    </button>
    <form method="post" style="margin:0;">
        <button class="btn" type="submit" name="logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>

    <div class="coming-soon">✨ Other features coming soon... ✨</div>
</div>
</body>
</html>
