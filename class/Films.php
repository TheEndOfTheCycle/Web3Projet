<?php

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

    public function getAllGenres()
    {
        return $this->exec(
            "SELECT genre_film FROM Films",
            null,
            'genre_film'
        );
    }

    public function getFilmByNum($numFilm)
    {
        $req = "SELECT * FROM Films WHERE num_film=:numFilm";
        $para = ["numFilm" => $numFilm];
        $res = $this->exec($req, $para, "Film");

        return $res ? $res[0] : null;
    }

    public function filmExists($titre_film)
    {
        $req = "SELECT COUNT(*) as count FROM Films WHERE titre_film=:titre_film";
        $para = ["titre_film" => $titre_film];
        $res = $this->exec($req, $para);

        // On vérifie que $res est bien un tableau et qu'il contient des résultats
        if (is_array($res) && count($res) > 0) {
            return $res[0]->count > 0;
        }

        // En cas de problème, on retourne false par défaut
        return false;
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
            $req = "DELETE FROM Watched_film WHERE num_film=:numF";
            $this->exec($req, $para);
            // Supprimer le film de la table Films
            $para = ["nomF" => $nomFilm];
            $req = "DELETE FROM Films WHERE titre_film=:nomF";
            $this->exec($req, $para);
        } else {
            echo "Le film '$nomFilm' n'existe pas dans la base de données.";
        }
    }

    public function updateEtat($numFilm, $nouvelEtat)
    {
        $req = "UPDATE Films SET est_regarde = :etat WHERE num_film = :numFilm";
        $params = ["etat" => $nouvelEtat, "numFilm" => $numFilm];
        return $this->exec($req, $params);
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

    public function getFilmIdByTitle($titre_film)
    {
        $req = "SELECT num_film FROM Films WHERE titre_film = :titre_film";
        $para = ["titre_film" => $titre_film];
        $res = $this->exec($req, $para);

        return $res ? $res[0]->num_film : null;
    }


    public function getFilmIdByYear($anSortie_film)
    {
        $req = "SELECT num_film FROM Films WHERE anSortie_film = :anSortie_film";
        $para = ["anSortie_film" => $anSortie_film];
        $res = $this->exec($req, $para);

        return $res ? $res[0]->num_film : null;
    }

    public function getFilmIdBySynopsis($synopsis)
    {
        $req = "SELECT num_film FROM Films WHERE synopsis = :synopsis";
        $params = ["synopsis" => $synopsis];
        $res = $this->exec($req, $params);

        // Vérifier si des résultats ont été retournés
        if ($res && count($res) > 0) {
            return $res[0]->num_film;
        } else {
            return null;
        }
    }
    public function getSynopsisById($numFilm)
    {
        $req = "SELECT synopsis FROM Films WHERE num_film = :numFilm";
        $params = ["numFilm" => $numFilm];
        $res = $this->exec($req, $params);

        return $res ? $res[0]->synopsis : null;
    }


    public function getTitreById($numFilm)
    {
        $req = "SELECT titre_film FROM Films WHERE num_film = :numFilm";
        $params = ["numFilm" => $numFilm];
        $res = $this->exec($req, $params);

        return $res ? $res[0]->titre_film : null;
    }

    public function getYearById($numFilm)
    {
        $req = "SELECT anSortie_film FROM Films WHERE num_film = :numFilm";
        $params = ["numFilm" => $numFilm];
        $res = $this->exec($req, $params);

        return $res ? $res[0]->anSortie_film : null;
    }

    public function getTagsById($numFilm)
    {
        $req = "SELECT t.nom_tag 
            FROM tags t
            INNER JOIN film_tag ft ON t.num_tag = ft.num_tag
            INNER JOIN Films f ON ft.num_film = f.num_film
            WHERE f.num_film = :numFilm";
        $params = ["numFilm" => $numFilm];
        $res = $this->exec($req, $params);

        return $res ? array_map(function ($row) {
            return $row->nom_tag;
        }, $res) : [];
    }

    public function updateFilmTag($numFilm, $tagsArray)
    {
        $Otags = new Tags();

        // Supprimer tous les tags associés au film
        $req = "DELETE FROM film_tag WHERE num_film = :numFilm";
        $params = ["numFilm" => $numFilm];
        $this->exec($req, $params);

        // Ajouter les nouveaux tags
        foreach ($tagsArray as $tag) {
            $tag = trim($tag); // Supprimer les espaces autour du tag

            // Vérifiez si le tag existe, sinon, ajoutez-le
            if (!$Otags->tagExists($tag)) {
                $Otags->add_tag_to_db($tag);
            }

            // Récupérez le numéro du tag
            $numTag = $Otags->getNumTag($tag);

            // Ajouter le tag au film dans la table film_tag
            $req = "INSERT INTO film_tag (num_film, num_tag) VALUES(:numFilm, :numTag)";
            $para = ["numFilm" => $numFilm, "numTag" => $numTag];
            $this->exec($req, $para);
        }
    }
    public function getFilmTitleByNumReal($numRealisateur)
    {
        // Requête SQL pour récupérer le titre d'un film associé à un numéro de réalisateur
        $req = "SELECT titre_film FROM Films WHERE num_real = :numReal LIMIT 1";
        $params = ["numReal" => $numRealisateur];
        $res = $this->exec($req, $params);


        return $res[0]->titre_film;
    }
    public function getNumRealById($numFilm)
    {
        $req = "SELECT num_real FROM Films WHERE num_film = :numFilm";
        $params = ["numFilm" => $numFilm];
        $res = $this->exec($req, $params);

        return $res ? $res[0]->num_real : null;
    }
    public function getNomAfficheByFilmId($numFilm)
    {
        // Requête SQL pour récupérer le nom de l'image d'un film à partir de son ID
        $req = "SELECT nom_affiche FROM Films WHERE num_film = :numFilm LIMIT 1";
        $params = ["numFilm" => $numFilm];
        $res = $this->exec($req, $params);

        return $res[0]->nom_affiche;
    }
    public function updateImageByNumFilm($numFilm, $newImageName)
    {
        // Requête SQL pour mettre à jour le nom de l'image d'un film à partir de son ID
        $req = "UPDATE Films SET nom_affiche = :newImageName WHERE num_film = :numFilm";
        $params = ["newImageName" => $newImageName, "numFilm" => $numFilm];
        $this->exec($req, $params);
    }
    public function getNomReal($num_real)
    {
        $req = "SELECT nom_real FROM realisateur WHERE num_real = :num_real";
        $params = ["num_real" => $num_real];
        $res = $this->exec($req, $params);

        return $res ? $res[0]->nom_real : null;
    }

    public function getNomAfficheByNumReal($numReal)
    {
        $req = "SELECT nom_affiche FROM Films WHERE num_real = :numReal LIMIT 1";
        $params = ["numReal" => $numReal];
        $res = $this->exec($req, $params);

        return $res ? $res[0]->nom_affiche : null;
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

    public function updateFilmTitle($numFilm, $newTitle)
    {
        $req = "UPDATE Films SET titre_film = :newTitle WHERE num_film = :numFilm";
        $params = ["newTitle" => $newTitle, "numFilm" => $numFilm];
        $this->exec($req, $params);
    }

    public function updateFilmYear($numFilm, $newYear)
    {
        $req = "UPDATE Films SET anSortie_film = :newYear WHERE num_film = :numFilm";
        $params = ["newYear" => $newYear, "numFilm" => $numFilm];
        $this->exec($req, $params);
    }


    public function updateFilmSynopsis($numFilm, $newSynopsis)
    {
        $req = "UPDATE Films SET synopsis = :newSynopsis WHERE num_film = :numFilm";
        $params = ["newSynopsis" => $newSynopsis, "numFilm" => $numFilm];
        $this->exec($req, $params);
    }



    public function add_film_to_db($titre_film, $anSortie_film, $genre, $nom_real, $nom_affiche, $synopsis)//plusieurs_tags nous permet de determiner si tags est un tableau ou pas,de plus tags doit etre une instance de classe tag
    {
        $Breals = new Realisateurs();
        $num_real = $Breals->getNumReal($nom_real);
        if ($num_real === null) {

            $Breals->add_real_to_db($nom_real, null);
        }
        $num_real = $Breals->getNumReal($nom_real);

        //on va saisir les infos du film dans la table films
        $req = "insert into Films(titre_film,anSortie_film,genre_film,num_real,nom_affiche,synopsis,est_regarde) values(:titre_film,:anSortie_film,:genre_film,:num_real,:nom_affiche,:synopsis,:est_regarde)";
        $para = ["titre_film" => $titre_film, "anSortie_film" => $anSortie_film, "genre_film" => $genre, "num_real" => $num_real, "nom_affiche" => $nom_affiche, "synopsis" => $synopsis, "est_regarde" => 0];
        $this->exec($req, $para);


    }


}