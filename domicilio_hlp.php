<?php 
include_once 'conecta.php';

/**
*
* Classe  para auxiliar no tratamento do domicilio
*    
*
*/

class Domicilio_Hlp extends conecta {

   private $_id_domicilio;
   
   public function get_id_domicilio() {
      return $this->_id_domicilio;
   }

   public function set_id_domicilio( $valor ) {
      $this->_id_domiciliop = $valor;
   }
   
   function obter_domicilio( &$dados, $id_domicilio) {
      $sql = " SELECT
                  tbdomicilio.id_domicilio,
                  tbdomicilio.numero,
                  tbdomicilio.complemento,
                  tblogradouro.id_logradouro,
                  tblogradouro.cep,
                  tblogradouro.nome_logradouro,
                  tblogradouro.complemento||' | '|| tblogradouro.local AS local,
                  tbbairro.nome_bairro,
                  tbmunicipio.nome_municipio,
                  tbuf.nome_uf      
               FROM 
                  tbdomicilio
                     JOIN tblogradouro on (tblogradouro.id_logradouro=tbdomicilio.id_logradouro)
                        JOIN tbbairro on (tbbairro.id_bairro=tblogradouro.id_bairro)
                           JOIN tbmunicipio on (tbmunicipio.id_municipio=tbbairro.id_municipio)
                              JOIN tbuf on (tbuf.id_uf=tbmunicipio.id_uf)               
               WHERE tbdomicilio.id_domicilio={$id_domicilio}
             ";

             // teste
//             file_put_contents( __DIR__.'/teste.txt', '--------->'.$sql  );
                         
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();      
      $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $dados = (object)$resultado[0];
   } // obter_domicilio

} // Domicilio_Hlp