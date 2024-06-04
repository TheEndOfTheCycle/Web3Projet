<?php 
require_once "../config.php";

use pdo_wrapper\PdoWrapper;
 

class Acteur extends PdoWrapper{    
    public $nom_act;
    public $num_act;
    public $nom_img;
    public function getMovies()
    {
        $tabFilms =[];
        $i=0;
        $req ="select nom_act,titre_film from (acteur  inner join jouer on jouer.num_act=acteur.num_act) inner join Films where Films.num_film=jouer.num_film and acteur.num_act=".$this->num_act;
       $results= $this->exec(
           $req,
            null,
            null) ;
        foreach($results as $res)
        {
            $tabFilms[$i]=$res;
            $i++;
        }
        return $tabFilms; 
    }
    public function getMovieNames() //ce tableau est de taille sizeof(Mnames)
    {
        $Tnoms= [];
        $i=0;
        foreach($this->getMovies() as $mov)
        {
            $Tnoms[$i]=$mov->titre_film;
            $i++;
        }
        return $Tnoms;
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