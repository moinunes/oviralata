<?php 
include_once '../cadastro/conecta.php';
include_once '../cadastro/utils.php';
include_once '../cadastro/infra_cod_erro.php';

/**
 * Classe que auxilia o cadastro de Raças
 */

class Cad_Raca_Hlp extends conecta {

   private $id_raca;
   private $raca; 
   private $id_categoria; 
   
   public $cod_erro;

   public function __construct() {
      parent::__construct();
      $this->cod_erro = null;
   }

   public function get_id_raca() {
      return $this->id_raca;
   }

   public function set_id_raca( $valor ) {
      $this->id_raca = $valor;
   }

   public function get_raca() {
      return $this->raca;
   }

   public function set_raca( $valor ) {
      $this->raca = $valor;
   }  

   public function get_id_categoria() {
      return $this->id_categoria;
   }

   public function set_id_categoria( $valor ) {
      $this->id_categoria = $valor;
   }
   /**
    * Inclui a raca
    */
   function incluir() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $campos = " raca,id_categoria";
         $sql = "INSERT INTO tbraca({$campos})
                 VALUES ( :raca, :id_categoria)";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':raca', utf8_decode($this->get_raca()), PDO::PARAM_STR );
         $stmt->bindValue(':id_categoria', utf8_decode($this->get_id_categoria()), PDO::PARAM_INT );
         $stmt->execute();
         $id_raca = $this->con->lastInsertId();
         
      } catch(PDOException $e) {         
         $cod_erro = new Infra_Cod_Erro();
         $this->cod_erro = $cod_erro->obter_erros( $e->getMessage() );       
      }
      return null;
   }

   /**
    * Alterar a raça
    */
   function alterar() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbraca
                  SET raca ='{$this->get_raca()}'
                  WHERE id_raca={$this->get_id_raca()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }
      return null;
   }
   
   /**
    * Excluir a raça
    */
   function excluir() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " DELETE FROM tbraca                  
                  WHERE id_raca={$this->get_id_raca()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

      } catch(PDOException $e) {
         $cod_erro = new Infra_Cod_Erro();
         $this->cod_erro = $cod_erro->obter_erros( $e->getMessage() );
      }
   }
   
   function obter_racas( &$racas ) {
      $filtro = "1=1";
      if ( $this->get_id_raca() != '' ) {
         $filtro .= " AND tbraca.id_raca = ".$this->get_id_raca();
      }
      if ( $this->get_id_categoria() != '' ) {
         $filtro .= " AND tbraca.id_categoria = ".$this->get_id_categoria();
      }
      $sql = " SELECT 
                  tbraca.id_raca,
                  tbraca.raca,
                  tbraca.id_categoria,
                  tbcategoria.categoria
               FROM 
                  tbraca
                     JOIN tbcategoria ON (tbcategoria.id_categoria=tbraca.id_categoria)
               WHERE
                  $filtro
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $racas = $stmt->fetchAll(PDO::FETCH_CLASS);   
   }

   /**
   * Obtém todas as categorias
   * obs: 
   */   
   public function obter_categoria(&$resultado, $id_categoria=null ) {
      $filtro  ="codigo in('cao','gato')";
      $filtro .= $id_categoria!='' ? "WHERE id_categoria=$id_categoria" : ''; 
      $sql = " SELECT
                  id_categoria,
                  categoria,
                  codigo
               FROM 
                  tbcategoria
               WHERE {$filtro}   
               ORDER BY id_categoria   
            ";  
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);
      //Utils::Dbga_Abort($sql);
   }

}