<?php
use pdo_wrapper\PdoWrapper;

class Acteurs extends PdoWrapper
{
    public $actors = [];

    public function getAllactors()
    {
        return $this->exec("SELECT * FROM acteur", null, 'Acteur');
    }

    public function getNumAct($nom_act)
    {
        $req = "SELECT * FROM acteur WHERE nom_act=:nomA";
        $para = ["nomA" => $nom_act];
        $res = $this->exec($req, $para, "Acteur");
        return $res[0]->num_act;
    }

    public function add_actor_to_db($nomAct,$ImgAct) //plusieurs_films nous renseigne sur le fait que FilmJoue(contient les num_film) est un tableau ou pas
    {
                    //on va inserer le nom,le numero et le nom de l image dans le tableau acteur
                    $req="insert into acteur (nom_act,nom_img) values (:nom_act,:nom_img)";
                    $para=["nom_act" =>$nomAct ,"nom_img" =>$ImgAct];
                    $this->exec($req,$para);
                    //on va inserer le numero et les films joue par l acteur(on verifie si y en a plusieurs ou pas) dans la bde(c a d dans jouer)
                    
    }

    public function remove_actor_from_db($nom_act)
    {
        $num_act = $this->getNumAct($nom_act);
        $para = ["numA" => $num_act];
        $req = "DELETE FROM jouer WHERE num_act=:numA";
        $this->exec($req, $para);
        $req = "DELETE FROM acteur WHERE num_act=:numA";
        $this->exec($req, $para);
    }

    public function add_role($num_act, $num_film)
    {
        $req = "INSERT INTO jouer (num_act, num_film) VALUES(:num_act, :num_film)";
        $para = ["num_act" => $num_act, "num_film" => $num_film];
        $this->exec($req, $para);
    }

    public function remove_role($numAct, $numFilm)
    {
        $req = "DELETE FROM jouer WHERE num_act=:numA AND num_film=:numF";
        $para = ["numF" => $numFilm, "numA" => $numAct];
        $this->exec($req, $para);
    }
}