<?php
include_once 'conecta.php';

/**
*
* Essa classe é generica para o sistema de imobiliaria
* 
*/         

class Utils {
   
   /**
   *
   * Configura o paginador
   *
   */ 
   static public function configura_paginador( $total_registros, $pagina_atual ) {
      $exibir        = 10;
      $do            = new StdClass();
      $pagina_atual  = ( $pagina_atual != '' ) ? $pagina_atual : 1;
      $qtd_paginas   = ceil(($total_registros/$exibir));
      $inicio_exibir = ($exibir * $pagina_atual) - $exibir;
      
      $do->pagina_atual  = $pagina_atual;
      $do->qtd_paginas   = $qtd_paginas;      
      $do->exibir        = $exibir;
      $do->inicio_exibir = $inicio_exibir;      
      return $do;
   } // configura_paginador

   /**
   *
   * Monta o paginador
   *
   */ 
   static public function paginador( $qtd_paginas, $pagina_atual ) {?>
      <div id="paginacao" class="text-center">   
         <?php
         $link='';
         $links_left  = $pagina_atual-3;
         $links_right = $pagina_atual+3;         
         $pagina_anterior = (($pagina_atual - 1) <= 0) ? "Anterior" : '<a href="javascript:submeter_form('.($pagina_atual - 1).')">Anterior</a>';         
         $pagina_proximo = (($pagina_atual + 1) > $qtd_paginas) ? "Próxima" : '<a href="javascript:submeter_form('.($pagina_atual+1).')">Próxima</a>';
         ?>
         <span id="anterior"><?=$pagina_anterior?></span>
         <?php
         for( $i = 1; $i <= $qtd_paginas; $i++ ) {
            if ( $i == $pagina_atual ) {
               echo '<span class="btn btn_paginador2">'.$i.'</span>';
            } else {
                if ($i>$links_left && $i<$pagina_atual){
                  echo '<a class="btn btn_paginador1" href="javascript:submeter_form('.$i.')">'.$i.'</a>';
               }
               if ($i>$pagina_atual && $i<$links_right){
                  echo '<a class="btn btn_paginador1" href="javascript:submeter_form('.$i.')">'.$i.'</a>';
               }   
            }
         }?>         
         <span id="proxima"><?=$pagina_proximo?></span>      
      </div>
   <?php
   } // paginador


   public function exibir_data_extenso() {
      setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
      date_default_timezone_set('America/Sao_Paulo');      
      if ( $_SERVER['SERVER_NAME'] =='localhost' ) {
         echo  strftime('%A, %d de %B/%Y', strtotime('today'));
      } else {
         echo utf8_encode( strftime('%A, %d, de %B/%Y',strtotime('today')) );
      }
   } // exibir_data_extenso


}