<?php 


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