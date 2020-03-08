<link rel="stylesheet" href="../dist/css/estilo.css" >
<?php
include_once '../cadastro/utils.php';

//.. obtém anúncio - DOAÇÂO - aleatório  
$anuncio_thumbnail_1 = 'images/sem_foto1.png';
Utils::obter_anuncios($anuncio,1);
if ( $anuncio != '' ) {
   $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
   $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
   if ( $dados->total_fotos>0 ) {
      $anuncio_thumbnail_1 = $pasta_dc.$dados->fotos[0];
   }
}

//.. obtém anúncio - DOAÇÂO - aleatório  
$anuncio_thumbnail_2 = 'images/sem_foto1.png';
Utils::obter_anuncios($anuncio,1);
if ( $anuncio != '' ) {
   $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
   $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
   if ( $dados->total_fotos>0 ) {
      $anuncio_thumbnail_2 = $pasta_dc.$dados->fotos[0];
   }
}

//.. obtém anúncio - DOAÇÂO - aleatório  
$anuncio_thumbnail_3 = 'images/sem_foto1.png';
Utils::obter_anuncios($anuncio,1);
//Utils::Dbga_Abort($anuncio);
if ( $anuncio != '' ) {
   $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
   $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
   if ( $dados->total_fotos>0 ) {
      $anuncio_thumbnail_3 = $pasta_dc.$dados->fotos[0];
   }
}
                
?>

<div class="wrap contentclass" role="document">

   <div class="row">

      <div class="col-auto text-center">         
          <span class='destaque_3'>Adote um amiguinho PET</span><br>
          <span class='titulo_1'><?=$anuncio->titulo;?></span><br>
          <span class='font_cinza_m'><?=$anuncio->descricao;?></span><br>
          
          <a class="font_azul_m" href="../adotar.php" role="button">
            <img src="<?=$anuncio_thumbnail_1 ?>" class='img-fluid img-thumbnail' >
            <br> Veja mais...<br><br>
         </a>
      </div>

      
      </div>

   </div>
 

</div>
