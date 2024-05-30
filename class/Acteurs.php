<?php 

    use pdo_wrapper\PdoWrapper;

     class Acteurs extends PdoWrapper{
        public  $actors=[];//ce tableau cle valuer contient les acteurs qui ont joue dans des films,ou les cles sont les noms des acteurs et les valeurs les acteurs
       
        public function getAllactors(){
            return( $this->exec(
                "SELECT * FROM acteur ",
                null,
                'Acteur') );
        }


    }


?>