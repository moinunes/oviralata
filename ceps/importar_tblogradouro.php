
<?php

/********************************************************************************
* Programa: importar ceps para 'tblogradouro'
* 
* Objetivo: atualizar a sua base de dados utilizando o arquivo 'todos_ceps_do_brasil.txt'

* obs: todos os ceps do BRASIL
*
* Executar.: php /var/www/oviralata/ceps/importar_tblogradouro.php
*
*********************************************************************************/

/*

                  CREATE TABLE tblogradouro(
                     id_logradouro int(4) AUTO_INCREMENT,
                     cep             char(8),
                     logradouro      varchar(255),
                     complemento     varchar(255),
                     local           varchar(255),
                     bairro          varchar(255),
                     municipio       varchar(255),
                     uf              char(2) ,                   
                     PRIMARY KEY (id_logradouro )
                  );
                  CREATE UNIQUE INDEX index_cep ON tblogradouro (cep);

      
      delete from tblogradouro      
      alter table tblogradouro AUTO_INCREMENT = 1;
      
      SELECT table_schema "Nome da base", sum( data_length + index_length ) / 1024 / 1024 "Tamanho do BD em MB"
      FROM information_schema.TABLES GROUP BY table_schema ;

*/

class Importar_Cep {
   
   public $con;
   public $hora_inicial;   

   function __construct() {      
      $this->conecta();
      $this->hora_inicial = date('H:i:s');
   }
   
   //sp,RJ',MG ) { 

   function executar() {
      $fp    = fopen( "/var/www/oviralata/ceps/todos_ceps_do_brasil.txt", "r" );
      $i=0;
      while ( !feof ($fp ) ) {
         $linha = fgets( $fp, 4096 );
         $this->obter_do( $do, $linha );
         $this->do = $do;
         $uf=trim($do->uf);
         //if( $uf !='SP' && $uf !='RJ' && $uf !='MG' ) { 
            $this->incluir(); 
            print $this->do->uf.' ->'.++$i."\n";
         //}    
      }
      fclose($fp);      
   } // executar

   function incluir() {
      $cep         = $this->do->cep;
      $logradouro  = utf8_decode($this->do->tipo_logradouro).' '.utf8_decode($this->do->logradouro);      
      $complemento = utf8_decode($this->do->complemento);
      $local       = utf8_decode($this->do->local);
      $bairro      = utf8_decode($this->do->bairro);
      $municipio   = utf8_decode($this->do->municipio);
      $uf          = $this->do->uf;

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = "INSERT INTO tblogradouro( 
                          cep, logradouro, complemento, local, bairro, municipio, uf, ddd ) 
                 VALUES (:cep, :logradouro, :complemento, :local, :bairro, :municipio, :uf, :ddd ) ) ";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':cep',        $cep,         PDO::PARAM_STR);         
         $stmt->bindValue(':logradouro', $logradouro,  PDO::PARAM_STR);
         $stmt->bindValue(':complemento',$complemento, PDO::PARAM_STR);
         $stmt->bindValue(':local',      $local,       PDO::PARAM_STR);
         $stmt->bindValue(':bairro',     $bairro,      PDO::PARAM_STR);
         $stmt->bindValue(':municipio',  $municipio,   PDO::PARAM_STR);
         $stmt->bindValue(':uf',         $uf,          PDO::PARAM_STR);
         $stmt->bindValue(':ddd',        $ddd,         PDO::PARAM_STR);
         
         $stmt->execute();

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
         print 'erro: ';die($cep);
      }
   } // incluir
   
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
      $do->cep             = trim($dados[0]);
      $do->logradouro      = trim($dados[1]);
      $do->complemento     = trim($dados[2]);
      $do->bairro          = trim($dados[3]);
      $do->municipio       = trim($dados[4]);
      $do->uf              = trim($dados[5]);
      $do->ddd             = trim($dados[6]);
   } // obter_do  
   

} // Importar_Cep

$atualizar = new Importar_Cep();
$atualizar->executar();
