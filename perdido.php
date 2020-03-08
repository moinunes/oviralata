<?php
session_start();
include_once 'anuncio_hlp.php';
include_once 'cadastro/utils.php';
include 'carrossel_adotar.php';

$id_anuncio           = isset($_REQUEST['frm_id_anuncio'])           ? trim($_REQUEST['frm_id_anuncio'])           : '';
$comportamento        = isset($_REQUEST['comportamento'])            ? trim($_REQUEST['comportamento'])            : '';
$pagina               = isset($_REQUEST['frm_pagina'])               ? trim($_REQUEST['frm_pagina'])               : '1';
$filtro_palavra_chave = isset($_REQUEST['frm_filtro_palavra_chave']) ? trim($_REQUEST['frm_filtro_palavra_chave']) : '';

$filtro_codigo    = isset($_REQUEST['frm_filtro_codigo'])     ? trim($_REQUEST['frm_filtro_codigo'])      : '';

$anuncios = new Anuncio_hlp();
$anuncios->set_pagina_atual($pagina);
$anuncios->set_tipo_anuncio('petperdido');
$anuncios->set_filtro_palavra_chave($filtro_palavra_chave);
$anuncios->obter_anuncios($consulta_anuncio);

switch ( $comportamento ) {
   case 'mostrar_detalhes':
      header("location: mostrar_detalhes.php"."?frm_id_anuncio={$id_anuncio}&&frm_filtro_palavra_chave={$filtro_palavra_chave}" );
      break;
   
   default:
      # code...
      break;
}

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Adotar! Um ato de Amor. Mude sua vida, adote um amiguinho PET. Adoção e Doação de cães, gatos, etc... oViraLata.</title>
   <meta charset="utf-8">   
   <meta name="keywords"    content="adoçao de animais doação-cachorro-gato-oViraLata-Pet Doação de Pets-cão-gato-roedor-ração-doação de cão e gato, amor e respeito aos animais"/>
   <meta name="description" content="Seu amiguinho PET DESAPARECEU? O Site oViraLata quer ajudar VOCÊ a encontrar seu PET! Publique um anúncio gratuíto no site oViraLata e aumente as chances de encontrar o seu pet. Doação e Adoção de Cães e Gatos e outro animais de estimação... em todo Brasil">   
   <meta name="viewport"    content="width=device-width, initial-scale=1, maximum-scale=1">
  
   <!--  .css -->
   <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="./dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">     
   <link rel="stylesheet" href="./dist/css/estilo.css" >
   <link rel="stylesheet" href="./dist/fonts/fonts.css" >
   <link rel="stylesheet" href="./dist/css/estilo_slick.css" >
   <link rel="stylesheet" href="./dist/fSelect/fSelect.css" >
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick-theme.css"/>  

   <!--  .js -->
   <script src="dist/js/jquery-3.3.1.min.js"></script>
   <script src="./dist/jquery-ui/jquery-ui.min.js"></script>
   <script src="./dist/bootstrap-4.1/js/popper.min.js"></script>
   <script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>
   <script src="./dist/fSelect/fSelect.js"></script>
   <script src="./dist/jquery_mask/dist/jquery.mask.min.js"></script>
   <script type="text/javascript" src="./dist/slick/slick/slick.min.js"></script>

</head>   

