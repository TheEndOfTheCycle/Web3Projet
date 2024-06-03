<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

$acteurs = new Acteurs();
$num_film = isset($_GET['num_film']) ? $_GET['num_film'] : null; // Récupérer l'identifiant du film depuis l'URL

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
        <div class="container-add-acteur">
            <h1>Acteurs</h1>
            <?php if (isset($_SESSION['username'])): ?>
                <a href="acteur_form.php" title="ajouter un acteur">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <?php
        $current_letter = null;
        foreach ($liste_acteurs as $acteur):
            if (strtoupper(substr($acteur->nom_act, 0, 1)) != $current_letter):
                if ($current_letter !== null) {
                    echo '</div>';
                }
                $current_letter = strtoupper(substr($acteur->nom_act, 0, 1));
                echo '<h3>' . $current_letter . '</h3>';
                echo '<hr class="hr-acteurs">';
                echo '<div class="acteurs-realisateurs">';
            endif;
            ?>
            <div class="cat1">
                <?php if ($acteur->nom_img != null): ?>
                    <img src="../images/acteurs/<?= $acteur->nom_img ?>" alt="<?= $acteur->nom_act ?>">
                    <?php if (isset($_SESSION['username'])): ?>
                        <svg id="add-icon-<?= $acteur->num_act ?>" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            fill="currentColor" class="bi bi-plus-circle hidden c" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                    <?php endif; ?>
                <?php endif; ?>
                <span><?= $acteur->nom_act ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.c').forEach(icon => {
            icon.addEventListener('click', function () {
                let actorId = this.id.replace('add-icon-', '');
                addActor(actorId);
            });
        });
    });

    function addActor(actorId) {
        let filmId = <?= json_encode($num_film) ?>;
        fetch('add_acteur_film.php?id=' + actorId + '&num_film=' + filmId, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                console.error('Erreur lors de l\'ajout de l\'acteur');
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'ajout de l\'acteur :', error);
        });
    }
</script>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>
