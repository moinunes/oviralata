<?php
session_start();
include_once 'servico_hlp.php';
include_once 'cadastro/utils.php';
include 'carrossel_servico.php';
include 'carrossel_desaparecido.php';

if ( isset($_REQUEST['comportamento']) ) { 
   if ( $_REQUEST['comportamento'] == 'exibir_galeria' ) {
      $_SESSION['servico_lista_ou_galeria'] = 'G';
   } else {
      $_SESSION['servico_lista_ou_galeria'] = 'L';
   }
} else {
   $_SESSION['servico_lista_ou_galeria']='L';
}

if ( isset($_SESSION['servico_lista_ou_galeria']) ) {
   if ( $_SESSION['servico_lista_ou_galeria'] == 'G' ) {
      header("Location: servico_galeria.php");
   }
}

$id_servico           = isset($_REQUEST['frm_id_servico'])           ? trim($_REQUEST['frm_id_servico'])           : '';
$comportamento        = isset($_REQUEST['comportamento'])            ? trim($_REQUEST['comportamento'])            : '';
$pagina               = isset($_REQUEST['frm_pagina'])               ? trim($_REQUEST['frm_pagina'])               : '1';
$filtro_palavra_chave = isset($_REQUEST['frm_filtro_palavra_chave']) ? trim($_REQUEST['frm_filtro_palavra_chave']) : '';

$filtro_codigo    = isset($_REQUEST['frm_filtro_codigo'])     ? trim($_REQUEST['frm_filtro_codigo'])      : '';

$anuncios = new Servico_Hlp();
$anuncios->set_pagina_atual($pagina);
$anuncios->set_filtro_palavra_chave($filtro_palavra_chave);
$anuncios->obter_servicos($consulta_servico);

Utils:: obter_mensagens( $mensagem_1, $mensagem_2 );

$lista_galeria = 'L';

