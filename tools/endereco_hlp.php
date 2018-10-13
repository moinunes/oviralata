<?php 
include_once 'conecta.php';

/**
*
* Classe  para auxiliar no tratamento do endereço
*    - Logradouro, bairro, municipio e UF 
*
*/

class Endereco_Hlp extends conecta {

   private $_filtro_cep;
   private $_filtro_nome_logradouro;
   private $_filtro_id_municipio;
   
   public function get_filtro_cep() {
      return $this->_filtro_cep;
   }

   public function set_filtro_cep( $valor ) {
      $this->_filtro_cep = $valor;
   }

   public function get_filtro_nome_logradouro() {
      return $this->_filtro_nome_logradouro;
   }

   public function set_filtro_nome_logradouro( $valor ) {
      $this->_filtro_nome_logradouro = $valor;
   }  


   public function get_filtro_id_municipio() {
      return $this->_filtro_id_municipio;
   }

   public function set_filtro_id_municipio( $valor ) {
      $this->_filtro_id_municipio = $valor;
   }
 
   function obter_municipios(&$dados) {
      $dados = array();
      $sql = " SELECT 
                  tbmunicipio.id_municipio,
                  tbmunicipio.nome_municipio,
                  tbmunicipio.id_uf
               FROM 
                  tbmunicipio     
                     JOIN tbuf ON (tbuf.id_uf=tbuf.id_uf)               
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();      
      $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $dados = $resultado;
   } // obter_municipios

   function obter_bairros(&$dados, $id_municipio=null) {
      $dados = array();
      $filtro='';
      if ($id_municipio) {
         $filtro=" WHERE tbbairro.id_municipio={$id_municipio}";
      }
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
      $dados = $resultado;
   } // obter_bairros

   function obter_endereco_por_cep() {
      $cep             = isset($_POST['filtro_cep'])          ? trim($_POST['filtro_cep'])          : '';
      $nome_logradouro = isset($_POST['filtro_logradouro'])   ? trim($_POST['filtro_logradouro'])   : '';
      $id_municipio    = isset($_POST['filtro_id_municipio']) ? trim($_POST['filtro_id_municipio']) : '';

      $this->set_filtro_cep($cep);
      $this->set_filtro_nome_logradouro($nome_logradouro);
      $this->set_filtro_id_municipio($id_municipio);

      $this->obter_dados($resultado);
      if ( count($resultado)>0 ) {
         $resultado= $resultado[0];
         $endereco['complemento'      ] = utf8_encode($resultado['complemento']);
         $endereco['local'            ] = utf8_encode($resultado['local']);
         $endereco['status'           ] = 'ok'; 
         $endereco['nome_logradouro'  ] = utf8_encode($resultado['nome_logradouro']);
         $endereco['nome_bairro'      ] = utf8_encode($resultado['nome_bairro']);
         $endereco['nome_municipio'   ] = utf8_encode($resultado['nome_municipio']);
         echo json_encode($endereco);
      } else {
         $resultado['status'] = 'CEP não encontrado.';               
         echo json_encode($resultado);
      }
   } // obter_endereco

   function obter_enderecos(&$resultado) {
      $this->obter_dados($resultado);
   } // obter_enderecos

   function obter_dados(&$dados) {      
      $filtro = "1=1";
      if ( $this->get_filtro_cep() != '' ) {
         $filtro .= " AND cep = '{$this->get_filtro_cep()}' ";
      }
      if ( $this->get_filtro_nome_logradouro() != '' ) {
         $filtro .= " AND nome_logradouro like '%{$this->get_filtro_nome_logradouro()}%' ";
      }
      if ( $this->get_filtro_id_municipio() != '' ) {
         $filtro .= " AND tbmunicipio.id_municipio = '{$this->get_filtro_id_municipio()}' ";
      }
      $sql = " SELECT 
                  tblogradouro.id_logradouro,
                  tblogradouro.cep,
                  tblogradouro.nome_logradouro,
                  tblogradouro.complemento,
                  tblogradouro.local,
                  tbbairro.nome_bairro,
                  tbmunicipio.nome_municipio,
                  tbuf.nome_uf                  
               FROM 
                  tblogradouro
                  JOIN tbbairro on (tbbairro.id_bairro=tblogradouro.id_bairro)
                     JOIN tbmunicipio on (tbmunicipio.id_municipio=tbbairro.id_municipio)
                        JOIN tbuf on (tbuf.id_uf=tbmunicipio.id_uf)               
               WHERE {$filtro}
             ";

             // teste
//             file_put_contents( __DIR__.'/teste.txt', '--------->'.$sql  );
             //////

      if ($filtro!='1=1') {             
         $stmt = $this->con->prepare( $sql );
         $stmt->execute();      
         $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
         $dados = $resultado;
      } else {
         $dados = array();
      }
   } // obter_dados

   function obter_id_logradouro( &$id_logradouro, $cep ) {
      $cep = trim($cep);
      $id_logradouro = 0;
      $sql = " SELECT 
                  tblogradouro.id_logradouro    
               FROM 
                  tblogradouro
               WHERE cep='{$cep}' ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();      
      $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
      if ( count($resultado)>0 ) {
         $id_logradouro = $resultado[0]->id_logradouro;
      }      
   } // obter_id_logradouro

} // Endereco_Hlp


if ( isset($_POST['acao']) && $_POST['acao'] != '' ) { 
   $instancia = new Endereco_Hlp();    
   switch ($_POST['acao']) {
      case 'obter_endereco_por_cep':   
         $instancia->obter_endereco_por_cep();
         break;
      
      default:
         # code...
         break;
   }
}