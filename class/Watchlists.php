<?php 
use pdo_wrapper\PdoWrapper;
    class Watchlists extends PdoWrapper
    {

        public function getAllFilmTitles()
        {
            $req = "SELECT titre_film FROM Films";
            $results = $this->exec($req, null);
            
            // Extracting titles from the result set
            $titles = [];
            foreach ($results as $result) {
                $titles[] = $result->titre_film;
            }
            
            return $titles;
        }
        


        public function getFilm($num_film)
        {   
            $req ="SELECT * from Films WHERE num_film=" . $num_film;
            return $this->exec($req,null,"Film");
        }

        public function add_film_to_db($num_film,$etat)
        {
            $req ="Insert into Watched_film (num_film,est_regarde) values(:numF,:Etat)";
            $para =["numF" =>$num_film, "Etat" =>$etat];
            return $this->exec($req,$para);
        }
        public function remove_film_from_db($num_film)
        {
            $req="DELETE from Watched_film WHERE num_film=" . $num_film;
            $this->exec($req,null);
        }
        function updateEtat($num_film,$state)//modifie l etat est regarde par vrai ou faux
        {
            $req="UPDATE Watched_film SET est_regarde=:Etat WHERE num_film=:numF";
            $para = ["Etat" =>$state ,"numF" => $num_film];
            $this->exec($req,$para);
        }
    }



?>