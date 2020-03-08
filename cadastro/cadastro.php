<?php
session_start();
include_once '../cadastro/utils.php';
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <?php Utils::meta_tag() ?>

  
   <!--  .css -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">   
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   

   <link href="./dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">     
   <link rel="stylesheet" href="./dist/fSelect/fSelect.css" >
   

   <!--  .js -->
   <script src="dist/js/jquery-3.3.1.min.js"></script>
   <script src="./dist/jquery-ui/jquery-ui.min.js"></script>
   <script src="./dist/bootstrap-4.1/js/popper.min.js"></script>
   <script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>
   <script src="./dist/fSelect/fSelect.js"></script>
   <script src="./dist/jquery_mask/dist/jquery.mask.min.js"></script>
   

</head>   

<body>

   <div class="container">

      <?php
      include_once 'cad_cabecalho_0.php';
      ?>
     

      <div class="row">
         <div class="col-12 altura_linha_2"></div>
      </div>

      <div class="row  text-center">
         <div class="col-12">
           <?php
            include_once 'link_facebook_cadastro.php'; 
            ?>                  
         </div>         
      </div>

      <div class="row">
         <div class="col-12 altura_linha_2"></div>
      </div>
      <div class="row">
         <div class="col-12 altura_linha_2"></div>
      </div>


       <div class="row  text-center">
         <div class="col-12">
            <a class="link_a" href="cad_usuario.php?acao=inclusao&comportamento=exibir_formulario_inclusao&id_usuario=" role="button">ou Criar conta com seu e-mail e senha</a>
         </div>         
      </div>

      <div class="row">
         <div class="col-12 altura_linha_2"></div>
      </div>


      <div class="row">
         <div class="col-12 altura_linha_2"></div>
      </div>

      <div class="row text-center">
         <div class="col-12">
            <a class="link_a" href="../index.php" role="button">Início</a>
            <br><br>
         </div>         
      </div>


      <div class="form-group text-center">
         <div class="col-12">
            <span class="text-muted small">Ao criar a conta no site oViraLata você aceita os<br> <a href='../termos_de_uso.php'>Termos de uso</a> e <a href='../politica_privacidade.php'>a Política de privacidade</a></span>
         </div>
      </div>
         

   </div>
 

</body>

</html>
