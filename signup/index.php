<?php
session_start();

// If already logged in, redirect
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../dashboard/");
    exit;
}

// Include config
include __DIR__ . '/../config.php';
$db = new Database();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = $db->validate($_POST['username'] ?? '');
    $password = $db->validate($_POST['password'] ?? '');
    $confirm_password = $db->validate($_POST['confirm_password'] ?? '');

    // Check empty fields
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Check if username exists
        $existingUser = $db->select("users", "*", "username = ?", [$username], "s");

        if (!empty($existingUser)) {
            $message = "Username is already taken.";
        } else {
            // Hash password
            $hashedPassword = $db->hashPassword($password);

            // Insert user
            $insertId = $db->insert("users", [
                "username" => $username,
                "password" => $hashedPassword
            ]);

            if (is_numeric($insertId)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;

                header("Location: ../dashboard/");
                exit;
            } else {
                $message = "Error creating account: " . $insertId;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 50px;
        }
        .signup-container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.2);
        }
        .signup-container h2 {
            text-align: center;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            background: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background: #45a049; }
        .error { color: red; text-align: center; margin-bottom: 15px; }
        .success { color: green; text-align: center; margin-bottom: 15px; }
    </style>
    <script>
        function checkUsername() {
            let username = document.getElementById("username").value;
            if (username.length > 2) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "check_username.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    document.getElementById("username-status").innerHTML = this.responseText;
                };
                xhr.send("username=" + encodeURIComponent(username));
            } else {
                document.getElementById("username-status").innerHTML = "";
            }
        }
    </script>
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <?php if ($message): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" id="username" name="username" placeholder="Username" onkeyup="checkUsername()" required>
            <span id="username-status"></span>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
