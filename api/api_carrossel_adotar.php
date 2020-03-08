<?php
   include_once '../cadastro/conecta.php';
   include_once '../cadastro/utils.php';
   include_once 'api_utils.php';
?>

   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   <link rel="stylesheet" href="../api/api_estilo_slick.css" >
   <link rel="stylesheet" href="../dist/fonts/fonts.css" >
   <link rel="stylesheet" type="text/css" href="../dist/slick/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="../dist/slick/slick/slick-theme.css"/> 

   <script type="text/javascript" src="../dist/slick/slick/slick.min.js"></script>

<?php

/**
*
* Essa classe exibe Carrossel ADOTAR para o BLOG
* 
*/         

class Carrossel_Adotar {

   function __construct() {
      $this->total_anuncios = 30; // default
      Utils:: obter_mensagens( $this->mensagem_1, $this->mensagem_2 );
   }

   public function executar() {
      Utils::obter_anuncios($this->anuncios, $this->total_anuncios );
      $this->exibir_carrossel();
   }

   private function exibir_carrossel() {?>
      <div class="row margem_pequena">
         <div>         
            <?php 
               $this->montar_carrossel();
               $this->exibir_mensagens();
            ?>
         </div>
      </div>
   <?php
   }

   private function montar_carrossel() {?>
      
      <div class="carousel" id='carousel'>
         <?php
         foreach ($this->anuncios as $anuncio) {
            $nome_foto = Api_Utils::obter_uma_foto_grande( $anuncio->id_anuncio, $anuncio->data_cadastro );
            $pasta_dc = '../fotos/';
            $pasta_dc = $pasta_dc.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
            $thumbnail = $pasta_dc.$nome_foto;
            ?>            
            <div>               
               <span><img src="<?=$thumbnail?>" alt="<?=$anuncio->titulo?>" /></span>
               <div style="text-align:center;">
                  <span  class="tit_2"><?=$anuncio->titulo?><br></span>
                  <span><?=$anuncio->bairro.' '.$anuncio->municipio.' '.$anuncio->uf?><br></span>
                  <span><?php $this->exibir_telefone($anuncio)?></span>
                  <a href="../adotar.php">
                     <span class="font_azul_g">
                        <br>
                        <ins>Veja mais aqui...</ins>
                     </span>
                  </a>   
                  <br><br>
               </div>
            </div>
         <?php      
         }?>
      </div>   
   <?php
   } // montar_carrossel
   
   private function exibir_telefone($anuncio) {
      if ( $anuncio->exibir_tea=='T' || $anuncio->exibir_tea=='A' ) {
         $display_celular  =  $anuncio->tel_celular  == '' ? 'display:none;' : '';
         $display_whatzapp =  $anuncio->tel_whatzapp == '' ? 'display:none;' : '';
         $display_fixo     =  $anuncio->tel_fixo     == '' ? 'display:none;' : '';       
         ?>
         <div class="fundo_laranja_0">
            <div style="<?=$display_celular?>" >
               <span class="font_courier_p">Celular.:</span>
               <span class="text">(<?=$anuncio->ddd_celular?>) <?=$anuncio->tel_celular?></span>
            </div>         
            <div style="<?=$display_whatzapp?>" >   
               <span class="font_courier_p">WhatzApp:</span>
               <span class="text">(<?=$anuncio->ddd_whatzapp?>) <?=$anuncio->tel_whatzapp?></span>
            </div>         
            <div style="<?=$display_fixo?>" >
               <span class="font_courier_p">Fixo...:</span>
                <span class="text">(<?=$anuncio->ddd_fixo?>) <?=$anuncio->tel_fixo?></span>
            </div>
         </div>                             
      <?php
      }      
   } // exibir_telefone 

   private function exibir_mensagens() {?>
      <div class="alert">
         <h5><?=$this->mensagem_1?></h5>
      </div>                
   <?php
   } // exibir_telefone   

}
?>

 <script>

      $(document).ready(function(){      
         $('#carousel').slick({
           infinite: true,
           speed: 500,
           adaptiveHeight: true,    
           fade: true,
         });
         $('.carousel').slick();
      });
   </script>

