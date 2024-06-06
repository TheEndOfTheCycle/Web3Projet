<?php

use pdo_wrapper\PdoWrapper;

//cette classe contient toutes les méthodes de tries a applique a la barre de recherche
class Trie extends PdoWrapper
{
    public function getMoviesByTagName($nomTag)
    {
        $req = "SELECT Films.titre_film, Films.anSortie_film, Films.genre_film, Films.nom_affiche 
            FROM Films 
            INNER JOIN film_tag ON Films.num_film = film_tag.num_film 
            INNER JOIN tags ON tags.num_tag = film_tag.num_tag 
            WHERE tags.nom_tag LIKE :nomTag";
        $params = array(':nomTag' => '%' . $nomTag . '%');
        $res = $this->exec($req, $params, "Film");
        return $res;
    }


    public function getMoviesByActorName($nomAct)
    {
        $req = "SELECT acteur.nom_act, Films.titre_film, Films.anSortie_film, Films.genre_film, Films.nom_affiche 
            FROM acteur  
            INNER JOIN jouer ON jouer.num_act = acteur.num_act 
            INNER JOIN Films ON Films.num_film = jouer.num_film 
            WHERE acteur.nom_act LIKE :nomAct";
        $params = array(':nomAct' => '%' . $nomAct . '%');
        $res = $this->exec($req, $params, "Film");
        return $res;
    }



    public function getMoviesByTitle($title)
    {
        $query = "SELECT Films.titre_film, Films.anSortie_film, Films.genre_film, Films.nom_affiche 
                  FROM Films 
                  WHERE titre_film LIKE :title";
        $params = array(':title' => '%' . $title . '%');
        $result = $this->exec($query, $params, "Film");
        return $result;
    }

    public function getMoviesByReal($nomReal)
    {
        $req = "SELECT Films.titre_film, realisateur.nom_real, Films.anSortie_film, Films.genre_film, Films.nom_affiche 
            FROM Films 
            INNER JOIN realisateur ON realisateur.num_real = Films.num_real 
            WHERE realisateur.nom_real LIKE :nomReal";
        $params = array(':nomReal' => '%' . $nomReal . '%');
        return $this->exec($req, $params, "Film");
    }


    public function searchMovies($searchTerm)
    {
        $Otags = new Tags();
        $Bacteurs = new Acteurs();
        $Breals = new Realisateurs();
        //on utilise des left joins pour avoir des films meme si il y a une erreur ...
        $query = "SELECT DISTINCT * FROM Films
              Left JOIN film_tag ON Films.num_film = film_tag.num_film 
              left JOIN tags ON tags.num_tag = film_tag.num_tag
              left JOIN jouer ON jouer.num_film = Films.num_film
              left JOIN acteur ON acteur.num_act = jouer.num_act
              left JOIN realisateur ON realisateur.num_real = Films.num_real
              WHERE Films.titre_film LIKE :searchTerm
                 OR tags.nom_tag LIKE :searchTerm
                 OR acteur.nom_act LIKE :searchTerm
                 OR realisateur.nom_real LIKE :searchTerm
                 GROUP BY Films.num_film, Films.titre_film";
                 

        $params = array(':searchTerm' => '%' . $searchTerm . '%');

        return $this->exec($query, $params, "Film");
    }
    public function searchActor($searchName)
    {
        $req="SELECT * FROM acteur where nom_act LIKE :nomA";
        $para= ["nomA" =>'%' . $searchName . '%'];
        return $this->exec($req,$para,"Acteur");
    }
    public function searchReal($searchName)
    {
        $req= "SELECT * from realisateur where nom_real LIKE :nomR";
        $para =["nomR" =>'%' . $searchName . '%'];
       return $this->exec($req,$para,"Realisateur");
    }
    public function getMoviesByYearAndGenre($year, $genre)
{
    $query = "SELECT Films.titre_film, Films.anSortie_film, Films.genre_film, Films.nom_affiche
              FROM Films
              WHERE 1=1"; // Condition toujours vraie pour pouvoir ajouter des clauses WHERE supplémentaires

    $params = array();

    if (!is_null($year)) {
        $query .= " AND Films.anSortie_film = :year";
        $params[':year'] = $year;
    }

    if (!is_null($genre)) {
        $query .= " AND Films.genre_film LIKE :genre";
        $params[':genre'] = '%' . $genre . '%';
    }

    return $this->exec($query, $params, "Film");
}

public function getMoviesByYear($year)
{
    $query = "SELECT Films.titre_film, Films.anSortie_film, Films.genre_film, Films.nom_affiche
              FROM Films
              WHERE Films.anSortie_film = :year";

    $params = array(':year' => $year);

    return $this->exec($query, $params, "Film");
}

public function getMoviesByGenre($genre)
{
    $query = "SELECT Films.titre_film, Films.anSortie_film, Films.genre_film, Films.nom_affiche
              FROM Films
              WHERE Films.genre_film LIKE :genre";

    $params = array(':genre' => '%' . $genre . '%');

    return $this->exec($query, $params, "Film");
}


