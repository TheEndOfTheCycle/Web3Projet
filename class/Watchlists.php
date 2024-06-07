<?php
use pdo_wrapper\PdoWrapper;

class Watchlists extends PdoWrapper
{

    public function getAllFilmsNums()
    {
        $req = "SELECT DISTINCT num_film FROM Watched_film";
        $results = $this->exec($req, null);

        // Extracting num_film values from the result set
        $nums = [];
        foreach ($results as $result) {
            $nums[] = $result->num_film;
        }

        return $nums;
    }

    public function filmExists($num_film)
    {
        $req = "SELECT COUNT(*) as count FROM Watched_film WHERE num_film = :num_film";
        $para = ["num_film" => $num_film];
        $res = $this->exec($req, $para);

        // On vérifie que $res est bien un tableau et qu'il contient des résultats
        if (is_array($res) && count($res) > 0) {
            return $res[0]->count > 0;//on verifie si le nb de films est sup a zero
        }

        // En cas de problème, on retourne false par défaut
        return false;
    }


    public function getFilm($num_film)
    {
        $req = "SELECT * FROM Films WHERE num_film = :num_film";
        $para = ["num_film" => $num_film];
        $res = $this->exec($req, $para, "Film");

        return $res ? $res[0] : null;
    }

    public function add_film_to_db($num_film, $etat)
    {
        $req = "Insert into Watched_film (num_film,est_regarde) values(:numF,:Etat)";
        $para = ["numF" => $num_film, "Etat" => $etat];
        return $this->exec($req, $para);
    }
    public function remove_film_from_db($num_film)
    {
        $req = "DELETE from Watched_film WHERE num_film=" . $num_film;
        $this->exec($req, null);
    }
    function updateEtat($num_film, $state)//modifie l etat est regarde par vrai ou faux
    {
        $req = "UPDATE Watched_film SET est_regarde=:Etat WHERE num_film=:numF";
        $para = ["Etat" => $state, "numF" => $num_film];
        $this->exec($req, $para);
    }
}



