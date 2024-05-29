<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();

use Template_log;
use Logger;

$logger = new Logger();

$email = null;
$password = null;
$response = null;

echo "fkdjdldddddddddddddd";
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $response = $logger->log(trim($email), trim($password));
    if ($response['granted']) {
        session_start(); // Assurez-vous que la session est démarrée
        $_SESSION['nickname'] = $response['nick'];
        echo "fkdjdlsfj";
        header("Location: ../index.php");
        exit();
    }
}

ob_start();

if (!$response) {
    $logger->generateLoginForm("", $email);
} elseif (!$response['granted']) {
    echo "<div class='magic-card' id='error'>" . $response['error'] . "</div>";
    $logger->generateLoginForm("", $email, $response['error']);
}

$content = ob_get_clean();

Template_log::render($content);
