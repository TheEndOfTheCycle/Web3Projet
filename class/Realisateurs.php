<?php


use pdo_wrapper\PdoWrapper;


class Realisateurs extends PdoWrapper
{
    public function getAllreal(){
        return( $this->exec(
            "SELECT * FROM realisateur ",
            null,
            'Realisateur') );
    }
}


?>