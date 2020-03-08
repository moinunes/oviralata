<?php
include_once 'cadastro/conecta.php';
include_once 'cadastro/utils.php';

/**
*
* Essa classe monta o carrossel DESAPARECIDO
* 
*/         

class Carrossel_Desaparecido {

   public $id_carousel = 'padrao';
   public $cor_fundo   = 'fundo_branco';
   public $exibir_btn_detalhes='N';

   function __construct() {
      $this->total_anuncios = 2; // default
   }

   public function executar() {
      Utils::obter_pet_perdido( $this->anuncios, $this->total_anuncios );
      $this->exibir_carrossel();
   }

   private function exibir_carrossel() {?>
      <div class="row">
         <div class="col-12 text-center">   
            <span class="font_vermelha_g">Amiguinhos Desaparecidos</span>  
         </div>
      </div>
      <div class="row <?=$this->cor_fundo?> margem_pequena">
         <div class="col-12 text center">         
            <div id="<?=$this->id_carousel?>" class="carousel slide carousel-fade" data-ride="carousel">
               <!-- The slideshow -->
               <div class="carousel-inner text-center">
                   <?php
                   $this->montar_carrossel();?>                   
               </div>
               <!-- Left and right controls -->
               <a class="carousel-control-prev" href="#<?=$this->id_carousel?>" data-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
               </a>
               <a class="carousel-control-next" href="#<?=$this->id_carousel?>" data-slide="next">
                  <span class="carousel-control-next-icon"></span>
               </a>            
            </div>
         </div>
         <div class="col-12 altura_linha_2"><br></div>
      </div>
   <?php
   } 

   private function montar_carrossel() {
      $active='active';
      foreach ($this->anuncios as $anuncio) {
         //$nome_foto = Utils::obter_uma_foto_grande( $anuncio->id_anuncio, $anuncio->data_cadastro );
         $nome_foto = Utils::obter_thumbnail( $anuncio->id_anuncio, $anuncio->data_cadastro );

         $pasta_dc = 'fotos/';
         $pasta_dc = $pasta_dc.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
         $thumbnail = $pasta_dc.$nome_foto;
         ?>
         <div class="carousel-item <?=$active?>">
            <img src="<?=$thumbnail?>" alt="<?=$anuncio->titulo?>">
            <br>
            <span class="destaque_1"><?=$anuncio->titulo?></span><br>
            <span><?=$anuncio->bairro.' '.$anuncio->municipio.' '.$anuncio->uf?><br></span>
            <?php $this->exibir_telefone($anuncio);
            if ( $this->exibir_btn_detalhes=='S' ) {?>
               <div class="text-right">
                  <span><a href="perdido.php"><ins>Veja em Detalhes...</ins></a><br><br></span>
               </div>
            <?php
            }?>
         </div> 
         <?php
         $active='';
      }
   } 
   
   private function exibir_telefone($anuncio) {
      if ( $anuncio->exibir_tea=='T' || $anuncio->exibir_tea=='A' ) {
         $display_celular  =  $anuncio->tel_celular  == '' ? 'display:none;' : '';
         $display_whatzapp =  $anuncio->tel_whatzapp == '' ? 'display:none;' : '';
         $display_fixo     =  $anuncio->tel_fixo     == '' ? 'display:none;' : '';       
         ?>
         <div style="<?=$display_celular?>" >
            <img src="./images/cel.png" alt="o vira lata - adote um pet, cachorro, gato ou outro animal de estimação">
            <span class="text">(<?=$anuncio->ddd_celular?>) <?=$anuncio->tel_celular?></span>
         </div>         
         <div style="<?=$display_whatzapp?>" >   
            <img src="./images/whatsapp.png" alt="<?=$anuncio->tel_whatzapp?>">
            <span class="text">(<?=$anuncio->ddd_whatzapp?>) <?=$anuncio->tel_whatzapp?></span>
         </div>         
         <div style="<?=$display_fixo?>" >
            <img src="./images/fixo.png" alt="respeito e amor aos animais">
             <span class="text">(<?=$anuncio->ddd_fixo?>) <?=$anuncio->tel_fixo?></span>
         </div>                             
      <?php
      }      
   } // exibir_telefone
    
}