<?php 
require_once "../config.php";

use pdo_wrapper\PdoWrapper;
    class Tags extends PdoWrapper{
        public function getAllTags()
        {
            return $this->exec("select * from tags ",null,"Tag");
        }
        public function add_tag_to_db($nom_tag)
        {
                //on va inserer un nouveau tag dans le tableau tags
                $req="Insert into tags (nom_tag) values(:nom_tag)";
                $para = ["nom_tag" =>$nom_tag ];
                $this->exec($req,$para);
        }
        public function remove_tag_from_db($nomTag)
        {
            $num_tag =$this->getNumTag($nomTag);
            $para=["numT" =>$num_tag];
            //effacons d abord les dependances  (effacer le tag de film_tag,donc la cle etrangere num_tags)
            $req="delete from film_tag where num_tag=:numT";
            $this->exec($req,$para);
            //effacons tag du tableau tags
            $req="delete from tags where num_tag=:numT";
            $this->exec($req,$para);
        }
        public function getNumTag($nomTag)//cette fonction prend en parametre un nom de tag(nom_tag) et retourne son numero(num_tag)
        {
            $req="select nom_tag,num_tag from tags ";
            $res = $this->exec($req,null,"Tag");
            foreach($res as $tag)//on parcourt tous les objets de classes tag
            {
                if(strtolower($tag->nom_tag)==strtolower($nomTag))
                {
                    //var_dump($tag);
                    return $tag->num_tag;
                }
            }
           // var_dump($res);
        }
        public function tagExists($nomTag)
        {
            $req = "SELECT COUNT(*) as count FROM tags WHERE nom_tag = :nom_tag";
            $para = ["nom_tag" => $nomTag];
            $res = $this->exec($req, $para);
    
            return is_array($res) && count($res) > 0 && $res[0]->count > 0;
        }

    }



