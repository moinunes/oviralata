<?php

/*
* gera txt com todos os CEPs do brasil
*
* Executar.: php /var/www/oviralata/ceps/criar_txt.php
*
*
*    delete from tblogradouro; alter table tblogradouro AUTO_INCREMENT = 1;
*
*


   DROP TABLE IF EXISTS `tblogradouro`;
   CREATE TABLE `tblogradouro` (
     `id_logradouro` int(4) NOT NULL AUTO_INCREMENT,
     `cep` char(8) DEFAULT NULL,
     `logradouro` varchar(255) DEFAULT NULL,
     `complemento` varchar(255) DEFAULT NULL,
     `bairro` varchar(255) DEFAULT NULL,
     `municipio` varchar(255) DEFAULT NULL,
     `uf` char(2) DEFAULT NULL,
     `ddd` varchar(255) DEFAULT NULL,
     PRIMARY KEY (`id_logradouro`),
     UNIQUE KEY `index_cep` (`cep`)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/

class Cria_Txt_Ceps_Brasil {
   
   public $con;
   public $hora_inicial;   

   function __construct() {      
      $this->conecta();
      $this->hora_inicial = date('H:i:s');
   }
   
   //sp,RJ',MG ) { 

   function executar() {
      $sql = " SELECT
                  logradouro.CEP, 
                  logradouro.descricao,
                  logradouro.complemento,
                  logradouro.descricao_bairro,
                  logradouro.descricao_cidade,
                  logradouro.UF,
                  cidade.ddd                  
               from logradouro
                  JOIN cidade ON (cidade.id_cidade=logradouro.id_cidade)
               ";               
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $qry = $stmt->fetchAll(PDO::FETCH_CLASS);
      foreach ( $qry as $item ) {
            $texto = $item->CEP.'|'.
                     $item->descricao.'|'.
                     $item->complemento.'|'.
                     $item->descricao_bairro.'|'.
                     $item->descricao_cidade.'|'.
                     $item->UF.'|'.
                     $item->ddd;
         file_put_contents( '/var/www/oviralata/ceps/todos_ceps_do_brasil.txt', $texto ."\n", FILE_APPEND   );
         print $item->CEP.' ->'.++$i."\n";
      }
      
   } // executar

   private function tem_cep( $cep ) {
      $cep=trim($cep);
      $resultado=false;
      $sql = " SELECT
                  cep
               from tblogradouro
               where cep='{$cep}'";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $dados = $stmt->fetchAll(PDO::FETCH_CLASS);
      if($dados) {
         $cep = $dados[0];
         if ( $cep!='' ) {
            $resultado=true;
         }
      }
      return $resultado;
   }

   
   private function conecta() {      
      $username  = "root";
      $password  = "sucesso";
      $host      = "localhost";
      $db        = "db_oviralata";         
      $this->con = new PDO("mysql:dbname=$db;host=$host", $username, $password );
   } // conecta

   private function obter_do( &$do, $linha ) {
      $do = new stdclass;
      $dados = explode( '|', $linha );
      $do->cep             = trim($dados[1]);
      $do->tipo_logradouro = trim($dados[2]);
      $do->logradouro      = trim($dados[3]);
      $do->complemento     = trim($dados[4]);
      $do->local           = trim($dados[5]);
      $do->bairro          = trim($dados[6]);
      $do->municipio       = trim($dados[7]);
      $do->uf              = trim($dados[8]);
   } // obter_do  
   

} // Importar_Cep

$instancia = new Cria_Txt_Ceps_Brasil();
$instancia->executar();
