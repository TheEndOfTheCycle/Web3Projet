<?php

use pdo_wrapper\PdoWrapper;

class Film extends PdoWrapper
{
    public $num_film;
    public $titre_film;
    public $anSortie_film;
    public $genre_film;
    public $num_real;
    public $nom_affiche;
    public $synopsis;
    public $est_regarde;

    public function getReal() // retourne le realisateur du film
    {
        $req = "select nom_real, nom_img from realisateur inner join Films where Films.num_real = realisateur.num_real and Films.num_real = " . $this->num_real;
        return $this->exec($req, null, "Realisateur");
    }

    public function getNomReal()
    {
        return $this->getReal()[0]->nom_real;
    }

    public function getNomImgReal()
    {
        return $this->getReal()[0]->nom_img;
    }

    public function getActors() // retourne un tableau d'acteurs ayant joué dans ce film
    {
        $req = "select nom_act, nom_img from acteur inner join jouer on jouer.num_act = acteur.num_act inner join Films on Films.num_film = jouer.num_film where Films.num_film = " . $this->num_film;
        return $this->exec($req, null, "Acteur");
    }

    public function getTags()
{
    // Utilisez des placeholders dans la requête pour éviter les injections SQL
    $req = "SELECT nom_tag FROM film_tag INNER JOIN tags ON film_tag.num_tag = tags.num_tag WHERE film_tag.num_film = :num_film";
    // Assurez-vous que $this->num_film est défini et non vide
    if (!empty($this->num_film)) {
        $para = ["num_film" => $this->num_film];
        // Utilisez la méthode query() au lieu de exec() car cette requête ne modifie pas les données
        return $this->exec($req, $para, "Tag");
    } else {
        return []; // Retourne un tableau vide si $this->num_film n'est pas défini
    }
}


    public function getTagsNames()
    {
        $Ttags = [];
        $i = 0;
        foreach ($this->getTags() as $tag) {
            $Ttags[$i] = $tag->nom_tag;
            $i++;
        }
        return $Ttags;
    }

   


    public function getNumFilm($nomFilm)
    {
        $req = "select * from Films where titre_film = :nomfilm";
        $para = ["nomfilm" => $nomFilm];
        $res = $this->exec($req, $para, "Film");
        return $res[0]->num_film;
    }

    public function getFilm($nom_film)
    {
        $num_film = $this->getNumFilm($nom_film);
        $req = "select * from Films where num_film = :numF";
        $para = ["numF" => $num_film];
        $res = $this->exec($req, $para, "Film");
        return ($res[0]);
    }

    public function getHtml()
    {
        ?>
        <div class="infoMovie2">
            <div class="cat1">
                <span><?= $this->getNomReal() ?></span>
                <img src="<?= "../images/affiches/" . $this->nom_affiche . ".jpg" ?>">
                <span><?php ?></span>
            </div>
        </div>
        <?php
    }
}