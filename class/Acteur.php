<?php 
require_once "../config.php";

use pdo_wrapper\PdoWrapper;
 

class Acteur extends PdoWrapper{    
    public $nom_act;
    public $num_act;
    public $nom_img;
   

    public function getMovies($num)
    {
        $tabFilms = [];
        $req = "
            SELECT *
            FROM acteur
            INNER JOIN jouer ON jouer.num_act = acteur.num_act
            INNER JOIN Films ON Films.num_film = jouer.num_film
            WHERE acteur.num_act = :num_act
        ";
    
        $params = ['num_act' => $num];
        $results = $this->exec($req, $params, null);
    
        foreach ($results as $res) {
            $tabFilms[] = $res;
        }
    
        return $tabFilms;
    }

   
    public function getHTML(){ 
        ?>
        <div class="actor">
        <h1><?= $this->nom_act ?></h1>
        <?php if($this->nom_img != null) : ?>
        <img   src="<?= "../images/acteurs/" .$this->nom_img .".jpg" ?>">
       
        <?php endif; ?>
        </div>


        <?php
    }
    
}





?>