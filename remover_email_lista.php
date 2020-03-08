<?php
include_once 'cadastro/utils.php';
include_once 'cadastro/conecta.php';

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <?php Utils::meta_tag() ?>

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">
   
   <link href="./dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="./dist/css/estilo.css" >
   
</head>

<body class="fundo_branco_1">

<div class="container">
 
   <div class="row fundo_verde_claro">            
      <div class="col-3"> 
         <img src="./images/logo.png" >
      </div>
   </div>

   <div class="row fundo_verde_claro">            
      <div class="col-12 text-right">
         <span class="font_verde_g text-righ">oViraLata</span>
      </div>   
   </div>
   <div class="row fundo_cinza_2">            
      <div class="col-12 altura_linha_1">
      </div>
   </div>

   <div class="row">            
      <div class="col-12">
         <br><br><br>
         <span class="font_preta_g">O seu E-mail foi removido da nossa lista!</span>
         <br><br><br>
      </div>   
   </div>

   
   <?php
   
   //.. remove o email da lista 
   $conecta   = new Conecta();
   $id_email = $_REQUEST['id_email'];
   $codigo   = $_REQUEST['codigo'];
   
   $sql = " UPDATE tbemails
                  SET ativo ='N'
                  WHERE id_email={$id_email} AND codigo='{$codigo}' ";
   $stmt = $conecta->con->prepare($sql);
   $stmt->execute();

   ?>
      
</div> <!-- container -->

<div class="container">
   <div class="row">
      <div class="col-md-12">
         <br>
         <br>
         <br><br>
      </div>            
   </div>
</div> <!-- container -->

 <div class="row div_rodape">
   <div class="col-12">         
      <span class="font_cinza_p">Copyright © 2018 www.oviralata.com.br</span>
   </div>
   <div class="col-12">         
      <span class="font_cinza_p">Todos os direitos reservados. </span>
   </div>
   <div class="col-4 text-center">         
      <span class="font_cinza_p">
         <a class="link_a" href="../index.php" role="button">OViraLata</a>
      </span>
   </div>
    <div class="col-4 text-center">         
   <span class="font_cinza_p">
         <a class="link_a" href="../termos_de_uso.php" role="button">Termos de Uso</a>
      </span>
   </div>
   <div class="col-4">         
      <span class="font_cinza_p">
         <a class="link_a" href="../politica_privacidade.php" role="button">Política de privacidade</a>
      </span>
   </div>
   <div class="col-12 altura_linha_2">
      <br>
   </div>
      
</div>


</body>
</html>   