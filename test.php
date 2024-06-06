<?php 
require_once "class/Autoloader.php";
Autoloader::register();
$films = new Films();
foreach($films->getAllFilms()[12]->getTags() as $f)
{
    echo $f->nom_tag;
}
?>