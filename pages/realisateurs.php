<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();

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
    <div class="acteurs-realisateurs">
        <?php foreach ($liste_realisateurs as $realisateur) : ?>
            <div class="cat1">
                <?php if ($realisateur->nom_img != null) : ?>
                    <img src="../images/realisateurs/<?= $realisateur->nom_img ?>.jpg" alt="<?= $realisateur->nom_real ?>">
                <?php endif; ?>
                <span><?= $realisateur->nom_real ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>
