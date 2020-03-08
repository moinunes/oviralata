<?php

header('Cache-Control: no cache'); //.. corrigi o erro: ERR_CACHE_MISS

/**
*
* Essa classe é generica para os programas da pasta /api
* 
*/         
class Api_Utils {

   /**
   *
   * Obtém apenas 1 foto grande do anúncio
   *
   */   
   static public function obter_uma_foto_grande( $id_anuncio, $data_cadastro ) {
      $dados       = new StdClass();
      $array_fotos = array();
      $dir_fotos   = str_replace( 'api','fotos/', dirname(__FILE__) );
      $pasta_dc    = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      $fotos       = glob($pasta_dc.$id_anuncio.'_'."*");         
      foreach ( $fotos as $arquivo ) {
         $nome_foto = basename($arquivo);
         $pos       = strpos( $nome_foto, $id_anuncio.'_t_' );
         if ( $pos!==0 ) {
            break;
         }
      }
      return $nome_foto;      
   } // obter_uma_foto_grande

} // Api_Utils
