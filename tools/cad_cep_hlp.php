<?php 
include_once '../cadastro/conecta.php';
include_once '../cadastro/infra_cod_erro.php';

/**
 * Classe que auxilia a manutenção de CEPs 
 *   utiliza o 'via_cep.com.br'
 */

class Cadastro_Cep_Hlp extends conecta {

   private $_filtro_cep;
   private $_filtro_logradouro;
   private $_filtro_municipio;
   private $_filtro_uf;
   private $_array_cep = array();
   
   public $cod_erro;

   public function __construct() {
      parent::__construct();
      $this->cod_erro = null;
   }

   public function get_filtro_cep() {
      return $this->_filtro_cep;
   }

   public function set_filtro_cep( $valor ) {
      $this->_filtro_cep = $valor;
   }
   
   public function get_filtro_logradouro() {
      return $this->_filtro_logradouro;
   }

   public function set_filtro_logradouro( $valor ) {
      $this->_filtro_logradouro = $valor;
   }

   public function get_filtro_municipio() {
      return $this->_filtro_municipio;
   }

   public function set_filtro_municipio( $valor ) {
      $this->_filtro_municipio = $valor;
   }

   public function get_filtro_uf() {
      return $this->_filtro_uf;
   }

   public function set_filtro_uf( $valor ) {
      $this->_filtro_uf = $valor;
   }

   /**
   * Guardar Ceps
   */
   function guardar_ceps($cep) {
      $this->_array_cep[$cep]=$cep;
   }

   function obter_ceps( &$resultado ) {
      $json = '';
      $resultado = array();
      $cep        = $this->get_filtro_cep();
      $logradouro = $this->get_filtro_logradouro();
      $municipio  = $this->get_filtro_municipio();
      $uf         = $this->get_filtro_uf();
      if ($cep) {
         $json = file_get_contents('https://viacep.com.br/ws/'. $cep . '/json/');
      } else {
         if ( $logradouro != '' && $municipio != '' && $uf != '' ) {            
            $json = file_get_contents('https://viacep.com.br/ws/'.$uf.'/'.$municipio.'/'.$logradouro.'/json/');
         }
      }
      if ( $json != '' ) {
         $retorno = json_decode($json);      
         if ( !isset($retorno->erro) ) {
            if( is_array($retorno) ) {
               $resultado = $retorno;
            } else {
               $resultado[] = $retorno;
            }      
         }
      }
   }

   function validar_se_ja_existe( &$ceps ) {
      foreach ( $ceps as $indice => $item ) {
         if ( $this->cep_ja_existe($item->cep) ) {
            $ceps[$indice]->existe = 'S';
         } else {
            $ceps[$indice]->existe = 'N';
         }        
      }

   }

   function cep_ja_existe($cep) {
      $cep       = str_replace('-', '', $cep );
      $resultado = false;
      $sql = " SELECT id_logradouro FROM tblogradouro WHERE cep='{$cep}'";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $logradouro = $stmt->fetchAll(PDO::FETCH_CLASS);
      if ( count($logradouro)>0 ) {
         $resultado=true;
      }
      return $resultado;
   }

   function incluir_cep() {
      $cep         = str_replace('-', '', $this->dados->cep );
      $logradouro  = $this->dados->logradouro;
      $complemento = $this->dados->complemento;
      $local       = '';
      $bairro      = $this->dados->bairro;
      $municipio   = $this->dados->localidade;
      $uf          = $this->dados->uf;

      $param_lograduro   = $logradouro =='' ? PDO::PARAM_NULL : PDO::PARAM_STR; 
      $param_complemento = $complemento=='' ? PDO::PARAM_NULL : PDO::PARAM_STR; 
      $param_bairro      = $bairro     =='' ? PDO::PARAM_NULL : PDO::PARAM_STR; 
      $param_municipio   = $municipio  =='' ? PDO::PARAM_NULL : PDO::PARAM_STR; 

      $sql = " SELECT id_logradouro FROM tblogradouro WHERE cep='{$cep}'";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $logradouro = $stmt->fetchAll(PDO::FETCH_CLASS);
      if ( count($logradouro)>0 ) {
         $this->id_logradouro = $logradouro[0]->id_logradouro;
      } else {
         $sql = "INSERT INTO tblogradouro( cep, logradouro, complemento, local, bairro, municipio, uf ) 
                 VALUES ( :cep, :logradouro, :complemento, :local, :bairro, :municipio, :uf ) ";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':cep',         $cep,         PDO::PARAM_STR     );
         $stmt->bindValue(':logradouro',  $logradouro,  $param_complemento );
         $stmt->bindValue(':complemento', $complemento, $param_complemento );
         $stmt->bindValue(':local',       $local,       PDO::PARAM_STR     );
         $stmt->bindValue(':bairro',      $bairro,      $param_bairro      );
         $stmt->bindValue(':municipio',   $municipio,   $param_municipio   );
         $stmt->bindValue(':uf',          $uf,          PDO::PARAM_STR);
         $stmt->execute();
         $this->id_logradouro = $this->con->lastInsertId();
      }
   }

   /**
   * Inclui o cep
   */
   function incluir() {
      $retorno ='';
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         foreach ( $this->_array_cep as $cep ) {
            if ( !$this->cep_ja_existe($cep) ) {
               $json  = file_get_contents('https://viacep.com.br/ws/'. $cep . '/json/');
               $this->dados = json_decode($json);
               $this->incluir_cep();
               $retorno .= "{$cep} Cadastrado com sucesso<br>";
            } else {
               $retorno .= "{$cep} --> já existe<br>";
            }
         }

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }   

      $this->retorno = $retorno;
   }







  

    function incluir_ufxxxxxxxxxxxxxxx() {      
      $sql  = " SELECT id_uf FROM tbuf WHERE nome_uf='{$this->dados->uf}'";
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

   function incluir_municipioxxxxxxxxxxxxxxxxxxxxxxxxx() {
      $nome_cidade = $this->dados->localidade;

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
         $stmt->bindValue(':id_uf',          $this->id_uf, PDO::PARAM_INT);      
         $stmt->execute();
         $this->id_municipio = $this->con->lastInsertId();
      }
   } // incluir_municipio

   function incluir_bairroxxxxxxxxxxxxxxxxxxxxxxxxx() {
      $nome_bairro  = $this->dados->bairro;
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

   
}