<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();

use Template_log;
use Logger;

session_start(); 

$logger = new Logger();
$email = null;
$password = null;
$response = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $response = $logger->log($email, $password);

    header('Content-Type: application/json');
    if ($response['granted']) {
        $_SESSION['username'] = $response['nick'];
        $_SESSION['email'] = $email;
        echo json_encode([
            'status' => 'success',
            'message' => 'Authentication successful'
        ]);
        
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $response['error'] ?? 'Authentication failed'
        ]);
    }
    exit();
}

ob_start();
$logger->generateLoginForm($_SERVER['PHP_SELF']);
$content = ob_get_clean();
Template_log::render($content);