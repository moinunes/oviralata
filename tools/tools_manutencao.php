<?php
session_start();

include_once '../cadastro/utils.php';

if ( !$_SESSION['login'] ) {
   header("Location: tools_login.php");
}


?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <meta charset="utf-8">
   <meta name="keywords"    content="Portal,Pet,Feliz,Doação de Pets,cão,gato,roedor,ração, doação de cão e gato"/>
   <meta name="description" content="O Portal Pet Feliz é um site de anúncios, voltado para Adoção e Doação de cães, gatos e outros pets, filhote ou adulto. Adote essa idéia.">   
   <meta name="viewport"    content="width=device-width, initial-scale=1, maximum-scale=1">


   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body>

   <header>
      <?php include_once 'tools_cabecalho.php';?>
  
      <div class="row fundo_cinza_2">
         <div class="col-12 text-center">
            <span class="font_vermelha_m">Manutenção dos cadastros</span>
         </div>
      </div>

      <div class="row fundo_cinza_1">
         
         <div class="col-12">  
             <br>
         </div>
         
         <div class="col-4 text-center">
             <a class="link_a" href="tools_cad_anuncio.php?acao=alteracao&comportamento=exibir_listagem" role="button">Anúncios</a>
         </div>

         
         <div class="col-4 text-center">
             <a class="link_a" href="tools_cad_mural_fama.php?acao=alteracao&comportamento=exibir_listagem" role="button">Mural Fama</a>
         </div>

         <div class="col-12">
             <br>
         </div>

         <div class="col-4 text-center">
             <a class="link_a" href="tools_cad_usuario.php?acao=alteracao&comportamento=exibir_listagem" role="button">Usuários</a>
         </div>
         
         <div class="col-4">            
         </div>  
         
         <div class="col-4 text-center">            
            <a class="btn btn-outline-success btn_link" href="tools.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
         </div>  
         
      </div>   

   </header>  



   <div class="container">
      
      <div class="row">
         <div class="col-md-12">
            <br>
         </div>
      </div>

     
   </div> <!-- container -->

   <footer class="fixed-bottom">
      <div class="row">
         <div class="col-md-12">
            <nav class="navbar navbar-light cor_verde">
               <a target="_blank" class="btn btn-outline-success btn_link" href="../" role="button">Abrir Site</a>
            </nav>
         </div>
      </div> 
   </footer>


   <!-- 
   <script src="../dist/js/load-image/load-image.all.min.js"></script>


    -->
   <script src="../dist/js/jquery-3.3.1.min.js"></script>


   <script type="text/javascript">
     
   </script>     
   

</body>

</html>
