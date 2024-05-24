<?php
require_once "../config.php" ;
require_once $GLOBALS['TEMPLATE_DIR'] . "Template.css";
use Template ;
?>

<?php ob_start() ?>


<div class="title">WELCOME TO THE MAGIC STORE</div>


<?php $code = ob_get_clean() ?>
<?php Template::render($code);?>
