<?php
require_once "../config.php";

require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();


?>

<!-- Démarre le buffering -->
<?php ob_start() ?>

<div class="main-container">
    <div class="container">
        <div class="container-text">
            <p><span id="first-letter">C</span>ine<span id="first-letter">C</span>ollection</p>
            <h1> Créez et suivez votre liste personnelle, <br> <span> Partagez le plaisir du cinéma en famille !
                </span>
            </h1>
        </div>
    </div>

    <div class="help">
        <div class="row">
            <div class="help-col-1">
                <img src="../images/stream.jpg">
            </div>
            <div class="help-col-2">
                <h1 class="sub-title">Regardez Netflix sur votre TV </h1>
                <p>
                    Regardez Netflix sur votre Smart TV, PlayStation, Xbox, Chromecast, Apple TV, lecteur Blu-ray et
                    bien plus
                </p>
            </div>

        </div>
    </div>
    <hr class="custom-hr">

    <div class="help">
        <div class="row">
            <div class="help-col-2">
                <h1 class="sub-title">Regardez Netflix sur votre TV </h1>
                <p>
                    Regardez Netflix sur votre Smart TV, PlayStation, Xbox, Chromecast, Apple TV, lecteur Blu-ray et
                    bien plus
                </p>
            </div>
            <div class="help-col-1">
                <img src="../images/stream.jpg">
            </div>
        </div>

    </div>
</div>


<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>