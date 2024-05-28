<?php
require_once "../config.php"; // Assurez-vous d'importer le fichier de configuration de la base de données
require_once "../class/Realisateurs.php"; // Importez la classe Realisateurs

// Instanciez la classe Realisateurs
$realisateurs = new Realisateurs();

// Récupérez tous les réalisateurs à partir de la base de données
$allRealisateurs = $realisateurs->getAllreal();

ob_start();
?>

<div class="container-names">
    <h1>Realisateurs</h1>

    <?php 
    // Parcourez les réalisateurs récupérés et affichez-les
    foreach($allRealisateurs as $realisateur) { ?>
        <div class="acteurs-realisateurs">
            <div class="cat1">
                <!-- Utilisez les données du réalisateur pour afficher son nom et son image -->
                <img src="../images/realisateurs/<?= $realisateur->nom_img ?>.jpg" alt="<?= $realisateur->nom_real ?>">
                <span><?= $realisateur->nom_real ?></span>
            </div>
        </div>
    <?php } ?>

</div>

<?php
$content = ob_get_clean();
Template::render($content);
?>
