<?php

class PdoWrapper
{

    private $db_name ;
    private $db_user ;
    private $db_pwd ;
    private $db_host ;
    private $db_port ;
    private $pdo ;

    public function __construct($db_name="dataprojet", $db_pwd='Angra',$db_host='127.0.0.1', $db_port='3306', $db_user = 'root'){
        $this->db_name = $db_name ;//nom de la base donnee
        $this->db_host = $db_host ;//l adresse ip de la machine ou ce situe cette base donnee
        $this->db_port = $db_port ;//le port sur le qu elle est connect mysql
        $this->db_user = $db_user ;//nom du compte sur lequel cette base donnee est
        $this->db_pwd = $db_pwd ;//le mot de passe

        $dsn = 'mysql:dbname=' . $this->db_name . ';host='. $this->db_host. ';port=' . $this->db_port;//concaténation des informations regardant cette base de donnees selon l agregat dsn
        try{
            $this->pdo = new PDO($dsn, $this->db_user, $this->db_pwd);//l objet PDO,ceci nous permet de manipuler notre base de donnees cible
        }catch (\Exception $ex){
            die('Error : ' . $ex->getMessage()) ;
        }

    }

    public function exec($statement, $params, $classname=null){
        $res = $this->pdo->prepare($statement) ;
        $res->execute($params) or die(print_r($res->errorInfo()));

        if($classname != null){
            $data = $res->fetchAll(PDO::FETCH_CLASS, $classname);
        }else{
            $data = $res->fetchAll(PDO::FETCH_OBJ);//on convertit le resultat en tableau d objets ,chaque objet etant une ligne
        }

        return $data ;
    }

}