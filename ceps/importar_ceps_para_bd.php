<?php

/********************************************************************************
* Programa: importar_ceps_para_bd.php
* 
* Objetivo: atualizar a sua base de dados utilizando o arquivo 'ceps.txt'

* tabelas que serão alimentadas: tbdomicilio;
*                                tblogradouro;
*                                tbbairro;
*                                tbmunicipio;
*                                tbuf;
*
* Executar.: php /var/www/imobiliaria/ceps/importar_ceps_para_bd.php
*
*********************************************************************************/

/*

      delete from tbdomicilio;
      delete from tblogradouro;
      delete from tbbairro;
      delete from tbmunicipio;
      delete from tbuf;

*/

class Importar_Cep {
   
   public $con;
   public $hora_inicial;
   public $_importar_municipio;

   function __construct() {      
      $this->conecta();
      $this->hora_inicial = date('H:i:s');
   }
   
   function executar() {
      $fp    = fopen( "/var/www/imobiliaria/ceps/ceps.txt", "r" );
      $i=0;
      while ( !feof ($fp ) ) {
         $linha = fgets( $fp, 4096 );
         $this->obter_do( $do, $linha );
         $this->do = $do;         

         if( $do->uf=='SP' && strtolower($this->do->municipio)== $this->_importar_municipio ) {            
            print $this->do->municipio.' ->'.++$i."\n";
            $this->incluir_uf();
            $this->incluir_municipio();
            $this->incluir_bairro();
            $this->incluir_logradouro();
         }
      }
      fclose($fp);      
   } // executar
   
   private function conecta() {      
      $username  = "root";
      $password  = "sucesso";
      $host      = "localhost";
      $db        = "db_imobiliaria";         
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

   function incluir_uf() {      
      $sql  = " SELECT id_uf FROM tbuf WHERE nome_uf='{$this->do->uf}'";
      $stmt = $this->con->prepare($sql);
      $stmt->execute();
      $uf = $stmt->fetchAll(PDO::FETCH_CLASS); 
      if ( count($uf)>0 ) {         
         $this->id_uf = $uf[0]->id_uf;         
      } else {
         $sql = "INSERT INTO tbuf(nome_uf) VALUES (:nome_uf) ";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':nome_uf', $this->do->uf, PDO::PARAM_STR);      
         $stmt->execute();
         $this->id_uf = $this->con->lastInsertId();
      }
   } // incluir_uf

   function incluir_municipio() {
      $nome_cidade = utf8_decode($this->do->municipio);
      $id_uf       = trim($this->id_uf);

      $sql = " SELECT id_municipio FROM tbmunicipio WHERE nome_municipio='{$nome_cidade}'";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $municipio = $stmt->fetchAll(PDO::FETCH_CLASS);
      if ( count($municipio)>0 ) { 
         $this->id_municipio = $municipio[0]->id_municipio;
      } else {      
         $sql = "INSERT INTO tbmunicipio(nome_municipio, id_uf) VALUES (:nome_municipio, :id_uf) ";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':nome_municipio', $nome_cidade, PDO::PARAM_STR);      
         $stmt->bindValue(':id_uf',          $id_uf, PDO::PARAM_INT);      
         $stmt->execute();
         $this->id_municipio = $this->con->lastInsertId();
      }
   } // incluir_municipio

   function incluir_bairro() {
      $nome_bairro  = utf8_decode($this->do->bairro);
      $id_municipio = $this->id_municipio;

      $sql = " SELECT id_bairro FROM tbbairro WHERE nome_bairro='{$nome_bairro}'";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $bairro = $stmt->fetchAll(PDO::FETCH_CLASS); 
      if ( count($bairro)>0 ) { 
         $this->id_bairro = $bairro[0]->id_bairro;
      } else {      
         $sql = "INSERT INTO tbbairro(nome_bairro, id_municipio) VALUES (:nome_bairro, :id_municipio) ";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':nome_bairro',  $nome_bairro,  PDO::PARAM_STR);      
         $stmt->bindValue(':id_municipio', $id_municipio, PDO::PARAM_INT);      
         $stmt->execute();
         $this->id_bairro = $this->con->lastInsertId();
      }
   } // incluir_bairro

   function incluir_logradouro() {
      $nome_logradouro = utf8_decode($this->do->tipo_logradouro).' '.utf8_decode($this->do->logradouro);
      $cep             = $this->do->cep;
      $complemento     = utf8_decode($this->do->complemento);
      $local           = utf8_decode($this->do->local);

      $sql = " SELECT id_logradouro FROM tblogradouro WHERE cep='{$cep}'";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $logradouro = $stmt->fetchAll(PDO::FETCH_CLASS); 
      if ( count($logradouro)>0 ) { 
         $this->id_logradouro = $logradouro[0]->id_logradouro;
      } else {

         $sql = "INSERT INTO tblogradouro(nome_logradouro, cep, complemento, local, id_bairro ) VALUES (:nome_logradouro, :cep, :complemento, :local, :id_bairro) ";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':nome_logradouro', $nome_logradouro, PDO::PARAM_STR);
         $stmt->bindValue(':cep',             $cep,             PDO::PARAM_STR);
         $stmt->bindValue(':complemento',     $complemento,     PDO::PARAM_STR);
         $stmt->bindValue(':local',           $local,           PDO::PARAM_STR);
         $stmt->bindValue(':id_bairro',       $this->id_bairro, PDO::PARAM_INT);
         $stmt->execute();
         $this->id_logradouro = $this->con->lastInsertId();
      }
   } // incluir_logradouro

} // Importar_Cep

$atualizar = new Importar_Cep();
$atualizar->_importar_municipio = 'são vicente';
$atualizar->_importar_municipio = 'santos';
$atualizar->_importar_municipio = 'praia grande';
$atualizar->executar();

