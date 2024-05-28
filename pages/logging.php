<?php
require_once __DIR__ . '/../autoloader.php';

// Inclure la classe Login
require_once '../class/Login.php';

ob_start();

// Initialiser $login
$login = new Login();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs email et password ont été envoyés
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        // Récupérer les valeurs des champs email et password
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Appeler la méthode log de la classe Login pour gérer l'authentification
        $authResult = $login->log($email, $password);
    }
}
?>

<div class="login-container">
    <div id="form-container">
        <img src="../images/movies.png" alt="image">
        <div class="login-form">
            <legend>
                <div id="logo"><span id="first-letter">C</span>ine<span id="first-letter">C</span>ollection</div>
            </legend>
            <div class="formulaire">
                <h2>Bienvenue</h2>
                <p>Entrer vos identifiants.</p>
                <?php
                    if (!isset($authResult)) {
                        // Afficher le formulaire de connexion si $authResult n'est pas défini
                        $login->generateLoginForm("");
                    } elseif (!$authResult['granted']) {
                        // Afficher le message d'erreur et le formulaire de connexion si l'authentification a échoué
                        echo "<div class='error-message'>" . $authResult['error'] . "</div>";
                        $login->generateLoginForm("");
                    } else {
                        // Rediriger vers la page d'accueil si l'authentification est réussie
                        header("Location: acceuil.php");
                        exit();
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
Template::render($content);
?>
