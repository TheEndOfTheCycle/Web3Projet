<?php 
require_once "../config.php";

use pdo_wrapper\PdoWrapper;

class Films extends PdoWrapper
{
    public function getAllFilms()
    {
        return $this->exec(
            "SELECT * FROM Films ",
            null,
            'Film'
        );
    }

    public function add_film_to_db($titre_film, $anSortie_film, $nom_real, $nom_affiche, $synopsis)
    {
        $Breals = new Realisateurs();
        $num_real = $Breals->getNumReal($nom_real);
        //on va saisir les infos du film dans la table films
        $req = "insert into Films(titre_film, anSortie_film, num_real, nom_affiche, synopsis) values(:titre_film, :anSortie_film, :num_real, :nom_affiche, :synopsis)";
        $para = ["titre_film" => $titre_film, "anSortie_film" => $anSortie_film, "num_real" => $num_real, "nom_affiche" => $nom_affiche, "synopsis" => $synopsis];
        $this->exec($req, $para);
    }

    public function remove_film_from_db($nomFilm)
    {
        $num_film = $this->getNumFilm($nomFilm);
        $para = ["numF" => $num_film];
        // il faut d abord enlever les references de ce films(les cles etrangeres) des tables concernes c a d jouer et film_tag
        // on efface num_film de jouer
        $req = "delete from jouer where num_film=:numF";
        $this->exec($req, $para);
        // on efface num_film de film_tag
        $req = "delete from film_tag where num_film=:numF";
        $this->exec($req, $para);
        // finalement on efface le film de films
        $para = ["nomF" => $nomFilm];
        $req = "delete from Films where titre_film=:nomF";
        $this->exec($req, $para);
    }

    public function getMoviesByTagName($nomTag)
    {
        $Otags = new Tags();
        $NumTag = $Otags->getNumTag($nomTag);
        $req = "select * from Films inner join film_tag on Films.num_film=film_tag.num_film inner join tags on tags.num_tag=film_tag.num_tag where tags.num_tag=" . $NumTag;
        $res = $this->exec($req, null, "Film");
        
        foreach ($res as $film) {
            echo $film->getTitre() . "\n";
        }
        
        return $res;
    }

    public function getNumFilm($nomFilm)
    {
        $req = "select * from Films where titre_film=:nomfilm";
        $para = ["nomfilm" => $nomFilm];
        $res = $this->exec($req, $para, "Film");
        return $res[0]->num_film;
    }

    public function addTagToFilm($nomFilm, $nomTag)
    {
        $Otags = new Tags();
        $numFilm = $this->getNumFilm($nomFilm);
        $numTag = $Otags->getNumTag($nomTag);
        // on va rajouter au tableau film_tag 
        $req = "insert into film_tag (num_film, num_tag) values(:numFilm, :numTag)";
        $para = ["numFilm" => $numFilm, "numTag" => $numTag];
        $this->exec($req, $para);
    }

    public function getFilm($nom_film)
    {
        $num_film = $this->getNumFilm($nom_film);
        $req = "select * from Films where num_film=:numF";
        $para = ["numF" => $num_film];
        $res = $this->exec($req, $para, "Film");
        return $res[0];
    }

    public function removeTagFromFilm($nom_film, $nom_tag)
    {
        $Btags = new Tags();
        $num_tag = $Btags->getNumTag($nom_tag);
        $num_film = $this->getNumFilm($nom_film);
        // il suffit d effacer le film de la table film_tag
        $req = "delete from film_tag where num_film=:numF and num_tag=:nomT";
        $para = ["numF" => $num_film, "nomT" => $num_tag];
        $this->exec($req, $para);
    }
}