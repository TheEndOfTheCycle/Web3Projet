<?php 
    function autoload($class_name){

      
        $class_name = str_replace('\\', '/', $class_name) ;
        require 'class/' .$class_name . '.php' ;
    }
    spl_autoload_register('autoload') ;
?>