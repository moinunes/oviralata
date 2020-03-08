<?php 
include_once 'conecta.php';
include_once 'utils.php';

/**
*
* Classe  para auxiliar no tratamento do endereços
*
*/


class Endereco_Hlp extends conecta {

   private $_filtro_cep;
   private $_filtro_logradouro;
   private $_filtro_municipio;
   private $_filtro_id_logradouro;
   
   public function set_filtro_cep( $valor ) {
      $this->_filtro_cep = $valor;
   }
   
   public function get_filtro_cep() {
      return $this->_filtro_cep;
   }

   public function set_filtro_logradouro( $valor ) {
      $this->_filtro_logradouro = $valor;
   }

   public function get_filtro_logradouro() {
      return $this->_filtro_logradouro;
   }

   public function get_filtro_id_logradouro() {
      return $this->_filtro_id_logradouro;
   }

   public function set_filtro_id_logradouro( $valor ) {
      $this->_filtro_id_logradouro = $valor;
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

   function obter_endereco_cep( $cep ) {
      $cep = str_replace('-', '', $cep );
      $resultado = '';
      $endereco  = array();
      $sql = " SELECT 
                  tblogradouro.id_logradouro,
                  tblogradouro.cep,
                  tblogradouro.ddd,             
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco
                FROM 
                  tblogradouro              
               WHERE tblogradouro.cep='{$cep}'
             ";             
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();      
      $resultado =  $stmt->fetch(PDO::FETCH_OBJ);
      if ( $resultado ) {
         $endereco['status'       ] = 'ok'; 
         $endereco['endereco'     ] = $resultado->endereco;
         $endereco['id_logradouro'] = $resultado->id_logradouro;
         $endereco['cep'          ] = $resultado->cep;
         $endereco['ddd'          ] = $resultado->ddd;
         echo json_encode($endereco);
      } else {
         $endereco['status'] = 'CEP inválido.';               
         echo json_encode($endereco);
      }
   } // obter_endereco

   
   function obter_enderecos(&$dados) {
      $todos_filtros = false;
      $uf            = trim($this->get_filtro_uf());
      $municipio     = trim($this->get_filtro_municipio());
      $logradouro    = trim($this->get_filtro_logradouro());
      
      if ( $uf!='' && $municipio!='' && $logradouro!='' ) {
         $todos_filtros = true;
      }

      if ( $todos_filtros ) {
         $filtro  = " uf = '{$uf}' AND ";
         $filtro .= " municipio like '%{$municipio}%' AND ";
         $filtro .= " logradouro like '%{$logradouro}%' ";
         $sql = " SELECT 
                     id_logradouro,
                     cep,
                     logradouro,
                     complemento,
                     bairro,
                     municipio,
                     uf                  
                  FROM 
                     tblogradouro             
                  WHERE {$filtro}
                  LIMIT 20
                ";
         $stmt = $this->con->prepare( $sql );
         $stmt->execute();      
         $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
         $dados     = $resultado;
      } else {
         $dados = array();
      }
   } // obter_enderecos
 
} // Endereco_Hlp


if ( isset( $_POST['acao']) && $_POST['acao'] != '' ) {
   $instancia = new Endereco_Hlp();    

   switch ($_POST['acao']) {
      case 'obter_endereco_cep':
         $cep = $_POST['cep'];    
         $instancia->obter_endereco_cep($cep);
         break;
      
      default:
         # code...
         break;
   }

}