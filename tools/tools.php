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

   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   
</head>

<body>

      
<div class="container-fluid"> 

      <?php include_once 'tools_cabecalho.php';?>

      <div class="row">
        
         <div class="col-4 text-center">
             <a class="link_a" href="tools_manutencao.php?acao=alteracao&comportamento=exibir_listagem" role="button">Manutenção</a>
         </div>
  
         <div class="col-4 text-center">
             <a class="link_a" href="tools_marketing_whatsapp.php?acao=alteracao&comportamento=cadastrar" role="button">Marketing-Whatsap</a>
         </div>
         <div class="col-4 text-center">
             <a class="link_a" href="cad_raca.php?acao=alteracao&comportamento=exibir_listagem" role="button">Raças</a>
         </div>

         <div class="col-12">
            <br>
         </div>

         <div class="col-4 text-center">
             <a class="link_a" href="tools_marketing.php?acao=alteracao&comportamento=exibir_listagem" role="button">Marketing-Usuários</a>
         </div>
         <div class="col-4 text-center">
             <a class="link_a" href="cad_cep.php?acao=alteracao&comportamento=exibir_listagem" role="button">Cep</a>
         </div>
         <div class="col-4 text-center">
             <a class="link_a" href="cad_tipo_servico.php?acao=alteracao&comportamento=exibir_listagem" role="button">Tipos Serviço</a>
         </div>


         <div class="col-12">
            <br>
         </div>
          <div class="col-4 text-center">
             <a class="link_a" href="tools_marketing_desconhecido.php?acao=alteracao&comportamento=exibir_listagem" role="button">Marketing-Desconhecido</a>
         </div>


 
         <div class="col-4 text-center">
             <a class="link_a" href="tools_pastas_tmp.php?acao=alteracao&comportamento=exibir_listagem" role="button">PastasTmp</a>
         </div>        
          <div class="col-4 text-center">
             <a class="btn btn-outline-success btn_link" href="../cadastro/cad_login.php?acao=logout&comportamento=vazio" role="button"><img src="../images/sair.svg"> Sair</a>
         </div>        
         
      </div>        
   
      <div class="row">
         <div class="col-12">
            <br>
        </div>
      </div>
     
</div> <!-- container -->

<script type="text/javascript">
     
</script>     
   
</body>

</html>
