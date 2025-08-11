<?php
// index.php - Sneaky Preview Landing Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HACKLINK TECH</title>
<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: #000;
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    /* Snowflake animation */
    .snowflake {
        position: fixed;
        top: -10px;
        font-size: 1em;
        color: rgba(0, 255, 255, 0.8);
        animation: fall linear infinite;
    }

    @keyframes fall {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0.3;
        }
    }

    /* Glowing Title */
    h1 {
        font-size: 3rem;
        text-shadow: 0 0 5px #0ff, 0 0 10px #0ff, 0 0 20px #0ff;
        animation: glow 2s infinite alternate;
    }

    @keyframes glow {
        from { text-shadow: 0 0 10px #0ff, 0 0 20px #0ff; }
        to { text-shadow: 0 0 20px #05f7ff, 0 0 30px #05f7ff; }
    }

    p {
        font-size: 1.2rem;
        margin-bottom: 20px;
        color: #bbb;
    }

    /* Get Started Button */
    .btn {
        padding: 12px 25px;
        background: transparent;
        border: 2px solid #0ff;
        color: #0ff;
        font-size: 1.2rem;
        text-decoration: none;
        border-radius: 30px;
        transition: 0.3s;
        box-shadow: 0 0 10px #0ff, inset 0 0 5px #0ff;
    }

    .btn:hover {
        background: #0ff;
        color: #000;
        box-shadow: 0 0 20px #0ff, inset 0 0 10px #0ff;
    }
</style>
</head>
<body>

<h1>HACKLINK TECH</h1>
<p>Your portal to the next level of connectivity...</p>
<a href="signup/signup.php" class="btn">Get Started</a>

<!-- Snowflake Generator -->
<script>
function createSnowflake() {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    snowflake.textContent = '❄';
    snowflake.style.left = Math.random() * window.innerWidth + 'px';
    snowflake.style.fontSize = (Math.random() * 10 + 10) + 'px';
    snowflake.style.animationDuration = (Math.random() * 5 + 5) + 's';
    snowflake.style.opacity = Math.random();
    document.body.appendChild(snowflake);

    setTimeout(() => {
        snowflake.remove();
    }, 10000);
}

setInterval(createSnowflake, 200);
</script>

</body>
</html>
