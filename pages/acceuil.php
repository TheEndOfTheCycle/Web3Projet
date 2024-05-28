<?php
require_once __DIR__ . '/../autoloader.php';

ob_start();
?>

<div class="main-container">
    <div class="container">
        <div class="container-text">
            <p><span id="first-letter">C</span>ine<span id="first-letter">C</span>ollection</p>
            <h1> Créez et suivez votre liste personnelle, <br> <span> Partagez le plaisir du cinéma en famille !</span></h1>
        </div>
    </div>

    <div class="help">
        <div class="row">
            <div class="help-col-1">
                <img src="../images/stream.jpg" alt="Streaming">
            </div>
            <div class="help-col-2">
                <h1 class="sub-title">Regardez Netflix sur votre TV</h1>
                <p>
                    Regardez Netflix sur votre Smart TV, PlayStation, Xbox, Chromecast, Apple TV, lecteur Blu-ray et bien plus
                </p>
            </div>
        </div>
    </div>
    <hr class="custom-hr">
    <div class="help">
        <div class="row">
            <div class="help-col-2">
                <h1 class="sub-title">Regardez Netflix sur votre TV</h1>
                <p>
                    Regardez Netflix sur votre Smart TV, PlayStation, Xbox, Chromecast, Apple TV, lecteur Blu-ray et bien plus
                </p>
            </div>
            <div class="help-col-1">
                <img src="../images/stream.jpg" alt="Streaming">
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
Template::render($content);
?>