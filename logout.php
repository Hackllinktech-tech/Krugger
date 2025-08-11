<?php
session_start();
session_destroy();
setcookie('username', '', time() - 3600, "/");
setcookie('session_token', '', time() - 3600, "/");
header("Location: ./login/");
exit;
?>
