<?php
session_start();

include_once 'anuncio_hlp.php';
include_once 'cadastro/utils.php';
include 'carrossel_adotar.php';
include 'carrossel_desaparecido.php';

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Adotar! Um ato de Amor. Mude sua vida, adote um amiguinho PET. Adoção e Doação de cães, gatos, etc... oViraLata.</title>
   <meta charset="utf-8">   
   <meta name="keywords"    content="adoçao de animais doação-cachorro-gato-oViraLata-Pet Doação de Pets-cão-gato-roedor-ração-doação de cão e gato, amor e respeito aos animais"/>
   <meta name="description" content="oViraLata é um site de anúncios de Adoção e Doação PET. No site você pode adotar ou publicar anúncios de doação: de cães, gatos, etc. O oViraLata também disponibiza espaço para publicação de anúncios de Pets desaparecidos. Adote um amiguinho PET. Doação de Cães e Gatos em todo Brasil">   
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

   <meta property="og:title" content="Amor e Respeito ao animais" />
   <meta property="og:description" content="O site oViraLata é pra você que deseja Adotar ou Doar um PET, ou está procurando um Pet Desaparecido. ... <<< Clique Aqui! e veja mais... >>>" />
   <meta property="og:site_name" content="oViraLata" />
   <meta property="og:type" content="website" />
   <meta property="og:image:type" content="image/png">
   <meta property="og:image" content="https://www.oviralata.com.br/images/jaba-adota.png">
   <meta property="og:image:width" content="800"> 
   <meta property="og:image:height" content="600"> 
   <meta property="og:url" content="https://www.oviralata.com.br/" />
   <meta property="og:locale" content="pt_br" />
   <meta property="fb:app_id" content="2363003217281328" /> 

</head>   

