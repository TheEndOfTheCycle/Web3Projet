<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

$realisateurs = new Realisateurs();

// Récupération de tous les réalisateurs depuis la base de données
$liste_realisateurs = $realisateurs->getAllreal();

// Tri de la liste des réalisateurs par ordre alphabétique
usort($liste_realisateurs, function($a, $b) {
    return strcmp($a->nom_real, $b->nom_real);
});

ob_start();
?>

<div class="main-container">

<div class="container-names">
    <h1>Réalisateurs</h1>

    <?php 
    $current_letter = null; // Variable pour suivre la lettre actuelle
    foreach ($liste_realisateurs as $realisateur) : 
        // Vérifie s'il y a un changement de première lettre pour afficher un titre correspondant
        if (substr($realisateur->nom_real, 0, 1) != $current_letter) : 
            if ($current_letter !== null) {
                // Fermer la ligne précédente
                echo '</div>';
            }
            // Mettre à jour la lettre actuelle
            $current_letter = substr($realisateur->nom_real, 0, 1);
            // Afficher la lettre actuelle
            echo '<h3>' . $current_letter . '</h3>';
            echo '<hr class="hr-acteurs">';
            // Ouvrir une nouvelle ligne pour les réalisateurs de cette lettre
            echo '<div class="acteurs-realisateurs">';
        endif; 
    ?>
            <div class="cat1">
                <?php if ($realisateur->nom_img != null) : ?>
                    <!-- Utiliser le chemin approprié pour l'image du réalisateur -->
                    <img src="../images/realisateurs/<?= $realisateur->nom_img ?>.jpg" alt="<?= $realisateur->nom_real ?>">
                <?php endif; ?>
                <span><?= $realisateur->nom_real ?></span>
            </div>
    <?php endforeach; ?>
    </div> <!-- Fermeture de la dernière ligne -->
</div>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>