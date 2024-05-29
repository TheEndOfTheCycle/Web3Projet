<?php
require_once "../config.php";

require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();


?>

<!-- Démarre le buffering -->
<?php ob_start() ?>

<div class="main-container">
        <div class="container-names">
            <h1>Acteurs</h1>
            <h3>A</h3>
            <div class="acteurs-realisateurs">
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>

                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
            </div>

            <h3>B</h3>
            <hr class="hr-acteurs">
            <div class="acteurs-realisateurs">
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
                <div class="cat1">
                    <img src="../images/cillian.jpg" alt="Cillian">
                    <span>Cillian Murphy</span>
                </div>
            </div>
        </div>
    </div>


<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>