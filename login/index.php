<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}

include '../config.php';
$query = new Database();

if (isset($_COOKIE['username']) && isset($_COOKIE['session_token'])) {

    if (session_id() !== $_COOKIE['session_token']) {
        session_write_close();
        session_id($_COOKIE['session_token']);
        session_start();
    }

    $result = $query->select('users', 'id', "username = ?", [$_COOKIE['username']], 's');

    if (!empty($result)) {
        $user = $result[0];

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['user_id'] = $user['id'];

        header("Location: ../");
        exit;
    }
}

if (isset($_POST['submit'])) {
    $username = strtolower($_POST['username']);
    $password = $query->hashPassword($_POST['password']);
    $result = $query->select('users', '*', "username = ? AND password = ?", [$username, $password], 'ss');

    if (!empty($result)) {
        $user = $result[0];

        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
        setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);

        ?>
        <script>
            window.onload = function () {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Login successful',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '../';
                });
            };
        </script>
        <?php
    } else {
        ?>
        <script>
            window.onload = function () {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Incorrect information',
                    text: 'Login or password is incorrect',
                    showConfirmButton: true
                });
            };
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>Login</title>
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
        /* Mountains background - SVG */
        .mountains-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            z-index: 0;
            pointer-events: none;
        }
        /* Glassmorphism card */
        .form-container {
            position: relative;
            z-index: 1;
            width: 350px;
            padding: 2rem 2.5rem;
            margin: 80px auto;
            border-radius: 24px;
            background: rgba(255,255,255,0.14);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.20);
            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
            border: 1px solid rgba(255,255,255,0.18);
            text-align: center;
        }
        h1 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .form-group {
            margin-bottom: 1.4rem;
            text-align: left;
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
            padding: 0.75rem;
            border-radius: 16px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.7);
            color: #7b2ff2;
            font-size: 1rem;
            margin-bottom: 0.2rem;
            box-shadow: 0 1px 8px 0 rgba(31, 38, 135, 0.06);
            transition: background 0.2s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            background: rgba(255,255,255,1);
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #7b2ff2;
            font-size: 1.2rem;
            cursor: pointer;
        }
        button[type="submit"] {
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
        button[type="submit"]:hover:enabled {
            background: linear-gradient(90deg,#f357a8,#7b2ff2);
            transform: translateY(-2px) scale(1.03);
        }
        button:disabled {
            background: #ddd;
            color: #bbb;
            cursor: not-allowed;
        }
        .text-center {
            margin-top: 1.2rem;
        }
        .text-center p {
            color: #fff;
        }
        .text-center a {
            color: #f357a8;
            text-decoration: underline;
            font-weight: 600;
        }
        #username-error {
            font-size: 0.85rem;
            margin-top: 2px;
            display: block;
        }
        @media (max-width: 500px) {
            .form-container {
                width: 95vw;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Mountains SVG Background -->
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
        <!-- Stars -->
        <circle cx="15" cy="18" r="0.6" fill="#fff"/>
        <circle cx="25" cy="10" r="0.7" fill="#fff"/>
        <circle cx="40" cy="22" r="0.5" fill="#fff"/>
        <circle cx="60" cy="17" r="0.6" fill="#fff"/>
        <circle cx="70" cy="8" r="0.5" fill="#fff"/>
        <circle cx="90" cy="15" r="0.7" fill="#fff"/>
    </svg>

    <div class="form-container">

        <h1>Login</h1>

        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required maxlength="30">
                <small id="username-error" style="color: #f357a8;"></small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required maxlength="255">
                    <button type="button" id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></button>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" id="submit" disabled>Login</button>
            </div>
        </form>

        <div class="text-center">
            <p>Don't have an account? <a href="../signup/">Sign Up</a></p>
        </div>

    </div>

    <script src="../src/js/sweetalert2.js"></script>
    <script>
        const usernameField = document.getElementById('username');
        const usernameError = document.getElementById('username-error');
        const submitButton = document.getElementById('submit');

        function validateForm() {
            const username = usernameField.value;
            const usernamePattern = /^[a-zA-Z0-9_]+$/;
            if (!usernamePattern.test(username)) {
                usernameError.textContent = "Username can only contain letters, numbers, and underscores!";
                submitButton.disabled = true;
            } else {
                usernameError.textContent = "";
                submitButton.disabled = false;
            }
        }

        usernameField.addEventListener('input', validateForm);

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
