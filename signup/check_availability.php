<?php
// check_username.php

// Load database connection
include __DIR__ . '/../config.php';

// Ensure we have a username to check
if (isset($_GET['username']) && !empty(trim($_GET['username']))) {
    $username = trim($_GET['username']);

    // Prepare SQL to check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Username already taken ❌";
    } else {
        echo "Username available ✅";
    }

    $stmt->close();
} else {
    echo "Please enter a username";
}

$conn->close();
