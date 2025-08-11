<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// List of cookies to clear
$cookies = ['username', 'session_token'];

// Clear each cookie
foreach ($cookies as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        // Set expiration in the past & secure attributes
        setcookie($cookie, '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);
    }
}

// Force browser not to cache this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Redirect user to login page
header("Location: ../login/");
exit;
