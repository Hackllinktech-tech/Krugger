<?php
session_start();
session_unset();
session_destroy();

// Clear cookies
$cookies = ['username', 'session_token'];
foreach ($cookies as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        setcookie($cookie, '', time() - 3600, '/');
    }
}

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logging Out - HACKLINK TECH</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: radial-gradient(circle at top, #021B79, #0575E6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        text-align: center;
    }
    .logout-box {
        background: rgba(255,255,255,0.05);
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(5, 230, 255, 0.5);
        animation: fadeIn 0.8s ease-in-out;
    }
    h2 {
        color: #05e6ff;
        text-shadow: 0 0 10px #05e6ff;
    }
    p {
        font-size: 1rem;
        margin-top: 10px;
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>
<meta http-equiv="refresh" content="2;url=../login/">
</head>
<body>
    <div class="logout-box">
        <h2>Logging out...</h2>
        <p>Redirecting you to the login page.</p>
    </div>
</body>
</html>
