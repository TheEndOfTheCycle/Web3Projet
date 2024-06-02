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

    public function remove_film_from_db($nomFilm)
    {
        $film = $this->getFilm($nomFilm);
        if ($film) {
            $num_film = $film->num_film;
            $para = ["numF" => $num_film];
            // Supprimer les références du film des tables jouer et film_tag
            $req = "DELETE FROM jouer WHERE num_film=:numF";
            $this->exec($req, $para);
            $req = "DELETE FROM film_tag WHERE num_film=:numF";
            $this->exec($req, $para);
            // Supprimer le film de la table Films
            $para = ["nomF" => $nomFilm];
            $req = "DELETE FROM Films WHERE titre_film=:nomF";
            $this->exec($req, $para);
        } else {
            echo "Le film '$nomFilm' n'existe pas dans la base de données.";
        }
    }

    public function getMoviesByTagName($nomTag)
    {
        $Otags = new Tags();
        $NumTag = $Otags->getNumTag($nomTag);
        $req = "SELECT f.* 
                FROM Films f
                INNER JOIN film_tag ft ON f.num_film = ft.num_film
                INNER JOIN tags t ON ft.num_tag = t.num_tag
                WHERE t.num_tag = :numTag";
        $para = ["numTag" => $NumTag];
        $res = $this->exec($req, $para, "Film");

        foreach ($res as $film) {
            echo $film->getTitre() . "\n";
        }

        return $res;
    }

    public function getFilm($nomFilm)
    {
        $req = "SELECT * FROM Films WHERE titre_film=:nomfilm";
        $para = ["nomfilm" => $nomFilm];
        $res = $this->exec($req, $para, "Film");
        return $res ? $res[0] : null;
    }

    public function addTagToFilm($nomFilm, $nomTag)
    {
        $Otags = new Tags();
        $film = $this->getFilm($nomFilm);
        if ($film) {
            $numFilm = $film->num_film;
            $numTag = $Otags->getNumTag($nomTag);
            // Ajouter le tag au film dans la table film_tag
            $req = "INSERT INTO film_tag (num_film, num_tag) VALUES(:numFilm, :numTag)";
            $para = ["numFilm" => $numFilm, "numTag" => $numTag];
            $this->exec($req, $para);
        } else {
            echo "Le film '$nomFilm' n'existe pas dans la base de données.";
        }
    }

    public function removeTagFromFilm($nom_film, $nom_tag)
    {
        $Btags = new Tags();
        $num_tag = $Btags->getNumTag($nom_tag);
        $film = $this->getFilm($nom_film);
        if ($film) {
            $num_film = $film->num_film;
            // Supprimer le tag du film dans la table film_tag
            $req = "DELETE FROM film_tag WHERE num_film=:numF AND num_tag=:nomT";
            $para = ["numF" => $num_film, "nomT" => $num_tag];
            $this->exec($req, $para);
        } else {
            echo "Le film '$nom_film' n'existe pas dans la base de données.";
        }
    }

    public function add_film_to_db($titre, $annee, $genre, $num_realisateur, $nom_affiche, $description)
    {
        // Requête d'insertion pour la table "films"
        $req = "INSERT INTO Films (titre_film, anSortie_film, genre_film, num_real, nom_affiche, synopsis) 
                VALUES (:titre, :annee, :genre, :num_realisateur, :nom_affiche, :syno)";
        $para = [
            "titre" => $titre,
            "annee" => $annee,
            "genre" => $genre,
            "num_realisateur" => $num_realisateur,
            "nom_affiche" => $nom_affiche,
            "syno" => $description,
        ];
        $this->exec($req, $para);
    }
    

}