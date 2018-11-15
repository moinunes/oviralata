<?php 
include_once 'conecta.php';
include_once 'infra_cod_erro.php';

/**
 * Classe que efetua o cadastro de Tipo de Imóvel
 */

class Cadastro_Hlp_Tipo extends conecta {

   private $id_tipo_imovel;
   private $tipo_imovel; 
   
   public $cod_erro;

   public function __construct() {
      parent::__construct();
      $this->cod_erro = null;
   }

   public function get_id_tipo_imovel() {
      return $this->id_tipo_imovel;
   }

   public function set_id_tipo_imovel( $valor ) {
      $this->id_tipo_imovel = $valor;
   }

   public function get_tipo_imovel() {
      return $this->tipo_imovel;
   }

   public function set_tipo_imovel( $valor ) {
      $this->tipo_imovel = $valor;
   }  

   /**
    * Inclui o Tipo de Imóvel
    */
   function incluir() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $campos = " tipo_imovel";
         $sql = "INSERT INTO tbtipo_imovel({$campos})
                 VALUES ( :tipo_imovel)";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':tipo_imovel', utf8_decode($this->get_tipo_imovel()), PDO::PARAM_STR );
         $stmt->execute();
         $id_tipo_movel = $this->con->lastInsertId();
      } catch(PDOException $e) {         
         $cod_erro = new Infra_Cod_Erro();
         $this->cod_erro = $cod_erro->obter_erros( $e->getMessage() );       
      }
      return null;
   } // incluir

   /**
    * Alterar o Tipo de Imóvel
    */
   function alterar() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbtipo_imovel
                  SET tipo_imovel ='{$this->get_tipo_imovel()}'
                  WHERE id_tipo_imovel={$this->get_id_tipo_imovel()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }
      return null;
   } // alterar
   
   /**
    * Excluir o Tipo de Imóvel
    */
   function excluir() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " DELETE FROM tbtipo_imovel                  
                  WHERE id_tipo_imovel={$this->get_id_tipo_imovel()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

      } catch(PDOException $e) {
         $cod_erro = new Infra_Cod_Erro();
         $this->cod_erro = $cod_erro->obter_erros( $e->getMessage() );
      }
   } // excluir
   
   function obter_tipos( &$tipos ) {
      $filtro = "1=1";
      if ( $this->get_id_tipo_imovel() != '' ) {
         $filtro .= " AND tbtipo_imovel.id_tipo_imovel = ".$this->get_id_tipo_imovel();
      }
      if ( $this->get_tipo_imovel() != '' ) {
         $filtro .= " AND tbtipo_imovel.tipo_imovel like '%".$this->get_tipo_imovel()."%'";
      }
      $sql = " SELECT 
                  tbtipo_imovel.id_tipo_imovel,
                  tbtipo_imovel.tipo_imovel
               FROM 
                  tbtipo_imovel
               WHERE
                  $filtro
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tipos = $stmt->fetchAll(PDO::FETCH_CLASS);      
   } // obter_tipos

} // Cadastro_Hlp_Tipo
