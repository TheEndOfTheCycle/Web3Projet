<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

$realisateurs = new Realisateurs();

// Récupération de tous les réalisateurs depuis la base de données
$liste_realisateurs = $realisateurs->getAllreal();

// Transformation de la première lettre de chaque mot en majuscule pour chaque réalisateur
foreach ($liste_realisateurs as $realisateur) {
    $realisateur->nom_real = ucwords(strtolower($realisateur->nom_real));
}

// Tri de la liste des réalisateurs par ordre alphabétique
usort($liste_realisateurs, function ($a, $b) {
    return strcmp($a->nom_real, $b->nom_real);
});

ob_start();
?>

<div class="main-container">
    <div class="container-names">
        
        <div class="container-add-acteur">
        <h1>Réalisateurs</h1>
            <?php if (isset($_SESSION['username'])): ?>
                <a href="realisateur_form.php" title="ajouter un realisateur">
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
        $current_letter = null; // Variable pour suivre la lettre actuelle
        foreach ($liste_realisateurs as $realisateur):
            // Vérifie s'il y a un changement de première lettre pour afficher un titre correspondant
            if (strtoupper(substr($realisateur->nom_real, 0, 1)) != $current_letter):
                if ($current_letter !== null) {
                    // Fermer la ligne précédente
                    echo '</div>';
                }
                // Mettre à jour la lettre actuelle
                $current_letter = strtoupper(substr($realisateur->nom_real, 0, 1));
                // Afficher la lettre actuelle
                echo '<h3>' . $current_letter . '</h3>';
                echo '<hr class="hr-acteurs">';
                // Ouvrir une nouvelle ligne pour les réalisateurs de cette lettre
                echo '<div class="acteurs-realisateurs">';
            endif;
            ?>
            <div class="cat1">
                <?php if ($realisateur->nom_img != null): ?>
                    <a href="realisateur.php?nom_real=<?= urlencode($realisateur->nom_real) ?>">
                        <img src="../images/realisateurs/<?= $realisateur->nom_img ?>" alt="<?= $realisateur->nom_real ?>">
                        <span><?= $realisateur->nom_real ?></span>

                    </a>
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Ajoutez un identifiant unique à chaque icône de corbeille, par exemple, "delete-icon-ID" -->
                        <svg id="delete-icon-<?= $realisateur->nom_real ?>" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            fill="currentColor" class="bi bi-trash3 hidden c" viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                        </svg>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sélectionnez toutes les icônes de corbeille avec la classe "c" et ajoutez un gestionnaire d'événements à chacune
        document.querySelectorAll('.c').forEach(icon => {
            icon.addEventListener('click', function () {
                // Obtenez l'identifiant unique de l'icône de corbeille
                let id = this.id.replace('delete-icon-', '');
                // Appelez une fonction pour supprimer l'acteur avec cet identifiant
                deleteActor(id);
            });
        });
    });

    function deleteActor(actorId) {
        // Envoyez une requête AJAX pour supprimer l'acteur correspondant
        fetch('supprimer_realisateur.php?id=' + actorId, {
            method: 'GET'
        })
            .then(response => {
                if (response.ok) {
                    // La suppression s'est bien passée, rafraîchir la page ou mettre à jour la liste des réalisateurs
                    window.location.reload(); // Rafraîchir la page
                } else {
                    // Gérer les erreurs de suppression
                    console.error('Erreur lors de la suppression de l\'acteur');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la suppression de l\'acteur :', error);
            });
    }
</script>



<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>