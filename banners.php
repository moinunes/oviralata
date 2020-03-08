<?php
//.. obtém anúncio - DOAÇÂO - aleatório  
$anuncio_thumbnail = 'images/sem_foto1.png';
Utils::obter_anuncios($anuncio,1);
if ( $anuncio != '' ) {
   $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
   $pasta_dc = 'fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
   if ( $dados->total_fotos>0 ) {
      $anuncio_thumbnail = $pasta_dc.$dados->fotos[0];
   }
}

//.. obtém anúncio - PET PERDIDO - aleatório 
$perdido_thumbnail = 'images/sem_foto1.png';
Utils::obter_pet_perdido($anuncio,1);
if ( $anuncio != '' ) {
   $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
   $pasta_dc = 'fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
   if ( $dados->total_fotos>0 ) {
      $perdido_thumbnail = $pasta_dc.$dados->fotos[0];
   }
}                
?>

<div class="row">
   <div class="col-4 text-center">
      <a class="font_azul_m" href="adotar.php" role="button">Adote<br>
       <img src="<?=$anuncio_thumbnail ?>" class='img-fluid img-thumbnail' >
       </a>
       <br><br>
   </div>
  
 
   <div class="col-4 text-center">
      <a class="font_azul_m" href="perdido.php" role="button">Perdido<br>
       <img src="<?=$perdido_thumbnail ?>" class='img-fluid img-thumbnail' >
      </a>
      <br>
   </div>
</div>

<div class="row">            
   <div class="col-12 altura_linha_2"></div>
</div>

<div class="row">            
   <div class="col-12 altura_linha_2"></div>
</div>


<div class="row">            
   <div class="col-12 altura_linha_2">
      <br><br>
   </div>
</div>