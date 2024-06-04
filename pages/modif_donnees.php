<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    $modif = htmlspecialchars($_POST['modif'], ENT_QUOTES, 'UTF-8');
    $titre = htmlspecialchars($_GET['titre'], ENT_QUOTES, 'UTF-8');
    $annee = htmlspecialchars($_GET['annee'], ENT_QUOTES, 'UTF-8');

    // Vérifiez quel paramètre est défini
    if (!empty($titre)) {
        $films = new Films();
        $filmId = $films->getFilmIdByTitle($titre);

        // Vérifiez si l'identifiant du film a été trouvé
        if ($filmId === null) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Film non trouvé avec le titre donné']);
            exit;
        }

        // Mettre à jour le titre du film
        $films->updateFilmTitle($filmId, $modif);

        // Rediriger en fonction des paramètres définis
        $redirectParams = '';
        if ($annee) {
            $redirectParams = '?titre=' . urlencode($modif) . '&annee=' . urlencode($annee);
        } else {
            $redirectParams = '?titre=' . urlencode($modif);
        }

        header("Location: movies.php" . $redirectParams);
        exit;
    } elseif (!empty($annee)) {
        // Si seulement l'année est définie
        $films = new Films();
        $filmId = $films->getFilmIdByTitle($titre);

        // Vérifiez si l'identifiant du film a été trouvé
        if ($filmId === null) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Film non trouvé avec le titre donné']);
            exit;
        }

        // Mettre à jour l'année du film
        // Ajoutez votre code pour mettre à jour l'année du film ici
        $films->updateFilmReleaseDate($filmId, $modif);

        // Rediriger en fonction des paramètres définis
        header("Location: movies.php?titre=" . urlencode($titre) . "&annee=" . urlencode($newAnnee));
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Paramètres manquants']);
        exit;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Requête invalide']);
    exit;
}
?>
