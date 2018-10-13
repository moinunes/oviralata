<?php
include_once 'config.php';

class Conecta extends Config {

   var $con;
   
   function __construct() {      
      try {
        $username="root";
        $password="sucesso";
        $host="localhost";
        $db="db_imobiliaria";         
        $this->con = new PDO("mysql:dbname=$db;host=$host", $username, $password );
      }
      catch ( PDOException $e ) {
         echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
      }
   } // __construct

} // Config