<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();

$acteurs = new Acteurs();

// Récupération de tous les acteurs depuis la base de données
$liste_acteurs = $acteurs->getAllactors();

// Tri de la liste des acteurs par ordre alphabétique
usort($liste_acteurs, function($a, $b) {
    return strcmp($a->nom_act, $b->nom_act);
});

ob_start();
?>

<div class="main-container">

<div class="container-names">
    <h1>Acteurs</h1>
    <div class="acteurs-realisateurs">
        <?php foreach ($liste_acteurs as $acteur) : ?>
            <div class="cat1">
                <?php if ($acteur->nom_img != null) : ?>
                    <img src="../images/acteurs/<?= $acteur->nom_img ?>.jpg" alt="<?= $acteur->nom_act ?>">
                <?php endif; ?>
                <span><?= $acteur->nom_act ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>
