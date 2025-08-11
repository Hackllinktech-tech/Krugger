<?php
// info.php
// This page explains about the technological platform founded by HACKLINK TECH

// Optional: Add login protection if dashboard is private
// session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header("Location: login.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About HACKLINK TECH Platform</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #05e6ff;
      --secondary: #0f0f0f;
      --text-light: #ffffff;
      --text-muted: rgba(255, 255, 255, 0.7);
      --glow: 0 0 15px var(--primary), 0 0 25px var(--primary);
    }
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      background-color: var(--secondary);
      color: var(--text-light);
      overflow-x: hidden;
      line-height: 1.6;
    }
    .animated-bg {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      z-index: -1;
      overflow: hidden;
    }
    .electric-pulse {
      position: absolute;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle, rgba(5, 230, 255, 0.1) 0%, transparent 70%);
      animation: pulse 3s infinite;
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 1; }
    }
    header {
      padding: 20px;
      text-align: center;
    }
    header h1 {
      color: var(--primary);
      text-shadow: var(--glow);
    }
    main {
      max-width: 900px;
      margin: auto;
      padding: 20px;
      backdrop-filter: blur(5px);
      background: rgba(255,255,255,0.03);
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(5, 230, 255, 0.2);
    }
    h2 {
      color: var(--primary);
      margin-bottom: 10px;
    }
    p {
      color: var(--text-muted);
      margin-bottom: 15px;
    }
    .highlight {
      color: var(--primary);
      font-weight: bold;
    }
    footer {
      text-align: center;
      padding: 20px;
      font-size: 0.8rem;
      color: var(--text-muted);
    }
    .btn-back {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      border-radius: 30px;
      border: none;
      font-weight: 500;
      cursor: pointer;
      background: var(--primary);
      color: var(--secondary);
      text-decoration: none;
      transition: 0.3s;
    }
    .btn-back:hover {
      box-shadow: var(--glow);
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="animated-bg">
    <div class="electric-pulse"></div>
  </div>

  <header>
    <h1>HACKLINK TECH Platform</h1>
    <p>Innovating the future, one connection at a time.</p>
  </header>

  <main>
    <h2>About the Platform</h2>
    <p>The <span class="highlight">HACKLINK TECH Platform</span> is a cutting-edge technological ecosystem designed to empower developers, entrepreneurs, and tech enthusiasts worldwide. Founded by <span class="highlight">HACKLINK TECH</span>, the platform combines AI, cloud computing, and secure communication technologies to create a space where innovation thrives.</p>

    <h2>Core Features</h2>
    <p>✔ <strong>Secure Messaging</strong> – End-to-end encrypted messaging for businesses and individuals.<br>
       ✔ <strong>AI Integration</strong> – Built-in artificial intelligence tools for automation and analytics.<br>
       ✔ <strong>Cloud Services</strong> – Scalable cloud infrastructure for apps, bots, and enterprise solutions.<br>
       ✔ <strong>Developer Tools</strong> – APIs and SDKs to build, deploy, and scale solutions with ease.</p>

    <h2>Our Mission</h2>
    <p>Our mission is to make advanced technology accessible to everyone, regardless of location or resources. We believe in building tools that enhance productivity, security, and connectivity, while fostering a global developer community.</p>

    <h2>Future Vision</h2>
    <p>We envision the HACKLINK TECH Platform as the go-to hub for innovation — a place where startups launch, ideas grow, and technology connects people in ways never seen before.</p>

    <a href="dashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> HACKLINK TECH. All rights reserved.</p>
  </footer>
</body>
</html>
