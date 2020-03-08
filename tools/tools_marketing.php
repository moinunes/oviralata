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
   <?php Utils::meta_tag() ?>
   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >   
</head>
<body>  
   <?php include_once 'tools_cabecalho.php';?>   
   <div class="container">
  
      <div class="row fundo_cinza_1">

         <div class="col-12">
            <span class="destaque_1">Marketing-Usuários</span>
            <br><br>
         </div>
         <div class="col-4">
             <a class="link_a" href="tools_enviar_email.php?acao=alteracao&comportamento=exibir_listagem" role="button">Enviar-E-mail</a>
         </div>         
         <div class="col-4">
             <a class="link_a" href="tools_enviar_email.php?acao=alteracao&comportamento=liberar_usuarios" role="button">Liberar Usuários</a>
         </div>
         <div class="col-4">            
            <a class="btn btn-outline-success btn_link" href="tools.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
         </div>  
         
      </div>   

  
      
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
