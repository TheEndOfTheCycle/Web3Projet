<?php
require_once __DIR__ . "/../autoloader.php" ;//
use Template ;
?>

<?php ob_start() ?>


<div class="title">WELCOME TO THE MAGIC STORE</div>


<?php $code = ob_get_clean() ?>
<?php Template::render($code);?>
