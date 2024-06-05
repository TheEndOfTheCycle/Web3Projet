<?php
namespace pdo_wrapper ;

use \PDO ;

class PdoWrapper
{

    private $db_name ;
    private $db_user ;
    private $db_pwd ;
    private $db_host ;
    private $db_port ;
    private $pdo ;

    public function __construct($db_name = 'dataprojet', $db_host='127.0.0.1', $db_port='3306', $db_user = 'root', $db_pwd='Angra'){
        $this->db_name = $db_name ;
        $this->db_host = $db_host ;
        $this->db_port = $db_port ;
        $this->db_user = $db_user ;
        $this->db_pwd = $db_pwd ;
    
        $dsn = 'mysql:dbname=' . $this->db_name . ';host='. $this->db_host. ';port=' . $this->db_port;
        try{
            $this->pdo = new PDO($dsn, $this->db_user, $this->db_pwd);
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
            $data = $res->fetchAll(PDO::FETCH_OBJ);
        }

        return $data ;
    }

}