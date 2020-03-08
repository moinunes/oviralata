<?php
session_start();

include_once 'conecta.php'; 
include_once 'cad_usuario_hlp.php'; 
include_once 'utils.php';

if ( !isset( $_SESSION['login'] ) ) {
   header("Location: cad_login.php");
}
$id_usuario = $_SESSION['id_usuario'];

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <?php Utils::meta_tag() ?>
    
   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   <link rel="stylesheet" href="../dist/fonts/fonts.css" >
   
</head>

<body class="margem_pequena">

   <div class="container">
  
      <?php include_once 'cad_cabecalho_1.php';?>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row">
         <div class="col-12">
            <a class="link_d" href="cad_usuario.php?acao=alteracao&comportamento=exibir_formulario_alteracao&id_usuario=<?=$id_usuario?>" role="button">Meu Cadastro</a>
         </div>         
      </div>   
      
      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row">
         <div class="col-12">
            <a class="link_d" href="cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">Meus anúncios publicados</a>
         </div>
      </div>   
      
      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row">
         <div class="col-md-12">            
            <span class="font_cinza_g text-righ">O que você quer Anunciar?</span>
            <br>
         </div>
         <div class="col-md-12">            
            <a href="cad_anuncio.php?acao=inclusao&comportamento=exibir_formulario"><ins>1- Doação PET</a></ins><br>
         </div>
         <div class="col-12 altura_linha_1"></div>
         
         <div class="col-md-12">            
            <a href="cad_anuncio.php?acao=inclusao&comportamento=exibir_formulario"><ins>2- Pet Desaparecido</a></ins><br>
         </div>
         <div class="col-12 altura_linha_2"></div>
         <div class="col-md-12">
            <a href="cad_servico.php?acao=inclusao&comportamento=exibir_formulario"><ins>3- Serviços ou Produtos PET</a></ins><br>
         </div>
         <div class="col-12 altura_linha_1"></div>
         
      </div>
      

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>


      <!-- desktop -->
      <div class="row text-center d-none d-lg-block">
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 tit_0">Publicidade</div>
      </div>
      <!-- anuncio_texto_1 -->
      <div class="row text-center d-none d-lg-block shadow p-1 mb-3 bg-white rounded">
         <div class="col-12 text-center"  style="border-color: #f3f9f0;" > 
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

      <!-- mobile -->
      <div class="row text-center d-lg-none">
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
      </div>
      <!-- anuncio_texto_1 -->
      <div class="row text-center d-lg-none shadow p-1 mb-3 bg-white rounded">
         <div class="col-12 text-center"  style="border-color: #f3f9f0;" > 
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
         <div class="col-12">
            <br>
            <br><br>
         </div>  
      </div>

      
   </div> <!-- container -->

   <!-- desktop -->
   <footer>
      <div class="row">
         <div class="col-md-12">
            <br><br><br>
            <nav class="navbar navbar-light cor_verde">
               <a target="_blank" class="btn btn-outline-success btn_link" href="../index.php" role="button">Abrir Site</a>
            </nav>
         </div>
      </div> 
   </footer>


   <!--    -->
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   

   <script type="text/javascript">
     
   </script>     
   

</body>

</html>