<body>

   <header id="header">

    <style type="text/css">
   
    </style>
    
      <div class="container-fluid">
         <form id="frmIndex" class="form-horizontal" action="index.php" method="POST" role="form">
               
            <?php  
            include_once 'cabecalho.php';
            ?>
            
            <div class="row fundo_cinza_1">            
               <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="row fundo_branco_1">            
               <div class="col-12 altura_linha_1"></div>
            </div>

            <!-- comentario -->
            

         </form>
      </div> <!-- container-fluid -->
   </header>  

   <!-- anuncios -->
   <form id="frmIndex" class="form-horizontal" action="index.php" method="POST" role="form">      

   <div class="container" id='div_container'>

      <div class="row fundo_branco_1">
         <div class="col-md-12 altura_linha_1"></div>   
      </div>

      <!-- nessa linha - vai coluna 1 da esquerda 
                             coluna 2 da direita imprime os anuncios -->         
      <div class="row fundo_branco_1">         
         
         <!-- destaque -  ***lado esquerdo*** desktop -->   
         <div class="col-lg-3 col-xl-3 d-none d-lg-block">
            
            <div class="row">   
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"><br><br><br><br></div>   
               <div class="col-12 text-center">
                  <a class="link_d" href="cadastro/index.php">Crie sua conta gratuita!</a>
               </div>
               <div class="col-12 altura_linha_2"><br><br><br><br></div>   
               
            </div>         
            
            <?php  Utils::exibir_anuncio_aleatorio( 'doacao', 'Adotar, veja mais aqui!', '#ffffff'); ?>

            <div class="row text-center">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 tit_0">Publicidade</div> 
            </div>
            <!-- banner do lado esquerdo moises --> 
            <div class="row margem_pequena">                        
               <div class="col-12 text-right">
                  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- grafico_vertical_1 -->
                  <ins class="adsbygoogle"
                       style="display:block"
                       data-ad-client="ca-pub-2582645504069233"
                       data-ad-slot="1969194236"
                       data-ad-format="auto"
                       data-full-width-responsive="true"></ins>
                  <script>
                       (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
               </div>
            </div>

             <div class="row margem_pequena">
               <div class="col-12">
                  <span class="font_vermelha_g">
                     Quer  <a href="cadastro/cad_login.php"><ins>Divulgar</ins></a>
                     seus Serviços<br> ou Produtos PET?<br></span>
               </div>
            </div>

            <div class="row fundo_branco">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12">    
                  <?php Utils::exibir_tipos_anuncio('desktop', 'Anuncie grátis:' ) ?>
               </div>
            </div> 

         </div>

         <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

            <div class="row">
               <div class="col-12 text-center ">
                   <span class="destaque_1">
                     <span class="tit_2">Amor e Respeito ao animais</span>
                     <br>
                  </span>
               </div>
            </div>

            <div class="row margem_pequena">
               <div class="col-12">
                   <span class="text">
                     <br>
                     <span class="font-weight-bold">O site oViraLata é pra você:</span><br><br>
                     <h6>
                        <a href="adotar.php"><ins>- Adotar um PET;</ins></a><br><br>
                        <a href="cadastro/index.php"><ins>- Doar um PET;</ins></a><br><br>
                        <a href="perdido.php"><ins>- Encontrar um Pet Desaparecido;</ins></a><br><br>
                        <a href="servico.php"><ins>- Encontrar serviços ou produtos PET;</ins></a><br>
                     </h6>
                  </span>
               </div>
            </div>
            
            <div class="row margem_pequena">
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12 text-right">   
                  <span>
                     <img src="./images/pata2.png" alt='oViraLata disponibiliza esse canal para ajudar a encontrar um lar os pets'>
                  </span>  
               </div>
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12">
                  <span class="font-weight-bold">O que é o site oViraLata?</span><br>
               </div>
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12">
                  <span class="text">
                     É um portal de Anúncios PET gratuíto.<br>
                  </span>
               </div>
               <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="row margem_pequena">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12">
                  <span class="font-weight-bold">Qual o objetivo do site oViraLata?</span><br>
               </div>
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12">               
                  <span class="text">
                     - Ajudar <strong>a divulgar as Doações</strong> de cães, gatos e outros pets...<br> 
                  </span>
               </div>
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12">
                  <span class="text">
                     - Ajudar <strong> a divulgar </strong> PET's DESAPARECIDOS.<br> 
                  </span>
               </div>
               
               <div class="col-12 altura_linha_1"></div>
               <div class="col-12">   
                  <span class="tit_1">
                     <ins>Para isso disponibilizamos o site oViralata para que todos possam 
                      publicar seus anúncios gratuítamente.</ins>
                       <br>
                  </span>
               </div>
               <div class="col-12 altura_linha_2"></div>
            </div>

            <div class="row margem_pequena">
               <div class="col-12">
                  <img src="./images/pata1.png" alt='Se você está pensando em adotar um cão ou - gato, parabéns!'>
               </div>
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12">
                  <span class="font-weight-bold">Como funciona o site para quem quer Adotar?</span><br>
                  <span class="text">
                      O interessado em <strong> adotar um pet</strong>  pode realizar uma busca no site por: cidade, bairro, etc,
                      e o site exibe uma lista de doações com informações do PET e do anunciante como: e-mail, celular e WhatsApp.<br>Depois é só entrar em contato direto com o anunciante (tutor do pet).<br> 
                  </span>
               </div>
            </div>

            
            <div class="col-12 text-right">
               <img src="./images/pata2.png" alt='Adoção de animais, filhotes e adultos cães gatos e outros pets'>
            </div>
            
            <div class="row margem_pequena">
              
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12">
                  <span class="font-weight-bold">Como funciona o site para quem quer DOAR?</span><br>
                  <span class="text">
                      É só se <a href="cadastro/index.php"><ins>cadastrar no site</ins></a> com suas informações para contato como e-mail, celular e ou WhatzApp.<br>
                      Depois é só <a href="cadastro/index.php"><ins>publicar seus anúncios gratuitamente</ins></a> com as informações e fotos do Pet.
                  <br>
                  </span>
               </div>
            </div>

            <div class="row shadow-sm p-2 mb-3 bg-white rounded margem_pequena">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12">
                  <img src="./images/pata1.png" alt='Agradecemos seu interesse em adotar um cão sem dono'>
               </div>
            </div>
            
         
            <?php Utils::exibir_tipos_anuncio('desktop', 'Anuncie grátis:') ?>

            <div class="row">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 text-right">
                  <img src="./images/pata2.png" alt='Que tal adotar ao invés de comprar um pet?'>
               </div>
               <div class="col-12 altura_linha_2"></div>               
            </div>
            <!-- Adote um Amiguinho PET --> 
            <div class="row fundo_branco_1  margem_pequena">
               <div class="col-12 sem_margem text-center">
                  <?php  Utils::exibir_anuncio_aleatorio( 'doacao', 'Adotar,<br> veja mais aqui!', '#ffffff'); ?>
               </div>               
            </div>
            
            <div class="row">            
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"></div>
            </div>
            
            <!-- PET Perdido -->             
             <div class="row fundo_branco_1  margem_pequena">
               <div class="col-12 sem_margem text-center">
                  <?php
                  Utils::exibir_anuncio_aleatorio( 'perdido', 'Pet Desaparecido,<br> veja mais aqui!', '#ffffff'); ?>
               </div>
            </div>

            <div class="row">            
               <div class="col-12 altura_linha_2"></div>
            </div>
            
            <div class="row text-center">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 tit_0">Publicidade</div>
            </div> 
            <!-- depois do rodapé -->
            <div class="row border margem_pequena">
               <div class="col-12 text-center" >
                  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <ins class="adsbygoogle"
                       style="display:block"
                       data-ad-format="fluid"
                       data-ad-layout-key="-fb+5w+4e-db+86"
                       data-ad-client="ca-pub-2582645504069233"
                       data-ad-slot="1718106319"></ins>
                  <script>
                       (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
               
               </div>
            </div>

            <div class="row">            
               <div class="col-12 altura_linha_2"></div>
            </div>
            
         </div>

         <!-- destaque - lado Direito - Desktop -->   
         <div class="col-lg-3 col-xl-3 d-none d-lg-block text-center">
            <div class="row">                    
               <div class="col-12 text-center">
                  <br>
                  <?php  Utils::exibir_anuncio_aleatorio( 'perdido', 'Pet Desaparecido,<br> veja mais aqui!'); ?>
               </div>
               <div class="col-12 altura_linha_2"></div>
            </div>


            <div class="row margem_pequena mb-1 rounded ">
               <div class="col-12">
                  <span class="font_vermelha_g">Seu PET Desapareceu?<br></span>
                  <span class="tit_1">
                     <a href="cadastro/cad_login.php"><ins>Divulgue aqui.</ins></a>
                  </span>
               </div>
            </div>

            <div class="row">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 altura_linha_2"></div>
            </div>

            <div class="row margem_pequena mb-1 rounded">
               <div class="col-12">
                  <span class="font_vermelha_g">
                     Quer  <a href="cadastro/cad_login.php"><ins>Divulgar</ins></a>
                     seus Serviços<br> ou Produtos PET?<br></span>
               </div>
            </div>


         </div>

      </div>
      <!-- fim dos registros(anuncios) -->
     
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
</script>   

</body>

</html>
