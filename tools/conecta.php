<?php
include_once 'config.php';

class Conecta extends Config {

   var $con;
   
   function __construct() {      
      try {
        $username  = "root";
        $password  = "sucesso";
        $hostname  = "localhost";
        $db        = "db_imobiliaria";         
        $this->con = new PDO("mysql:host=$hostname;dbname=$db;charset=utf8", $username, $password,
                                            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

      }
      catch ( PDOException $e ) {
         echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
      }
   } // __construct

} // Config