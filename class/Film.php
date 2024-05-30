<?php       

use pdo_wrapper\PdoWrapper;

 class Film  extends PdoWrapper
{
    public $num_film;
   public $titre_film;
   public $anSortie_film;
   public $genre_film;
   public $num_real;
   public $nom_affiche;
   public $synopsis;
   public function getReal()//retourne le realisateur du filme
   {
        $req="select nom_real from realisateur inner join Films where Films.num_real=realisateur.num_real and Films.num_real=". $this->num_real;
        return $this->exec($req,null,"Realisateur");
   }
   public function getNomReal()
   {
       return $this->getReal()[0]->nom_real;
   }
   public function getActors()//retourne un tableau d acteurs ayant joue dans ce film
   {
            $req="select nom_act from acteur inner join jouer on jouer.num_act=acteur.num_act inner join Films on Films.num_film=jouer.num_film where Films.num_film=".$this->num_film;
            return $this->exec($req,null,"Acteur");
   }
   public function getNomsActors()//retourne un tableau contenant les noms des acteurs
   {
        $Tactors = [];
        $i=0;
        foreach($this->getActors() as $act)
        {
            $Tactors[$i]=$act->nom_act;
            $i++;
        }
        return $Tactors;
   }
   public function getTags()
   {
        $req="select nom_tag from films inner join film_tag on films.num_film=film_tag.num_film inner join tags on tags.num_tag=film_tag.num_tag where films.num_film=
        ".$this->num_film;
       return $this->exec($req,null,"Tag");
   }
   public function getTagsNames()
   {
        $Ttags = [];
        $i=0;
        foreach($this->getTags() as $tag)
        {
            $Ttags[$i]=$tag->nom_tag;
            $i++;
        }
        return $Ttags;
   }
   public function getHtml()
   {
    ?>
           <div class="infoMovie2">
                    <div class="cat1">
                        <span><?= $this->getNomReal()  ?></span>
                        <img   src="<?= "../images/affiches/" .$this->nom_affiche .".jpg" ?>">
                        <span><?php
                        ?></span>
                    </div>
                    </div>
                    </div>


    <?php
   }
}




?>