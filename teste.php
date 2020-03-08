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

   <style>
      .alerta {
         background:#ffffff;
         border:1px solid red;
      }      

   </style>   

</head>   

<body>

   <form id="frmAdotar" class="form-horizontal" action="adotar_galeria.php" method="POST" role="form">      

      <div>+
         <div>
            <input type="text" id="frm_id_receita"  name="frm_id_receita"  value = "" >
            <input type="text" id="frm_nome"  name="frm_nome"  value = "" >
         </div>
      </div>
      
   </form>

<?php
?>

<script type="text/javascript">

      $( "#frm_id_receita" ).addClass( "alerta" );
      $( "#frm_nome" ).addClass( "alerta" );

      $( "#frm_nome" ).removeClass( "alerta" );
     
</script>   

</body>

</html>