<body>

   <header id="header">

    <style type="text/css">
   
    </style>
    
      <div class="container-fluid">
         <form id="frmAdotar" class="form-horizontal" action="adotar.php" method="POST" role="form">

            <input type="hidden" id="comportamento"  name="comportamento"  value = "<?=$comportamento?>">
            <input type="hidden" id="frm_id_anuncio" name="frm_id_anuncio" value = "<?=$id_anuncio?>">
            <input type="hidden" id="frm_pagina"     name="frm_pagina"     value = "<?=$pagina?>">
               
            <?php  
            include_once 'cabecalho.php';
            ?>
            
            <div class="row fundo_cinza_1">            
               <div class="col-12 altura_linha_1">
               </div>
            </div>

            <div class="row fundo_branco_1">            
               <div class="col-12 text-center">
                  <a href="perdido.php"><img src="./images/perdido.png"></a>  
               </div>   
            </div>

            <div class="row fundo_cinza_1">            
               <div class="col-12 altura_linha_1">
               </div>
            </div>

            <!-- filtros unico  -->
            <div class="row fundo_verde_claro">            
               <div class="col-12"><span class="font_preta_m">Buscar por palavra-chave:<br></span></div>
               <div class="col-12 col-sm-6 col-md-5 col-lg-3 col-xl-3 text-center">
                  <div class="input-group">
                     <input type="text" class="form-control form-control-sm" id='frm_filtro_palavra_chave' name='frm_filtro_palavra_chave' value="<?=$filtro_palavra_chave;?>" placeholder="Exemplo: cão são paulo sp" >
                     <div class="input-group-append">
                        <button type="button" class="btn btn_lupa1" id='btnBuscar' name='btnBuscar' onclick="submeter_form()"><img src="./images/lupa.png"></button>
                     </div>
                  </div>
               </div>
               <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="row fundo_branco_1">            
               <div class="col-12 altura_linha_1"></div>
            </div>

            <!-- desktop -->
            <div class="row text-center d-none d-lg-block">
              
              
               <div class="col-12 altura_linha_1"></div>
            </div>
            <div class="row d-none d-lg-block">                  
               <div class="col-12 text-center"></div>
            </div>

            <!-- mobile -->
            

            <div class="row fundo_branco_1">
               <div class="col-12 text-center">
                  <span class="font_cinza_p"><?="{$anuncios->total_registros} anúncios encontrados"; ?></span>
               </div>
            </div>
      
      
           

         </form>
      </div> <!-- container-fluid -->
   </header>  

   <!-- anuncios -->
   <form id="frmAdotar" class="form-horizontal" action="adotar.php" method="POST" role="form">      

   <div class="container" id='div_container'>

      <div class="row fundo_branco_1">
         <div class="col-md-12 altura_linha_1">
         </div>   
      </div>

      <!-- nessa linha - vai coluna 1 da esquerda 
                             coluna 2 da direita imprime os anuncios -->         
      <div class="row fundo_branco_1">         
         
         <!-- destaque -  ***lado esquerdo*** -->   
         <div class="col-lg-3 col-xl-3 d-none d-lg-block">
          
            <div class="row">
               <div class="col-12 text-center">
                  <?php  Utils::exibir_anuncio_aleatorio( 'perdido', 'Pet Desaparecido,<br> veja mais aqui!', '#ffffff'); ?>
               </div>
        
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 text">
                  <?php Utils::exibir_tipos_anuncio('desktop', 'Anuncie grátis:') ?>                 
               </div>
            
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 text-center fundo_laranja_0">
                  <?php  Utils::exibir_anuncio_aleatorio( 'doacao', 'Amiguinhos para Adoção,<br> veja mais aqui!'); ?>
               </div> 
            </div>   
            
         </div>

         <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" >

            <!-- banner - só para mobile --> 
            <div class="row fundo_branco">
               <div class="col-12 d-lg-none text-center">
                  <span class="font_azul_p"></span>
               </div>
            </div>


            <div class="row margem_pequena">
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12">
                  <span class="text">
                     Faça um <a href="cadastro/cad_login.php"><ins>cadastro gratuíto</ins></a>, e publique um anúncio do seu PET DESAPARECIDO com fotos e informações para contato.<br>
                  </span>
               </div>
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12 text-right">               
                  <span class="text-right">
                     <img src="./images/pata2.png" alt='PET DESAPARECIDO - O site oViraLata quer ajudar você a encontrar seu PET.' >
                  </span>
               </div>
            </div>

            <?php              
            $i=0;
            foreach ( $consulta_anuncio as $anuncio ) {
               $id_anuncio       = $anuncio->id_anuncio;
               $titulo           = $anuncio->titulo;
               $descricao        = trim(substr($anuncio->descricao,0,140)).'...&nbsp;<u>leia mais...</u>';
               $descricao_mobile = trim(substr($anuncio->descricao,0,44)).'...&nbsp;<u><strong>leia mais...</strong></u>';
               $municipio        = trim($anuncio->municipio).' - '.trim($anuncio->uf);                
            
               if ( $anuncio->codigo=='doacao' ) {
                  $tipo_fonte  = 'font_verde_g';
                  $tipo_fundo  = '';
                  $tipo_anuncio = 'Doação';
                  
               } else if ( $anuncio->codigo=='petperdido' ) {   
                  $tipo_fonte = 'font_vermelha_g';
                  $tipo_fundo = 'fundo_amarelo_1';
                  $tipo_anuncio = 'Perdido';
               
               }
               
               $dados = Utils::obter_array_fotos( $id_anuncio, $anuncio->data_cadastro, 'T' );
               
               $pasta_dc = 'fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
               if ( $dados->total_fotos>0 ) {
                  $nome_thumbnail = $pasta_dc.$dados->fotos[0];
               } else {
                  $nome_thumbnail = 'images/sem_foto1.png';
               }

               ?> 

               <!-- linha: 1  (foto + anuncio ) -->         
               <div class="row <?=$tipo_fundo?> shadow p-1 mb-1 rounded" > 
                  
                  <!-- coluna:1 - foto -->
                  <div class="col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 sem_margem" >
                     <a href="javascript:mostrar_detalhes(<?=$id_anuncio?>)"  >
                        <img src="<?=$nome_thumbnail?>" class='img-fluid' style='min-width:110px;min-height:110px;' >
                     </a>
                  </div>   

                  <!-- coluna:2 (dados do anúncio) -->
                  
                  <div class="col-7 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                     <a href="javascript:mostrar_detalhes(<?=$id_anuncio?>)"  >
                     <div class="row">   
                        <div class="col-md-12">
                           <span class="titulo_negrito_1"><?= $anuncio->titulo;?></span>
                        </div>
                     </div>   
                    
                     <div class="row">
                        <div class="col-12 d-none d-lg-block"> <!-- desktop -->
                           <span class="font_cinza_p"><img src="images/camera.png">&nbsp;<?= "{$dados->total_fotos}"?></span>
                           &nbsp;&nbsp;&nbsp;&nbsp;
                           <span class="font_preta_p"><?=substr($anuncio->bairro,0,30).', '.$municipio?></span>                           
                        </div>
                        <div class="col-12 d-lg-none"> <!-- mobile -->
                           <span class="font_cinza_p"><img src="images/camera.png">&nbsp;<?= "{$dados->total_fotos}"?></span>
                           &nbsp;&nbsp;
                           <span class="font_preta_p"><?=$municipio?></span>
                        </div>
                     </div>

                     <div class="row d-none d-lg-block">  <!-- desktop -->
                        <div class="col-12">
                           <span class="font_cinza_p"><blockquote><?=$descricao?></blockquote></span>
                        </div>
                     </div>

                     <div class="row">                         
                        <div class="col-5">
                           <span class="<?=$tipo_fonte?>"><?=$tipo_anuncio ?></span><br>
                        </div>                          
                        <div class="col-7">
                           <span class="font_cinza_p"><?= Utils::data_anuncio($anuncio->data_atualizacao)?></span><br>
                        </div> 
                     </div>

                     <?php
                     if ( $anuncio->exibir_tea != 'E' ) {
                        if ( $anuncio->tel_whatzapp !='' ) {?>
                           <div class="row">   
                              <div class="col-12">
                                 <img src="images/whatsapp.png" alt="<?=$anuncio->tel_whatzapp?>">
                                 <span class="font_cinza_m"><?="({$anuncio->ddd_whatzapp}) {$anuncio->tel_whatzapp}"?></span>
                              </div>         
                           </div>  
                        <?php
                        } elseif ( $anuncio->tel_celular !='' ) {?>
                           <div class="row">   
                              <div class="col-12">
                                 <img src="images/cel.png" alt="<?=$anuncio->tel_celular?>">
                                 <span class="font_cinza_m"><?="({$anuncio->ddd_celular}) {$anuncio->tel_celular}"?></span>
                              </div>         
                           </div>
                        <?php   
                        }

                     } else {?>
                        <div class="row">   
                           <div class="col-12">
                              <span class="font_azul_p"><?="E-mail: {$anuncio->email}"?></span>
                           </div>         
                        </div>  
                     <?php   
                     }?>

                     <div class="row d-lg-none"> <!-- mobile -->                      
                        <div class="col-12">
                           <span class="font_cinza_p"><blockquote><?=$descricao_mobile?></blockquote></span>
                        </div>
                     </div>

                     </a>
                  
                  </div>                

               </div>
             
               <div class="row fundo_branco_1">
                  <div class="col-md-12 altura_linha_1"></div>   
                  <div class="col-md-12 altura_linha_2"></div>   
               </div>

               <!-- anuncios - adsense -->
               <?php
               if ($i==0 ) {?>
                  <div class="row text-center">
                     <div class="col-12 altura_linha_2"></div>
                     <div class="col-12 tit_0">Publicidade</div>
                     <div class="col-12 text-center" >                  
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-format="fluid"
                             data-ad-layout-key="-fb+5w+4e-db+86"
                             data-ad-client="ca-pub-2582645504069233"
                             data-ad-slot="8484848734"></ins>
                        <script>
                             (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                     </div> 
                     <div class="col-12 altura_linha_2"></div>                    
                  </div>

                  <div class="row  fundo_branco_1">
                     <div class="col-md-12 altura_linha_2"></div>
                  </div>  
                  
               <?php
               }

               if ( $i==5 ) {?>                  
                  <div class="row text-center">
                     <div class="col-12 altura_linha_2"></div>
                     <div class="col-12 tit_0">Publicidade</div>
                     <div class="col-12 text-center"> 
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-format="fluid"
                             data-ad-layout-key="-fb+5w+4e-db+86"
                             data-ad-client="ca-pub-2582645504069233"
                             data-ad-slot="8484848734"></ins>
                        <script>
                             (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                     </div>
                  </div>

                   <div class="row  fundo_branco_1">
                     <div class="col-md-12 altura_linha_2"></div>
                  </div> 

               <?php
               }

               if ( $i==9 || $i==15 ) {?>                  
                  <div class="row text-center">
                     <div class="col-12 altura_linha_2"></div>
                     <div class="col-12 altura_linha_2"></div>
                     <div class="col-12 tit_0">Publicidade</div>
                     <div class="col-12 text-center"> 
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-format="fluid"
                             data-ad-layout-key="-fb+5w+4e-db+86"
                             data-ad-client="ca-pub-2582645504069233"
                             data-ad-slot="8416737411"></ins>
                        <script>
                             (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                     </div>                     
                     <div class="col-12 altura_linha_2"></div>
                     <div class="col-12 altura_linha_2"></div>
                  </div> 
               <?php
               }

               $i++;   
            }
            ?>  

         </div>

         <!-- destaque - lado Direito -->   
         <div class="col-lg-3 col-xl-3 d-none d-lg-block">
            <div class="row text-center">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 tit_0">Publicidade</div>
            </div>            
            <div class="row shadow p-1 mb-3 bg-white rounded text-center" style='margin:3px'>                          
               <div class="col-12 text-right">
                  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- grafico_vertical_2 -->
                  <ins class="adsbygoogle"
                       style="display:block"
                       data-ad-client="ca-pub-2582645504069233"
                       data-ad-slot="1529569902"
                       data-ad-format="auto"
                       data-full-width-responsive="true"></ins>
                  <script>
                       (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
               </div>
            </div>
         </div>

      </div>
      <!-- fim dos registros(anuncios) -->

      <div class="row">         
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12">
            <br>
            <?php 
            Utils::paginador( $anuncios->qtd_paginas, $anuncios->get_pagina_atual() );
            ?> 
         </div>
         <div class="col-12 altura_linha_2"></div>
      </div>

      <div class="row">
         <div class="col-12">
            <?php  
            include_once 'rodape_0.php';
            ?>
         </div>
      </div>

      <?php  
      include_once 'rodape_1.php';
      ?>
 
   </div> <!-- /container -->
   </form>

   
   <div class="col-12 altura_linha_2">
      <br>
   </div>

<?php
?>

<script type="text/javascript">

   function submeter_form( pagina = '1') {
      $('#comportamento').val( 'submeter_form' );
      $('#frm_pagina').val( pagina );
      document.forms['frmAdotar'].submit();
   }

   function mostrar_detalhes(id) {
      $('#comportamento').val( 'mostrar_detalhes' );
      $('#frm_id_anuncio').val( id );

      document.forms['frmAdotar'].submit();
   }   


   $( document ).ready(function() {      

     

   });


</script>   

</body>

</html>
