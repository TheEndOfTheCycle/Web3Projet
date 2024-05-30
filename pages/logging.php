<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logger = new Logger();
$email = null;
$password = null;
$response = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid email format'
        ]);
        exit();
    }

    $response = $logger->log($email, $password);

    header('Content-Type: application/json');
    if ($response['granted']) {
        $_SESSION['username'] = $response['nick'];
        $_SESSION['email'] = $email;
        echo json_encode([
            'status' => 'success',
            'message' => 'Authentication successful',
            'redirect' => '../pages/accueil.php'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $response['error'] 
        ]);
    }
    exit();
}

ob_start();
$logger->generateLoginForm($_SERVER['PHP_SELF']);
$content = ob_get_clean();
Template_log::render($content);


?>