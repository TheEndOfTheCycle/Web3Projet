<?php 

use pdo_wrapper\PdoWrapper;


    class Tags extends PdoWrapper{
        public function getAllTags()
        {
            return $this->exec("select * from tags ",null,"Tag");
        }
        public function add_tag_to_db($nom_tag,$num_tag)
        {
                //on va inserer un nouveau tag dans le tableau tags
                $req="Insert into tags (nom_tag,num_tag) values(:nom_tag,:num_tag)";
                $para = ["nom_tag" =>$nom_tag , "num_tag" => $num_tag];
                $this->exec($req,$para);
        }


    }



?>