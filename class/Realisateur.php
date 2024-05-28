<?php   
require_once "../config.php";
class Realisateur extends PdoWrapper{
  public  $num_real;
   public $nom_real;
   public $nom_img;
   public function getMovies()
   {
        $req="select titre_film,nom_real from films inner join realisateur where realisateur.num_real=films.num_real and realisateur.num_real=". $this->num_real;
        return $this->exec($req,null,null);
   }
   public function getMoviesNames()
   {
    $tempo=$this->getMovies();
    $Mnames = [];
    $i=0;
    foreach($tempo as $t)
    {
        $Mnames[$i]=$t->titre_film;
        $i++;
    }
    return $Mnames;//ce tableau est de taille sizeof(Mnames)
   }
    public function getHTML(){ 
        ?>
        <div class="real">
        <h1><?= $this->nom_real ?></h1>
        <?php if($this->nom_img != null) : ?>
            <img   src="<?= "../images/realisateurs/" .$this->nom_img .".jpg" ?>">
       
        <?php endif; ?>
        </div>


        <?php
    }
}


?>