switch ( $comportamento ) {
   case 'mostrar_detalhes_servico':
      header("location: mostrar_detalhes_servico.php"."?frm_id_servico={$id_servico}" );
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
   <meta name="description" content="Portal de anúncios PET - Adoção - Doação - PET DESAPARECIDO - ADOTAR um cão, um gatinho ou outro pet, é um ato de amor e respeito aos animais. Encontre seu novo amiguingo pet aqui no site. oViraLata tem como objetivo ajudar na adoção pet e a encontrar PETs DESAPARECIDOS em todo Brasil">   
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
         <form id="frmServico" class="form-horizontal" action="servico.php" method="POST" role="form">

            <input type="hidden" id="comportamento"  name="comportamento"  value = "<?=$comportamento?>">
            <input type="hidden" id="frm_id_servico" name="frm_id_servico" value = "<?=$id_servico?>">
            <input type="hidden" id="frm_pagina"     name="frm_pagina"     value = "<?=$pagina?>">
               
            <?php  
            include_once 'cabecalho.php';
            ?>
            
            <div class="row">            
               <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="row fundo_branco_1">            
               <div class="col-12 text-center">
                  <a href="servico.php"><img src="./images/servico.png" alt='Serviços pet, produtos pet, raçao, adestrador, passeador de animais'></a>  
               </div>   
            </div>

             <div class="row fundo_cinza_1">            
               <div class="col-12 altura_linha_1">
               </div>
            </div>

            <div class="row fundo_laranja_1">            
               <div class="col-12 text-center">                        
                  <input type="radio" id="frm_lista_galeria_l" name="frm_lista_galeria" value="L" onchange="exibir_lista_ou_galeria(this)" checked /><span class="text">&nbsp;Lista</span>
                  <input type="radio" id="frm_lista_galeria_g" name="frm_lista_galeria" value="G" onchange="exibir_lista_ou_galeria(this)"         /><span class="text">&nbsp;Galeria</span>
               </div>               
            </div>

            <!-- filtros unico  -->
            <div class="row fundo_verde_claro text">            
               <div class="col-12"><span class="font_preta_m">Buscar por palavra-chave:<br></span></div>
               <div class="col-12 text-center">
                  <div class="input-group">
                     <input type="text" class="form-control form-control-sm" id='frm_filtro_palavra_chave' name='frm_filtro_palavra_chave' value="<?=$filtro_palavra_chave;?>" placeholder="" >
                     <div class="input-group-append">
                        <button type="button" class="btn btn_lupa1" id='btnBuscar' name='btnBuscar' onclick="submeter_form()"><img src="./images/lupa.png" alt='procurar pet, buscar pet'></button>
                     </div>
                  </div>
               </div>
               <div class="col-12 altura_linha_1"></div>
            </div>
            <div class="row fundo_branco_1">
               <div class="col-12 text-center">
                  <span class="font_cinza_p"><?=$anuncios->total_registros ?> anúncios</span>
               </div>
            </div>

         </form>
      </div> <!-- container-fluid -->
   </header>  

   <!-- anuncios -->
   <form id="frmServico" class="form-horizontal" action="servico.php" method="POST" role="form">      

   <div class="container" id='div_container'>

      <div class="row fundo_branco_1">
         <div class="col-md-12 altura_linha_1"></div>   
      </div>

      <!-- nessa linha - vai coluna 1 da esquerda 
                             coluna 2 da direita imprime os anuncios -->         
      <div class="row fundo_branco_1">         
         
         <!-- destaque -  ***lado esquerdo*** -->   
         <div class="col-lg-3 col-xl-3 d-none d-lg-block">

            <div class="row">
               <div class="col-12 fundo_cinza_1">
                  <?php  Utils::exibir_anuncio_aleatorio( 'perdido', 'Pet Desaparecido, <br>veja mais aqui!', '#fafafa'); ?>
               </div>
               <div class="col-md-12 altura_linha_2"></div>
               <div class="col-md-12 altura_linha_2"></div> 
               <div class="col-12 text-center fundo_laranja_0">
                  <?php  Utils::exibir_anuncio_aleatorio( 'doacao', 'Amiguinhos para Adoção,<br> veja mais aqui!', '#fafafa'); ?>
               </div> 
            </div>

            <div class="row">   
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 text-center">
                  <a class="link_d" href="cadastro/index.php">Crie sua conta gratuíta <br> aqui no Portal oViraLata!</a>
               </div>
               <div class="col-12 altura_linha_2"><br><br><br><br></div>   
            </div>

            <div class="row">
               <div class="col-12 text">
                  <?php Utils::exibir_tipos_anuncio('desktop', 'Anuncie grátis:') ?>                 
               </div>
            </div>   

            <div class="row">   
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12">
                  <?php  Utils::exibir_anuncio_aleatorio( 'doacao', 'Amiguinhos para Adoção,<br> veja mais aqui!', '#fafafa'); ?>
                  <br><br>
               </div>
            </div>

         </div>


         <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" >
            <?php              
            $i=0;
            foreach ( $consulta_servico as $anuncio ) {
               $id_servico       = $anuncio->id_servico;
               $titulo           = $anuncio->titulo;
               $descricao        = trim(substr($anuncio->descricao,0,140)).'...&nbsp;';
               $descricao_mobile = trim(substr($anuncio->descricao,0,47)).'...&nbsp;';
               $municipio        = trim($anuncio->municipio).' - '.trim($anuncio->uf);                
         
               $dados = Utils::obter_array_fotos_servico( $id_servico, $anuncio->data_cadastro, 'T' );
               
               $pasta_dc = 'fotos_servico/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
               if ( $dados->total_fotos>0 ) {
                  $nome_thumbnail = $pasta_dc.$dados->fotos[0];
               } else {
                  $nome_thumbnail = 'images/sem_foto1.png';
               }  
               ?> 

                  
               <!-- linha: 1  (foto + anuncio ) -->
               <div class="row shadow p-1 mb-1 bg-white rounded" >                  
                  <!-- coluna:1 - foto -->
                  <div class="col-5 col-sm-4 col-md-4 col-lg-4 col-xl-4 sem_margem" >
                     <a href="javascript:mostrar_detalhes_servico(<?=$id_servico?>)"  >
                        <img src="<?=$nome_thumbnail?>" class='img-fluid rounded' style='min-width:110px;min-height:110px;' alt="<?=$anuncio->titulo?>" >
                     </a>
                  </div>   

                  <!-- coluna:2 (dados do anúncio) -->
                  
                  <div class="col-7 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                     <a href="javascript:mostrar_detalhes_servico(<?=$id_servico?>)"  >
                     <div class="row">                         
                        <div class="col-12">
                           <span class="fonts_verde_m"><?= $anuncio->titulo;?></span><br> 
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
                           <span class="font_cinza_m"><?=$municipio?></span>
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
                           <span class="font_azul_p"><?=$anuncio->tiposervico ?></span>&nbsp;&nbsp;&nbsp;
                        </div>                      
                        <div class="col-12">                           
                           <span class="font_cinza_p"><?= Utils::data_anuncio($anuncio->data_atualizacao)?></span>
                           &nbsp;&nbsp;&nbsp;
                           <span class="font_azul_m">Leia mais...</span>
                        </div>
                     </div>

                     <div class="row d-none d-lg-block">  <!-- desktop -->
                        <div class="col-12">
                           <span class="font_azul_p"><?=$anuncio->tiposervico ?></span>&nbsp;&nbsp;&nbsp;
                           <span class="font_cinza_p"><?= Utils::data_anuncio($anuncio->data_atualizacao)?></span>
                        </div>
                        <div class="col-12">
                           <span class="font_cinza_p"><?=$descricao?></span>
                           &nbsp;&nbsp;&nbsp;
                           <span class="font_azul_m">Leia mais...</span>
                        </div>
                     </div>                   
                     </a>
                  </div>
               </div>

               <!-- anuncios - adsense -->
               <?php
               if ($i==1 ) {?>
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
                             data-ad-slot="8484848734"></ins>
                        <script>
                             (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                     </div>
                     <div class="col-12 altura_linha_2"></div>
                     <div class="col-12 altura_linha_2"></div>          
                  </div>                  
               <?php
               }?>

               <?php
               // mensagens
               if ($i==3 || $i==26 ) {?>
                  <div class="row alert alert-danger">
                     <div class="col-12 text-center">
                        <h5><?=$mensagem_1?></h5>
                     </div>
                  </div>
               <?php
               }
               if ($i==6 || $i==23 ) {?>
                  <div class="row alert alert-danger">
                     <div class="col-12 text-center">
                        <h5><?=$mensagem_2?></h5>
                     </div>
                  </div>
               <?php
               }

               if ( $i==5 ) {?>
                  <!-- anuncio_texto_1 -->
                  <div class="row text-center">
                     <div class="col-12 altura_linha_2"></div>
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
                     <div class="col-12 altura_linha_2"></div>
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

             <div class="row shadow p-1 mb-1 rounded margem_pequena fundo_laranja_0">
               <div class="col-12 text-center">
                  <span class="text-center"><?=$mensagem_1?><span>
               </div>
               <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="row text-center margem_pequena">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 tit_0">Publicidade</div>
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
            
      <!-- desktop -->
      <div class="row d-none d-lg-block">
         <div class="col-12 text-center">             
         </div>
      </div>

      
      <?php  
      include_once 'rodape_1.php';
      ?>

   </div> <!-- /container -->
   </form>

<?php
?>

<script type="text/javascript">

   $('#id_desaparecido').carousel({
       pause: true,
       interval: false,
   });

   function submeter_form( pagina = '1') {
      $('#comportamento').val( 'submeter_form' );
      $('#frm_pagina').val( pagina );
      document.forms['frmServico'].submit();
   }

   function mostrar_detalhes_servico(id) {
      $('#comportamento').val( 'mostrar_detalhes_servico' );
      $('#frm_id_servico').val( id );
      document.forms['frmServico'].submit();
   }   

   function exibir_lista_ou_galeria(_this) {
      if ( document.querySelector('input[id="frm_lista_galeria_l"]:checked') ) {
         $('#comportamento').val( 'exibir_lista' );
      } else {
         $('#comportamento').val( 'exibir_galeria' );
      } 
      document.forms['frmServico'].submit();
   }

   $( document ).ready(function() {     
      // vazio
   });


</script>   

</body>

</html>
