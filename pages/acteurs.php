<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

$acteurs = new Acteurs();

// Récupération de tous les acteurs depuis la base de données
$liste_acteurs = $acteurs->getAllactors();

// Transformation de la première lettre de chaque mot en majuscule pour chaque acteur
foreach ($liste_acteurs as $acteur) {
    $acteur->nom_act = ucwords(strtolower($acteur->nom_act));
}

// Tri de la liste des acteurs par ordre alphabétique
usort($liste_acteurs, function ($a, $b) {
    return strcmp($a->nom_act, $b->nom_act);
});

ob_start();
?>

<div class="main-container">
    <div class="container-names">
        <h1>Acteurs</h1>

        <?php
        $current_letter = null; // Variable pour suivre la lettre actuelle
        foreach ($liste_acteurs as $acteur):
            // Vérifie s'il y a un changement de première lettre pour afficher un titre correspondant
            if (strtoupper(substr($acteur->nom_act, 0, 1)) != $current_letter):
                if ($current_letter !== null) {
                    // Fermer la ligne précédente
                    echo '</div>';
                }
                // Mettre à jour la lettre actuelle
                $current_letter = strtoupper(substr($acteur->nom_act, 0, 1));
                // Afficher la lettre actuelle
                echo '<h3>' . $current_letter . '</h3>';
                echo '<hr class="hr-acteurs">';
                // Ouvrir une nouvelle ligne pour les acteurs de cette lettre
                echo '<div class="acteurs-realisateurs">';
            endif;
            ?>
            <div class="cat1">
                <?php if ($acteur->nom_img != null): ?>
                    <img src="../images/acteurs/<?= $acteur->nom_img ?>" alt="<?= $acteur->nom_act ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-trash3 hidden c" viewBox="0 0 16 16">
                        <path
                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                    </svg>
                <?php endif; ?>
                <span><?= $acteur->nom_act ?></span>
            </div>

        <?php endforeach; ?>
    </div> <!-- Fermeture de la dernière ligne -->
</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>