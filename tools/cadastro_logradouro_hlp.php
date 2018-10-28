<?php 
include_once 'conecta.php';
include_once 'infra_cod_erro.php';

/**
 * Classe que efetua o cadastro de logrdouros
 *
 * é usada somente qdo não consegue fazer o cadastro Automático
 *          
 *
 *
 */

class Cadastro_Logradouro_Hlp extends conecta {

   private $cep;
   private $nome_logradouro;
   private $nome_bairro;
   private $nome_municipio;
   private $id_municipio;
   private $id_bairro;
   private $id_logradouro;

   public $cod_erro;

   public function __construct() {
      parent::__construct();
      $this->cod_erro = null;
   }

   public function get_cep() {
      return $this->cep;
   }

   public function set_cep( $valor ) {
      $this->cep = $valor;
   }
   
   public function get_nome_logradouro() {
      return $this->nome_logradouro;
   }

   public function set_nome_logradouro( $valor ) {
      $this->nome_logradouro = $valor;
   }
   
   public function get_nome_bairro() {
      return $this->nome_bairro;
   }

   public function set_nome_bairro( $valor ) {
      $this->nome_bairro = $valor;
   }
   
   public function get_nome_municipio() {
      return $this->nome_logradouro;
   }

   public function set_nome_municipio( $valor ) {
      $this->nome_municipio = $valor;
   }
   
   public function get_id_municipio() {
      return $this->id_municipio;
   }

   public function set_id_municipio( $valor ) {
      $this->id_municipio = $valor;
   }

   public function get_id_logradouro() {
      return $this->id_logradouro;
   }

   public function set_id_logradouro( $valor ) {
      $this->id_logradouro = $valor;
   }

   public function get_id_bairro() {
      return $this->id_bairro;
   }

   public function set_id_bairro( $valor ) {
      $this->id_bairro = $valor;
   }

   /**
    * Inclui o Tipo de Imóvel
    */
   function incluir() {      

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $this->obter_bairro( $consulta_bairro, $this->get_nome_bairro(), $this->get_id_municipio() );
         if ( count($consulta_bairro)==0 ) {            
            $sql = "INSERT INTO tbbairro( nome_bairro, id_municipio ) VALUES (:nome_bairro, :id_municipio ) ";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':nome_bairro',  $this->get_nome_bairro(),  PDO::PARAM_STR);
            $stmt->bindValue(':id_municipio', $this->get_id_municipio(), PDO::PARAM_STR);
            $stmt->execute();
            $this->id_bairro = $this->con->lastInsertId();
         } else {
            $this->id_bairro = $consulta_bairro['id_bairro'];
         }

         $this->obter_logradouro( $consulta_logradouro, $this->get_cep(), $this->id_bairro );
         if ( count($consulta_logradouro)==0 ) {
            $campos = 'nome_logradouro, cep, id_bairro';
            $sql = "INSERT INTO tblogradouro({$campos}) VALUES ( :nome_logradouro, :cep, :id_bairro )";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':nome_logradouro', $this->get_nome_logradouro(), PDO::PARAM_STR);
            $stmt->bindValue(':cep',             $this->get_cep(),             PDO::PARAM_STR);
            $stmt->bindValue(':id_bairro',       $this->id_bairro,             PDO::PARAM_STR);
            
            $stmt->execute();
            $id_logradouro = $this->con->lastInsertId();
         }

      } catch(PDOException $e) {
         $cod_erro = new Infra_Cod_Erro();
         $this->cod_erro = $cod_erro->obter_erros( $e->getMessage() );       
         print '<pre>';  print_r($e->getMessage());
      }
      return null;
   } // incluir

   /**
    * Alterar o Tipo de Imóvel
    */
   function alterar() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbbairro
                  SET nome_bairro ='{$this->get_nome_bairro()}'
                  WHERE id_bairro={$this->get_id_bairro()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

         $sql = " UPDATE tblogradouro
                  SET nome_logradouro ='{$this->get_nome_logradouro()}', cep ='{$this->get_cep()}'
                  WHERE id_logradouro={$this->get_id_logradouro()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

      } catch(PDOException $e) {
         print '<pre>';  print_r($consulta_bairro); die('fim..');
         echo 'Error: ' . $e->getMessage();
      }
      return null;
   } // alterar
   
   function obter_logradouros( &$tipos ) {
      $filtro = "1=1";
      
      if ( $this->get_id_logradouro() != '' ) {
         $filtro .= " AND tblogradouro.id_logradouro = ".$this->get_id_logradouro();
      }

      if ( $this->get_id_municipio() != '' ) {
         $filtro .= " AND tbmunicipio.id_municipio = ".$this->get_id_municipio();
      }

      $cep = str_replace( '-', '', $this->get_cep() );
      if ( $cep != '' ) {
         $filtro .= " AND tblogradouro.cep = ".$cep;
      }

      if ( $this->get_nome_logradouro() != '' ) {
         $filtro .= " AND nome_logradouro like '%{$this->get_nome_logradouro()}%' ";
      }

      $sql = " SELECT 
                  tblogradouro.id_logradouro,
                  tbmunicipio.id_municipio,
                  tbbairro.id_bairro,
                  tblogradouro.cep,
                  tblogradouro.nome_logradouro,
                  tbbairro.nome_bairro,
                  tbmunicipio.nome_municipio,
                  tbuf.nome_uf
               FROM 
                  tblogradouro
                     JOIN tbbairro ON (tbbairro.id_bairro=tblogradouro.id_bairro)
                        JOIN tbmunicipio ON (tbmunicipio.id_municipio=tbbairro.id_municipio)
                           JOIN tbuf on (tbuf.id_uf=tbmunicipio.id_uf) 
               WHERE
                  $filtro
               LIMIT 10;
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tipos = $stmt->fetchAll(PDO::FETCH_CLASS);      
   } // obter_logradouros

   function obter_bairro( &$dados, $nome_bairro, $id_municipio ) {
      $dados = array();
      $filtro =" WHERE tbbairro.id_municipio={$id_municipio} AND tbbairro.nome_bairro='{$nome_bairro}'";
      $sql = " SELECT 
                  tbbairro.id_bairro,
                  tbbairro.nome_bairro,
                  tbbairro.id_municipio
               FROM 
                  tbbairro                  
                     JOIN tbmunicipio on (tbmunicipio.id_municipio=tbbairro.id_municipio)               
               $filtro      
             ";             
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();      
      $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ( count($resultado)>0) {
         $dados = $resultado[0];
      }
   } // obter_bairro

   function obter_logradouro( &$dados, $cep, $id_bairro ) {
      $dados  = array();
      $filtro = " WHERE tblogradouro.id_bairro={$id_bairro} AND tblogradouro.cep='{$cep}' ";
      $sql = " SELECT 
                  tblogradouro.id_logradouro,
                  tblogradouro.cep,
                  tblogradouro.id_bairro
               FROM 
                  tblogradouro
               $filtro      
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();      
      $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ( count($resultado)>0) {
         $dados = $resultado[0];      
      }
   } // obter_logradouro


} // Cadastro_Logradouro_Hlp