    public function getMoviesByTagsNames($Tnametags)//cette fonction retourne les Films qui ont les tags contenu dans Ttags
    {
        $tempo = [];
        $Otags = new Tags();
        $nomTag = $Otags->getNumTag($Tnametags[0]);
        $req = "select * from Films inner join film_tag on Films.num_film=film_tag.num_film inner join tags on tags.num_tag=film_tag.num_tag where tags.num_tag=:" . $nomTag;
        $para = [0 => strval($nomTag)];
        for ($i = 1; $i < sizeof($Tnametags); $i++) {
            $nomTag = $Otags->getNumTag($Tnametags[$i]);
            $req = $req . " and where tags.num_tag=:" . $nomTag;
            $para[$i] = strval($nomTag);
        }
        echo $req;
        var_dump($para);
        $res = $this->exec($req, $para);
        var_dump($res);

    }
    public function getMoviesByTagNameAndActName($nom_act, $nom_tag)//cette fonction retourne la liste des Films ou l acteur figure et le film a le tag correspondant
    {
        $Btags = new Tags();
        $Bacts = new Acteurs();
        $num_tag = $Btags->getNumTag($nom_tag);
        $num_act = $Bacts->getNumAct($nom_act);
        $req = "select * from Films inner join film_tag on Films.num_film=film_tag.num_film inner join tags on tags.num_tag=film_tag.num_tag inner join jouer on Films.num_film=jouer.num_film inner join acteur on acteur.num_act=jouer.num_act where tags.num_tag=:numT and acteur.num_act=:numA";
        $para = ["numA" => $num_act, "numT" => $num_tag];
        return $this->exec($req, $para, "Film");
    }
    public function getMoviesByTagNameAndRealName($nom_real, $nom_tag)
    {
        $Btags = new Tags();
        $Breals = new Realisateurs();
        $num_tag = $Btags->getNumTag($nom_tag);
        $num_real = $Breals->getNumReal($nom_real);
        $req = "select * from Films inner join realisateur on realisateur.num_real=Films.num_real inner join film_tag on film_tag.num_film=Films.num_film inner join tags on tags.num_tag=film_tag.num_tag where tags.num_tag=:numT and realisateur.num_real=:numR";
        $para = ["numR" => $num_real, "numT" => $num_tag];
        return $this->exec($req, $para);
    }


    public function getMoviesByDirectorIdGenreYear($directorIds, $genres, $year, $seen, $actorIds)
    {
        $query = "SELECT DISTINCT Films.titre_film, Films.anSortie_film, Films.genre_film, Films.nom_affiche, realisateur.num_real
            FROM Films
            INNER JOIN realisateur ON realisateur.num_real = Films.num_real
            INNER JOIN film_tag ON Films.num_film = film_tag.num_film
            INNER JOIN tags ON tags.num_tag = film_tag.num_tag
            WHERE 1=1";
    
        $params = [];
    
        if (!empty($directorIds)) {
            $placeholders = implode(',', array_fill(0, count($directorIds), '?'));//permet de passer les parametres dans la requete c a d bindvalue des num reals dans la requete,on attache l id des reals aux ?
            $query .= " AND Films.num_real IN ($placeholders)";//on aura donc 'IN ?,?,?' pour sizeof(directorids)=3
            $params = array_merge($params, $directorIds);//on combine les parametres dans le tableau,mettre le tab directorIds dans params
        }
    
        if (!empty($year)) {
            $query .= " AND Films.anSortie_film = ?";//on concatene avec la requete
            $params[] = $year;
        }
    
        if (!empty($genres)) {
            if (is_string($genres)) {
                $genres = explode(',', $genres);//transforme la chaine contenant les genres separes par des vergules en un tableau 
                $genres = array_map('trim', $genres); // Supprimer les espaces inutiles
            }
    
            $genreConditions = [];
            foreach ($genres as  $genre) {
                $genreConditions[] = "Films.genre_film LIKE ?";

                $params[] = '%' . $genre . '%';
            }
            $query .= " AND (" . implode(' AND ', $genreConditions) . ")";
        }
    
        if ($seen !== '') {//seen n est pas vide et est une chaine
            $query .= " AND Films.est_regarde = ?";
            $params[] = $seen ? 1 : 0;
        }
    
        if (!empty($actorIds)) {
            $actorConditions = [];
            foreach ($actorIds as $actorId) {
                $actorConditions[] = "EXISTS (SELECT 1 FROM jouer WHERE jouer.num_film = Films.num_film AND jouer.num_act = ?)";//on selectionne l acteur qui a bien joue dans le film
                $params[] = $actorId;
            }
            $query .= " AND (" . implode(' AND ', $actorConditions) . ")";//on concatene les conditions d acteurs ayant joue dans le film avec la requete
        }
    
        return $this->exec($query, $params, "Film");
    }
    


}