<?php 

use pdo_wrapper\PdoWrapper;


class Films extends PdoWrapper
{
    public  $films=[];
    public function getAllFilms()
    {
        return( $this->exec(
            "SELECT * FROM Films ",
            null,
            'Film'));
    }
    public function add_film_to_db($num_film,$titre_film,$anSortie_film,$num_real,$nom_affiche,$synopsis,$tags_num,$Plusieurs_tags)//plusieurs_tags nous permet de determiner si tags est un tableau ou pas,de plus tags doit etre une instance de classe tag
    {
        //on va saisir les infos du film dans la table films
        $req="insert into films(num_film,titre_film,anSortie_film,num_real,nom_affiche,synopsis) values(:num_film,:titre_film,:anSortie_film,:num_real,:nom_affiche,:synopsis)";
        $para = ["num_film" => $num_film, "titre_film" =>$titre_film, "anSortie_film" =>$anSortie_film , "num_real" =>$num_real , "nom_affiche" =>$nom_affiche, "synopsis" =>$synopsis];
        $this->exec($req,$para);
        //on va saisir les tags du film dans film_tag
        $req="insert into film_tag (num_tag,num_film) values(:num_tag,:num_film)";
        if($Plusieurs_tags==false)//le film n a qu un seul tag
        {
            $para = ["num_film" => $num_film, "num_tag" =>$tags_num];
            $this->exec($req,$para);
        }
        else
        {
            foreach($tags_num as $tag_num)
            {
                $para = ["num_film" => $num_film, "num_tag" =>$tag_num];
                $this->exec($req,$para);
            }
        }
    }
    public function remove_film()//cette fonction retire un film de la de la table film;
    {

    }
}





?>