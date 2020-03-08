<?php
class Conecta {
   var $con;
   function __construct() {    

      $server = $_SERVER['SERVER_NAME'];

      if ( $server =='www.oviralata.com.br' || $server =='oviralata.com.br'  ) {

         //.. local
         try {
           $username  = "port1053_root";
           $password  = "cpd392781";
           $hostname  = "localhost";
           $db        = "port1053_db_oviralata";         
           $this->con = new PDO("mysql:host=$hostname;dbname=$db;charset=utf8", $username, $password,
                                               array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

         }
         catch ( PDOException $e ) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
         }

      } else {
         //.. host
         try {
           $username  = "root";
           $password  = "sucesso";
           $hostname  = "localhost";
           $db        = "db_oviralata";          
           $this->con = new PDO("mysql:host=$hostname;dbname=$db;charset=utf8", $username, $password,
                                               array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

         }
         catch ( PDOException $e ) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
         }

      } 


   } // __construct

}