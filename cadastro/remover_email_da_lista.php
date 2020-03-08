<?php
include_once 'utils.php';
include_once '../cadastro/conecta.php';

$marketing_aceito = $_REQUEST['marketing_aceito'];
if ( $marketing_aceito=='S' ) {
   atalizar_tbemails('S');
   header("Location: ../index.php");
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Adotar! Um ato de Amor. Mude sua vida, adote um amiguinho PET. Adoção e Doação de cães, gatos, etc... oViraLata.</title>
   <meta charset="utf-8">   
   <meta name="keywords"    content="adoçao de animais doação-cachorro-gato-oViraLata-Pet Doação de Pets-cão-gato-roedor-ração-doação de cão e gato, amor e respeito aos animais"/>
   <meta name="description" content="oViraLata é um site de anúncios de Adoção e Doação PET. No site você pode adotar ou publicar anúncios de doação: de cães, gatos, etc. O oViraLata também disponibiza espaço para publicação de anúncios de Pets desaparecidos. Adote um amiguinho PET. Doação de Cães e Gatos em todo Brasil">   
   <meta name="viewport"    content="width=device-width, initial-scale=1, maximum-scale=1">
   
   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="../dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">

   <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   <link rel="stylesheet" href="../dist/fonts/fonts.css" >
   
</head>   

<body>

   <div class="container" id='div_container'>
      <?php  
      include_once 'cad_cabecalho_1.php';   
      ?>      
      <div class="row">
         <div class="col-12">
             <span class="tit_1">Seu e-mail foi retirado da nossa lista!<br></span>
             <span class="tit_1">E você não receberá mais email do portal oViraLata.<br></span>
         </div>
      </div>  
      <div class="row">
         <div class="col-12">
             <br>
             <span class="tit_0">att,<br></span>
             <span class="tit_0">Portal oViraLata<br></span>
         </div>
      </div>
   </div> <!-- container-fluid -->


   <?php

   $marketing_aceito = $_REQUEST['marketing_aceito'];
   if ( $marketing_aceito=='S' ) {
      atalizar_tbemails('S');
      header("Location: cad_login.php");
   } else {
      atalizar_tbemails('N');   
   }
   

   function atalizar_tbemails( $aceitou ) {
      $email = trim($_REQUEST['email']);
      $data = Utils::obter_data_hora_atual();
      $conecta = new Conecta();
      try {
         $conecta->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbemails
                  SET marketing_aceito ='{$aceitou}',
                      data='{$data}'
                  WHERE email='{$email}' ";
         $stmt = $conecta->con->prepare($sql);
         $stmt->execute();
         
      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
      }
      return null;
   }
   ?> 

</body>
</html>
