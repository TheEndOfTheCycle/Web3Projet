<?php
require_once __DIR__ . "/../autoloader.php" ;//
?>

<?php ob_start() ?>


<div class="title">acteurs</div>


<?php $code = ob_get_clean() ?>
<?php Template::render($code);?>
