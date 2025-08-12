<?php
// signup/index.php
include __DIR__ . '/../config.php'; // FIXED PATH
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $username   = trim($_POST['username']);
    $password   = trim($_POST['password']);

    if ($first_name && $last_name && $email && $username && $password) {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username already taken!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $email, $username, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: ../login/index.php?registered=1");
                exit;
            } else {
                $message = "Registration failed. Try again.";
            }
        }
        $stmt->close();
    } else {
        $message = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HACKLINK TECH Registration</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #0f0f0f;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background: radial-gradient(circle at top, #021B79, #0575E6);
    }

    .container {
      background: rgba(255, 255, 255, 0.05);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 0 25px rgba(5, 230, 255, 0.5);
      width: 75vw;
      height: 75vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
    }

    h2 {
      color: #05e6ff;
      text-shadow: 0 0 10px #05e6ff;
      margin-bottom: 25px;
    }

    input {
      width: 80%;
      padding: 12px;
      margin: 10px auto;
      border: none;
      border-radius: 8px;
      background: rgba(255,255,255,0.1);
      color: white;
      font-size: 1rem;
      outline: none;
    }

    input:focus {
      box-shadow: 0 0 8px #05e6ff;
    }

    button {
      width: 80%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #05e6ff;
      color: black;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 12px;
    }

    button:hover {
      box-shadow: 0 0 15px #05e6ff;
    }

    .message {
      margin-top: 10px;
      color: #ff4d4d;
    }

    a {
      color: #05e6ff;
      text-decoration: none;
    }

    a:hover {
      text-shadow: 0 0 5px #05e6ff;
    }

    @media (max-width: 768px) {
      .container {
        width: 90vw;
        height: auto;
        padding: 20px;
      }
      input, button {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2><i class="fas fa-user-plus"></i> HACKLINK TECH Registration</h2>
    <?php if ($message): ?>
      <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="text" name="first_name" placeholder="First Name" required>
      <input type="text" name="last_name" placeholder="Last Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="username" id="username" placeholder="Username" required>
      <small id="username-status" style="display:block; margin-bottom:8px;"></small>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit"><i class="fas fa-user-plus"></i> Register</button>
    </form>
    <p>Already have an account? <a href="../login/index.php">Login here</a></p>
  </div>

  <script>
    document.getElementById("username").addEventListener("keyup", function(){
      let username = this.value;
      if(username.length > 2){
        fetch("check_username.php?username=" + encodeURIComponent(username))
        .then(res => res.text())
        .then(data => {
          let status = document.getElementById("username-status");
          status.style.color = (data.includes("available")) ? "#05e6ff" : "#ff4d4d";
          status.innerHTML = data;
        });
      }
    });
  </script>
</body>
</html>
