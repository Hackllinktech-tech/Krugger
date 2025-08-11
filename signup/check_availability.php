<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}

include '../config.php';
$query = new Database();

$response = [
    'exists' => false,
    'field'  => '',
    'message'=> ''
];

// Check username availability
if (isset($_GET['username'])) {
    $username = trim($_GET['username']);
    $username_check = $query->select('users', 'username', 'username = ?', [$username], 's');

    if ($username_check) {
        $response['exists'] = true;
        $response['field']  = 'username';
        $response['message'] = "❌ Username already taken";
    } else {
        $response['message'] = "✅ Username available";
    }
}

// Check email availability
if (isset($_GET['email'])) {
    $email = trim($_GET['email']);
    $email_check = $query->select('users', 'email', 'email = ?', [$email], 's');

    if ($email_check) {
        $response['exists'] = true;
        $response['field']  = 'email';
        $response['message'] = "❌ Email already registered";
    } else {
        $response['message'] = "✅ Email available";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
