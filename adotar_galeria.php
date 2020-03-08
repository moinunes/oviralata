<?php
session_start();

if ( isset($_REQUEST['comportamento']) && $_REQUEST['comportamento']=='exibir_lista' ) {
   header("Location:adotar.php");
}

include_once 'anuncio_hlp.php';
include_once 'cadastro/utils.php';
include 'carrossel_adotar.php';
include 'carrossel_desaparecido.php';

$id_anuncio           = isset($_REQUEST['frm_id_anuncio'])           ? trim($_REQUEST['frm_id_anuncio'])           : '';
$comportamento        = isset($_REQUEST['comportamento'])            ? trim($_REQUEST['comportamento'])            : '';
$filtro_palavra_chave = isset($_REQUEST['frm_filtro_palavra_chave']) ? trim($_REQUEST['frm_filtro_palavra_chave']) : '';

Utils:: obter_mensagens( $mensagem_1, $mensagem_2 );

$lista_galeria = 'G';

switch ( $comportamento ) {
   case 'mostrar_detalhes':
      header("location: mostrar_detalhes.php"."?frm_id_anuncio={$id_anuncio}&frm_manter_galeria=S" );       
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
   
   <!--  .js -->
   <script src="./dist/js/jquery-3.3.1.min.js"></script>
   <script src="./dist/jquery-ui/jquery-ui.min.js"></script>
   <script src="./dist/bootstrap-4.1/js/popper.min.js"></script>
   <script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>

   <script src="./dist/js/adotar_galeria.js"></script>

</head>   

<body>

   <header id="header">

    <style type="text/css">
   
    </style>
    
      <div class="container-fluid">
         <form id="frmAdotar" class="form-horizontal" action="adotar_galeria.php" method="POST" role="form">

            <input type="hidden" id="comportamento"  name="comportamento"  value = "<?=$comportamento?>"> 
            <input type="hidden" id="frm_id_anuncio" name="frm_id_anuncio" value = "<?=$id_anuncio?>">  
            <?php  
            include_once 'cabecalho.php';
            ?>
            
            <div class="row">            
               <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="row fundo_branco_1">            
               <div class="col-12 text-center">
                  <a href="adotar.php"><img src="./images/adote_um_pet.png" alt='adote um pet, cachorro, gato ou outro animal de estimação'></a>  
               </div>   
            </div>

             <div class="row fundo_cinza_1">            
               <div class="col-12 altura_linha_1">
               </div>
            </div>

            <div class="row fundo_laranja_1">            
               <div class="col-12 text-center">                        
                  <input type="radio" id="frm_lista_galeria_l" name="frm_lista_galeria" value="L" onchange="exibir_lista_ou_galeria(this)"         /><span class="text">&nbsp;Lista</span>
                  <input type="radio" id="frm_lista_galeria_g" name="frm_lista_galeria" value="G" onchange="exibir_lista_ou_galeria(this)" checked /><span class="text">&nbsp;Galeria</span>
               </div>               
            </div>

            <!-- filtros unico  -->
            <div class="row fundo_verde_claro text">            
               <div class="col-12"><span class="font_preta_m">Buscar por palavra-chave:<br></span></div>
               <div class="col-12 text-center">
                  <div class="input-group">
                     <input type="text" class="form-control form-control-sm" id='frm_filtro_palavra_chave' name='frm_filtro_palavra_chave' value="<?=$filtro_palavra_chave;?>" placeholder="Exemplo: cão são paulo sp" >
                     <div class="input-group-append">
                        <button type="button" class="btn btn_lupa1" id='btnBuscar' name='btnBuscar' onclick="submeter_form()"><img src="./images/lupa.png" alt='procurar pet, buscar pet'></button>
                     </div>
                  </div>
               </div>
               <div class="col-12 altura_linha_1"></div>
            </div>
            

         </form>
      </div> <!-- container-fluid -->
   </header>  

   <!-- anuncios -->
   <form id="frmAdotar" class="form-horizontal" action="adotar_galeria.php" method="POST" role="form">      

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
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 text-center">
                  <?php  Utils::exibir_anuncio_aleatorio( 'perdido', 'Pet Desaparecido,<br> veja mais aqui!', '#ffffff'); ?>
               </div>

               <div><br><br></div>
               <div class="col-12 text-center">
                  <a class="link_d" href="cadastro/index.php">Já fez seu cadastro?</a>
               </div>
               <div class="col-12 altura_linha_2"><br><br></div>   
              
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


            <!-- Carrossel_Adotar ---> 
            <div class="row shadow p-1 mb-1 rounded">
               <div class="col-12 fundo_laranja_0">
                  <?php
                  $instancia = new Carrossel_Adotar();
                  $instancia->id_carousel = 'id_adotar_galeria';
                  $instancia->cor_fundo='fundo_laranja_0';
                  $instancia->filtro_palavra_chave = $filtro_palavra_chave;
                  $instancia->total_anuncios = 200;
                  $instancia->exibir_btn_detalhes='S';
                  $instancia->executar();
                  ?>
               </div>
            </div>

            <!-- exibir detalhes --->
            <div class="row shadow p-1 mb-1 rounded">
               <div class="col-12">
                  <div id='div_buscar'> ..... </div> 
               </div>   
            </div>

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
  
      <!-- desktop -->
      <div class="row d-none d-lg-block">
         <div class="col-12 text-center">             
         </div>
      </div>

   </div> <!-- /container -->
   </form>

<?php
?>
<script type="text/javascript">

   function submeter_form( pagina = '1') {
      $('#comportamento').val( 'submeter_form' );
      $('#frm_manter_galeria').val( 'N' );
      document.forms['frmAdotar'].submit();
   }

   function exibir_lista_ou_galeria(_this) {
      if ( document.querySelector('input[id="frm_lista_galeria_l"]:checked') ) {
         $('#comportamento').val( 'exibir_lista' );
      } else {
         $('#comportamento').val( 'exibir_galeria' );
      } 
      document.forms['frmAdotar'].submit();
   }

   $( document ).ready(function() {
      // vazio
   });

   $('#id_adotar_galeria').carousel({
       pause: true,
       interval: false
   });
  
   function mostrar_detalhes(id_anuncio) {
      exibir_detalhes_carousel_adotar(id_anuncio);
   }

</script>   

</body>

</html>
