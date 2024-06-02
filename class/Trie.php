<?php 

use pdo_wrapper\PdoWrapper;

//cette classe contient toutes les méthodes de tries a applique a la barre de recherche
    class Trie extends PdoWrapper{
        public function getMoviesByTagName($nomTag) {
            $Otags = new Tags();
            $NumTag = $Otags->getNumTag($nomTag);
            $req = "SELECT * FROM Films 
                    INNER JOIN film_tag ON Films.num_film = film_tag.num_film 
                    INNER JOIN tags ON tags.num_tag = film_tag.num_tag 
                    WHERE tags.num_tag = :numTag";
            $params = array(':numTag' => $NumTag);
            $res = $this->exec($req, $params, "Film");
            return $res;
        }
        
        public function getMoviesByActorName($nomAct)//cette foction retourne les Films que l acteur a joue
        {
            $Bacteurs = new Acteurs();
            $num_act=$Bacteurs->getNumAct($nomAct);
            $req ="select nom_act,titre_film from (acteur  inner join jouer on jouer.num_act=acteur.num_act) inner join Films where Films.num_film=jouer.num_film and acteur.num_act=".$num_act;
            $res=$this->exec($req,null,"Film");
            return $res;
        }
        public function getMoviesByReal($nomReal)
        {
            $Breals = new Realisateurs();
            $num_real=$Breals->getNumReal($nomReal);
            $req="select titre_film,nom_real from Films inner join realisateur where realisateur.num_real=Films.num_real and realisateur.num_real=". $num_real;
            return($this->exec($req,null,"Film"));
        }
        public function getMoviesByTagsNames($Tnametags)//cette fonction retourne les Films qui ont les tags contenu dans Ttags
        {
            $tempo = [];
            $Otags = new Tags();
            $nomTag=$Otags->getNumTag($Tnametags[0]);
            $req="select * from Films inner join film_tag on Films.num_film=film_tag.num_film inner join tags on tags.num_tag=film_tag.num_tag where tags.num_tag=:".$nomTag;
            $para =[0 => strval($nomTag)];
            for($i=1;$i<sizeof($Tnametags);$i++)
            {
                $nomTag=$Otags->getNumTag($Tnametags[$i]);
                $req=$req ." and where tags.num_tag=:" .$nomTag;
                $para[$i]=strval($nomTag);
            }
            echo $req;
            var_dump($para);
           $res=$this->exec($req,$para);
           var_dump($res);
           
        }
        public function getMoviesByTagNameAndActName($nom_act,$nom_tag)//cette fonction retourne la liste des Films ou l acteur figure et le film a le tag correspondant
        {
            $Btags = new Tags();
            $Bacts = new Acteurs();
            $num_tag=$Btags->getNumTag($nom_tag);
            $num_act=$Bacts->getNumAct($nom_act);
            $req="select * from Films inner join film_tag on Films.num_film=film_tag.num_film inner join tags on tags.num_tag=film_tag.num_tag inner join jouer on Films.num_film=jouer.num_film inner join acteur on acteur.num_act=jouer.num_act where tags.num_tag=:numT and acteur.num_act=:numA";
            $para =["numA" => $num_act,"numT" => $num_tag];
            return $this->exec($req,$para,"Film");
        }
        public function getMoviesByTagNameAndRealName($nom_real,$nom_tag)
        {
            $Btags = new Tags();
            $Breals = new Realisateurs();
            $num_tag=$Btags->getNumTag($nom_tag);
            $num_real=$Breals->getNumReal($nom_real);
            $req="select * from Films inner join realisateur on realisateur.num_real=Films.num_real inner join film_tag on film_tag.num_film=Films.num_film inner join tags on tags.num_tag=film_tag.num_tag where tags.num_tag=:numT and realisateur.num_real=:numR" ;
            $para = ["numR" =>$num_real ,"numT" =>$num_tag];
            return $this->exec($req,$para);
        }
        public function getMoviesByActorNameAndRealName($nom_act,$nom_real)//cette fonction retourne la liste des Films diriges par ce real et ayant le tag correspondant
        {
            $Bacts = new Acteurs();
            $Breals = new Realisateurs();
            $num_real =$Breals->getNumReal($nom_real);
            $num_act =$Bacts->getNumAct($nom_act);
            $req ="select * from Films inner join realisateur on realisateur.num_real=Films.num_real inner join jouer on jouer.num_film=Films.num_film inner join acteur on acteur.num_act=jouer.num_act where acteur.num_act=:numA and realisateur.num_real=:numR" ;
            $para = ["numR" =>$num_real
            ,"numA" =>$num_act];
            return $this->exec($req,$para);
        }
    }

?>