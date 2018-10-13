<?php
include_once 'tools/conecta.php';

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
   public function configura_paginador( $total_registros, $pagina_atual ) {
      $exibir        = 5;
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
   public function paginador( $qtd_paginas, $pagina_atual ) {?>
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


}