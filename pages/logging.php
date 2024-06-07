<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();

session_start();


$logger = new Logger();

// Vérifie si l'utilisateur est déjà connecté
if(isset($_SESSION['username'])) {
    // Utilisateur connecté, affiche le lien de déconnexion
    echo '<li><a href="../index.php">Déconnexion Admin</a></li>';
} else {
    // Utilisateur non connecté, affiche le formulaire de connexion
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email']) && isset($_POST['password'])) {
        // Traitement de la soumission du formulaire de connexion
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Validation de l'adresse email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email format'
            ]);
            exit();
        }

        // Tentative d'authentification
        $response = $logger->log($email, $password);

        header('Content-Type: application/json');
        if ($response['granted']) {
            // Authentification réussie, stocke les informations de session
            $_SESSION['username'] = $response['nick'];
            $_SESSION['email'] = $email;
            echo json_encode([
                'status' => 'success',
                'message' => 'Authentication successful',
                'redirect' => '../pages/accueil.php'
            ]);
        } else {
            // Authentification échouée, renvoie un message d'erreur
            echo json_encode([
                'status' => 'error',
                'message' => $response['error'] 
            ]);
        }
        exit();
    } else {
        // Affiche le formulaire de connexion
        ob_start();
        $logger->generateLoginForm($_SERVER['PHP_SELF']);
        $content = ob_get_clean();
        Template_log::render($content);
    }
}


