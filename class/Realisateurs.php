<?php 

require_once "../config.php";

use pdo_wrapper\PdoWrapper;

class Realisateurs extends PdoWrapper
{
    public function getAllreal(){
        return( $this->exec(
            "SELECT * FROM realisateur ",
            null,
            'Realisateur') );
    }
    public function add_real_to_db($nom_real,$nom_img)
    {
        //on va inserer le numero le nom du real et de l image dans le tableau realisateur
        $req="Insert into realisateur (nom_real,nom_img) values(:nom_real,:nom_img)";
        $para =[ "nom_real" => $nom_real , "nom_img" => $nom_img];
        $this->exec($req,$para);
       
    }
    
    public function remove_real_from_db($nom_real)//cette fonction retire le realisateur de la bde
    {
        //il faut d abord effacer le film de la bde
        $Tfilms = new Films();
        $Tfilms->remove_film_from_db($this->getFilmReal($nom_real));
        //on efface le realisateur du tableau
        $req="delete from realisateur where num_real=:numR";
        $para =["numR" =>$this->getNumReal($nom_real)];
        $this->exec($req,$para);
    }
    public function getNumReal($nom_real)
    {
        $req="select * from realisateur where nom_real=:nomR";
        $para = ["nomR" =>$nom_real];
        $res=$this->exec($req,$para,"Realisateur");
        return($res[0]->num_real);
    }
  
    public function getFilmReal($nom_real)//retourne le film realise par un realisateur
    {
        $req="select * from realisateur inner join Films where Films.num_real=" .$this->getNumReal($nom_real);
        return $this->exec($req,null,"Film");
    }
}


?>