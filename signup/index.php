<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}

include '../config.php';
$query = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize all inputs
    $first_name = $query->validate(trim($_POST['first_name'] ?? ''));
    $last_name = $query->validate(trim($_POST['last_name'] ?? ''));
    $email = $query->validate(strtolower(trim($_POST['email'] ?? '')));
    $username = $query->validate(strtolower(trim($_POST['username'] ?? '')));
    $password = $_POST['password'] ?? '';
    $terms = isset($_POST['terms']);

    // Server-side validation
    $errors = [];

    if (!$first_name || strlen($first_name) > 30) {
        $errors[] = "Invalid first name.";
    }

    if (!$last_name || strlen($last_name) > 30) {
        $errors[] = "Invalid last name.";
    }

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $errors[] = "Invalid email address.";
    }

    if (!$username || !preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($username) > 30) {
        $errors[] = "Invalid username.";
    }

    if (strlen($password) < 6 || strlen($password) > 255) {
        $errors[] = "Password must be between 6 and 255 characters.";
    }

    if (!$terms) {
        $errors[] = "You must agree to the Terms & Conditions.";
    }

    // Check if email or username already exists (server-side)
    $email_exists = $query->select('users', 'id', 'email = ?', [$email], 's');
    $username_exists = $query->select('users', 'id', 'username = ?', [$username], 's');

    if (!empty($email_exists)) {
        $errors[] = "This email exists!";
    }

    if (!empty($username_exists)) {
        $errors[] = "This username exists!";
    }

    if (empty($errors)) {
        $hashed_password = $query->hashPassword($password);

        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'username' => $username,
            'password' => $hashed_password
        ];

        $result = $query->insert('users', $data);

        if (!empty($result)) {
            $user_id_arr = $query->select('users', 'id', 'username = ?', [$username], 's');
            $user_id = !empty($user_id_arr) ? $user_id_arr[0]['id'] : null;

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;

            setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
            setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);

            ?>
            <script>
                window.onload = function () {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registration successful',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '../';
                    });
                };
            </script>
            <?php
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Registration failed. Please try again later.',
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Error',
                html: '" . implode("<br>", array_map('htmlspecialchars', $errors)) . "'
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../src/css/login_signup_cloud.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-left">
                <h2>Hello, friend!</h2>
                <form id="signupForm" method="post" action="" autocomplete="off" novalidate>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="first_name" name="first_name" placeholder="Name" required maxlength="30">
                    </div>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="last_name" name="last_name" placeholder="Last Name" required maxlength="30">
                    </div>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" placeholder="E-mail" required maxlength="100">
                        <p id="email-message"></p>
                    </div>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-user-tag"></i></span>
                        <input type="text" id="username" name="username" placeholder="Username" required maxlength="30">
                        <p id="username-message"></p>
                    </div>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="Password" required maxlength="255">
                        <button type="button" id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">I read and agree to <a href="#">Terms & Conditions</a></label>
                    </div>
                    <button type="submit" id="submit" class="create-account-btn">Create Account</button>
                    <div class="text-center">
                        <p>Already have an account? <a href="../login/">Sign in</a></p>
                    </div>
                </form>
            </div>
            <div class="card-right">
                <h2>Glad to see you!</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam dignissim.</p>
            </div>
            <!-- Cloud divider SVG -->
            <svg class="cloud-divider" viewBox="0 0 600 200" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,100 Q150,200 300,100 T600,100 V200 H0 Z" fill="#fff"/>
            </svg>
        </div>
    </div>
    <script src="../src/js/sweetalert2.js"></script>
    <script>
        let isEmailAvailable = true;
        let isUsernameAvailable = true;

        function validateUsernameFormat(username) {
            const usernamePattern = /^[a-zA-Z0-9_]+$/;
            return usernamePattern.test(username);
        }

        function validateEmailFormat(email) {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return emailPattern.test(email);
        }

        document.getElementById('email').addEventListener('input', function () {
            let email = this.value;
            if (email.length > 0 && validateEmailFormat(email)) {
                fetch('check_availability.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}`
                })
                    .then(response => response.json())
                    .then(data => {
                        const messageElement = document.getElementById('email-message');
                        if (data.exists) {
                            messageElement.textContent = 'This email exists!';
                            isEmailAvailable = false;
                        } else {
                            messageElement.textContent = '';
                            isEmailAvailable = true;
                        }
                    });
            }
        });

        document.getElementById('username').addEventListener('input', function () {
            let username = this.value;
            const messageElement = document.getElementById('username-message');

            if (!validateUsernameFormat(username)) {
                messageElement.textContent = 'Username can only contain letters, numbers, and underscores!';
                isUsernameAvailable = false;
                return;
            }

            if (username.length > 0) {
                fetch('check_availability.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `username=${encodeURIComponent(username)}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            messageElement.textContent = 'This username exists!';
                            isUsernameAvailable = false;
                        } else {
                            messageElement.textContent = '';
                            isUsernameAvailable = true;
                        }
                    });
            } else {
                messageElement.textContent = '';
            }
        });

        document.getElementById('signupForm').addEventListener('submit', function (event) {
            let email = document.getElementById('email').value;
            const emailMessageElement = document.getElementById('email-message');
            let username = document.getElementById('username').value;
            const usernameMessageElement = document.getElementById('username-message');
            let password = document.getElementById('password').value;
            let termsChecked = document.getElementById('terms').checked;

            let valid = true;

            if (!validateEmailFormat(email)) {
                emailMessageElement.textContent = 'Email format is incorrect!';
                valid = false;
            }

            if (!validateUsernameFormat(username)) {
                usernameMessageElement.textContent = 'Username can only contain letters, numbers, and underscores!';
                valid = false;
            }

            if (isEmailAvailable === false) {
                emailMessageElement.textContent = 'This email exists!';
                valid = false;
            }

            if (isUsernameAvailable === false) {
                usernameMessageElement.textContent = 'This username exists!';
                valid = false;
            }

            if (password.length < 6 || password.length > 255) {
                Swal.fire({
                    icon: 'error',
                    title: 'Weak Password',
                    text: 'Password must be between 6 and 255 characters.'
                });
                valid = false;
            }

            if (!termsChecked) {
                Swal.fire({
                    icon: 'error',
                    title: 'Agreement Required',
                    text: 'You must agree to the Terms & Conditions.'
                });
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const toggleIcon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
