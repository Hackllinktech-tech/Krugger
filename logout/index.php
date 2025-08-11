<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Delete relevant cookies if they exist
$cookies = ['username', 'session_token'];
foreach ($cookies as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        setcookie($cookie, '', time() - 3600, '/'); // expire in the past
    }
}

// Prevent browser from caching the page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page
header("Location: ../login/index.php");
exit;
?>
