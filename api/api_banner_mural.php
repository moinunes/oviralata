<?php
include_once '../cadastro/utils.php';

//.. obtém anúncio - DOAÇÂO - aleatório  
$anuncio_thumbnail = 'images/sem_foto1.png';
Utils::obter_anuncios($anuncio,1);
if ( $anuncio != '' ) {
   $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
   $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
   if ( $dados->total_fotos>0 ) {
      $anuncio_thumbnail = $pasta_dc.$dados->fotos[0];
   }
}

//.. obtém anúncio - PET PERDIDO - aleatório 
$perdido_thumbnail = 'images/sem_foto1.png';
Utils::obter_pet_perdido($anuncio,1);
if ( $anuncio != '' ) {
   $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
   $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
   if ( $dados->total_fotos>0 ) {
      $perdido_thumbnail = $pasta_dc.$dados->fotos[0];
   }
}

                  
?>

<div class="wrap contentclass" role="document">

   <div class="row">
      <div class="col-auto">
         <a class="font_azul_m" href="../adotar.php" role="button">Adote um PET<br>
          <img src="<?=$anuncio_thumbnail ?>" class='img-fluid img-thumbnail' >
          </a>
      </div>
     
    
      <div class="col-4">
         <a class="font_azul_m" href="../perdido.php" role="button">Pet Desaparecido<br>
          <img src="<?=$perdido_thumbnail ?>" class='img-fluid img-thumbnail' >
         </a>
      </div>
   </div>

</div>
