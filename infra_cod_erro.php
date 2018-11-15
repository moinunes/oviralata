<?php

/**
 * Classe que auxilia no tratamento de Erros
 */

class Infra_Cod_Erro {

   public $cod_erro;

   public function __construct() {
      $this->cod_erro = array();
   }
   
   public function obter_erros( $erro_a_ser_tratado ) {      
      $erro = new StdClass();      
      if ( strpos( $erro_a_ser_tratado, '1451' ) !== FALSE ) {        
         $erro->cod_erro  = 1451;
         $erro->descricao = 'O registro está sendo usado por outra tabela';
         $this->cod_erro[] = $erro;
      }
      if ( strpos( $erro_a_ser_tratado, '1062' ) !== FALSE ) {
         $erro->cod_erro  = 1062;
         $erro->descricao = 'O registro já existe';
         $this->cod_erro[] = $erro;         
      }
      $this->tratar_erros( $erros );
      return $erros;
   } // obter_erros

   public function tratar_erros( &$erros ) {
      $erros = null;      
      foreach ($this->cod_erro as $item ) {
         $erros .= $item->descricao.'<br>';      
      }
   } // tratar_erros

} // Infra_Cod_Erro