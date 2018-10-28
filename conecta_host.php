<?php


class Conecta {

   var $con;
   

   function __construct() {      
      
      if ( $_SERVER['SERVER_NAME'] =='localhost' ) {

         //.. local
         try {
           $username  = "root";
           $password  = "sucesso";
           $hostname  = "localhost";
           $db        = "imoveisb_imoveis";         
           $this->con = new PDO("mysql:host=$hostname;dbname=$db;charset=utf8", $username, $password,
                                               array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

         }
         catch ( PDOException $e ) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
         }

      } else {         

         //.. host
         try {
           $username  = "imoveisb_moises";
           $password  = "moises070768";
           $hostname  = "localhost";
           $db        = "imoveisb_imobiliaria";         
           $this->con = new PDO("mysql:host=$hostname;dbname=$db;charset=utf8", $username, $password,
                                               array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

         }
         catch ( PDOException $e ) {
            echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
         }

      } 


   } // __construct

} // Config


