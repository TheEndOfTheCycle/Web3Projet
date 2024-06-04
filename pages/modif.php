<?php
// Assurez-vous d'échapper les variables pour éviter les attaques XSS
$titre_film = htmlspecialchars($_GET['titre'], ENT_QUOTES, 'UTF-8');
$title = htmlspecialchars($_GET['title'], ENT_QUOTES, 'UTF-8');

$annee = htmlspecialchars($_GET['annee'], ENT_QUOTES, 'UTF-8');
?>

<div class="container_acteur_form">
    <div class="sub-container">
        <div class="sub-container_2">
            <?php if (!empty($title)) { ?>
                <form id="acteur-form" method="POST" enctype="multipart/form-data"
                    action="modif_donnees.php?titre=<?php echo $titre_film; ?>&title=<?= urlencode($title) ?>">
                    <legend class="title-form-acteur">Modification</legend>
                    <div class="mb-3 ">

                        <label for="modif" class="form-label neon">titre</label>
                        <label for="modif" class="form-label neon">titre</label>
                        <span id="name-error" class="error-message"></span>
                        <input type="text" class="form-control name-acteur" id="modif" name="modif" aria-describedby="name"
                            value="<?= $title ?>">


                    </div>
                <?php }
            ?>
                <?php if (!empty($annee)) { ?>
                    <form id="acteur-form" method="POST" enctype="multipart/form-data"
                        action="modif_donnees.php?titre=<?php echo $titre_film; ?>&annee=<?= urlencode($annee) ?>">
                        <legend class="title-form-acteur">Modification</legend>
                        <div class="mb-3 ">

                            <?php if (isset($annee)) { ?>
                                <label for="modif" class="form-label neon">annee</label>
                                <label for="modif" class="form-label neon">annee</label>
                                <span id="name-error" class="error-message"></span>
                                <input type="text" class="form-control name-acteur" id="modif" name="modif"
                                    aria-describedby="name" value="<?= $annee ?>">
                            <?php }
                            ?>



                        </div>
                    <?php }
                ?>
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