<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();
$film = new Films();
$value = '';

if (isset($_GET['titre'])) {
    $titre_film = $_GET['titre'];
    $value = $film->getTitreById($titre_film);
} elseif (isset($_GET['annee'])) {
    $annee = $_GET['annee'];
    $value = $film->getYearById($annee);
} elseif (isset($_GET['synopsis'])) {
    $synopsis = $_GET['synopsis'];
    $value = $film->getSynopsisById($synopsis);
} elseif (isset($_GET['tag'])){
    $tag =  $_GET['tag'];
    $liste = $film->getTagsById($tag);
    $value = htmlspecialchars(implode(" , ", $liste), ENT_QUOTES, 'UTF-8');
} elseif(isset($_GET['realName'])) {
    $num_real = $film->getNumRealById($_GET['realName']);
    $value = $film->getNomReal($num_real);
}
?>
<?php ob_start() ?>

<div class="container_acteur_form">
    <div class="sub-container">
        <div class="sub-container_2">
            <form id="acteur-form" method="POST" enctype="multipart/form-data" action=
                <?php if(isset($titre_film)): ?>
                    "modif_titre.php?titre=<?= $titre_film; ?>"
                    <?php $val = "Titre";?>
                <?php elseif (isset($annee)): ?>
                    "modif_annee.php?annee=<?= $annee; ?>"
                    <?php $val = "Annee";?>
                <?php elseif (isset($synopsis)): ?>
                    "modif_synopsis.php?synopsis=<?= htmlspecialchars($synopsis); ?>"
                    <?php $val = "Synopsis";?>
                <?php elseif (isset($tag)): ?>
                    "modif_tag.php?tag=<?= htmlspecialchars($tag); ?>"
                    <?php $val = "Tags";?>
                <?php elseif (isset($num_real)): ?>
                    "modif_real_name.php?num_real=<?= htmlspecialchars($num_real); ?>"
                    <?php $val = "Nom";?>
                <?php endif; ?>>
               
                <div class="mb-3">
                    <label for="modif" class="form-label neon"><?= $val;?></label>
                    <span id="name-error" class="error-message"></span>
                    <?php if($val != "Synopsis"):?>
                    <input type="text" class="form-control name-acteur" id="modif" name="modif" value="<?= $value ?>">
                    <?php else:?>
                        <textarea class="form-control name-acteur" id="modif" name="modif" rows="5"
                                ><?= $value ;?></textarea>
                    <?php endif;?>
                </div>
                <div class="sub-form-acteur">
                    <button type="submit" class="btn sub">Submit</button>
                    <button type="reset" class="btn sub res">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        let form = document.getElementById("acteur-form");
        let name = document.getElementById("modif");
        let nameError = document.getElementById("name-error");

        form.addEventListener('submit', function (ev) {
            let hasError = false;
            nameError.textContent = "";

            if (name.value.trim() === "") {
                ev.preventDefault();
                nameError.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg> &nbsp Veuillez saisir un nom.';
                hasError = true;
            }

            if (hasError) {
                ev.preventDefault();
            }
        });

        name.addEventListener('keydown', function () {
            nameError.textContent = "";
        });

        let resetButton = document.querySelector('.res');
        resetButton.addEventListener('click', function () {
            nameError.textContent = "";
        });
    });
</script>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>