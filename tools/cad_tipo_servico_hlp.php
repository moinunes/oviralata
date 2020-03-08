<?php 
include_once '../cadastro/conecta.php';
include_once '../cadastro/utils.php';
include_once '../cadastro/infra_cod_erro.php';

/**
 * Classe que auxilia o cadastro de Tipos de Serviço
 */

class Cad_Tipo_Servico_Hlp extends conecta {

   private $id_tipo_servico;
   private $tiposervico; 
   
   public $cod_erro;

   public function __construct() {
      parent::__construct();
      $this->cod_erro = null;
   }

   public function get_id_tipo_servico() {
      return $this->id_tipo_servico;
   }

   public function set_id_tipo_servico( $valor ) {
      $this->id_tipo_servico = $valor;
   }

   public function get_tiposervico() {
      return $this->tiposervico;
   }

   public function set_tiposervico( $valor ) {
      $this->tiposervico = $valor;
   }  

   public function get_ordem() {
      return $this->ordem;
   }

   public function set_ordem( $valor ) {
      $this->ordem = $valor;
   }  
   
   /**
    * Inclui a tipo_servico
    */
   function incluir() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = "INSERT INTO tbtipo_servico( tiposervico, ordem )
                 VALUES ( :tiposervico, :ordem )";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':tiposervico', utf8_decode($this->get_tiposervico()), PDO::PARAM_STR );
         $stmt->bindValue(':ordem', $this->get_ordem(), PDO::PARAM_INT );
         $stmt->execute();
         $id_tipo_servico = $this->con->lastInsertId();
         
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
         $sql = " UPDATE tbtipo_servico
                  SET tiposervico ='{$this->get_tiposervico()}',
                      ordem       ='{$this->get_ordem()}'
                  WHERE id_tipo_servico={$this->get_id_tipo_servico()} ";
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
         $sql = " DELETE FROM tbtipo_servico                  
                  WHERE id_tipo_servico={$this->get_id_tipo_servico()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

      } catch(PDOException $e) {
         $cod_erro = new Infra_Cod_Erro();
         $this->cod_erro = $cod_erro->obter_erros( $e->getMessage() );
      }
   }
   
   function obter_tipos_servico( &$tiposervicos ) {
      $filtro = "1=1";
      if ( $this->get_id_tipo_servico() != '' ) {
         $filtro .= " AND tbtipo_servico.id_tipo_servico = ".$this->get_id_tipo_servico();
      }
      if ( $this->get_tiposervico() != '' ) {
         $filtro .= " AND tbtipo_servico.tiposervico like '%".$this->get_tiposervico()."%'";
      }
      $sql = " SELECT 
                  tbtipo_servico.id_tipo_servico,
                  tbtipo_servico.tiposervico,
                  tbtipo_servico.ordem
               FROM 
                  tbtipo_servico
               WHERE
                  $filtro
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tiposervicos = $stmt->fetchAll(PDO::FETCH_CLASS);   
   }

   function obter_tipo_servico( &$resultado, $id_tipo_servico ) {
      $filtro .= " tbtipo_servico.id_tipo_servico = ".$this->get_id_tipo_servico();
      $sql = " SELECT 
                  tbtipo_servico.id_tipo_servico,
                  tbtipo_servico.tiposervico,
                  tbtipo_servico.ordem
               FROM 
                  tbtipo_servico
               WHERE
                  $filtro
               ORDER BY tbtipo_servico.id_servico
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_OBJ);  
   }

}