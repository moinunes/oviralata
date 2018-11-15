<?php
session_start(); 
if ( !isset($_SESSION['login']) ) {
   session_destroy();
   header("Location:login.php");
}

include_once 'cadastro_hlp_imovel.php';
include_once 'domicilio_hlp.php';
include_once 'cadastro_hlp_tipo.php';


?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Imobiliaria</title>

   <meta charset="utf-8">   
   <meta name="keywords" content="imobiliaria,imóvel,imóveis,apartamentos,casas,compra,venda,santos, são vicente,"/>
   <meta name="description" content="Escolha seu imóvel na baixada santista.">   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="./dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="./dist/css/estilo.css" >
   
</head>

<body class="fundo_cinza_1">
   
      <?php include_once 'cabecalho_tools.php';?>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-2">         
            <span class="font_cinza_f">Cadastro de Imóvel</span>
         </div>
   
            <div class="col-md-2 text-right">            
               <a class="btn btn-outline-success btn_link" href="cadastro_imovel.php?acao=inclusao&comportamento=exibir_formulario&frm_id_imovel=0"><img src="./images/novo.svg"  > Novo</a>
            </div>
         
        <div class="col-md-6 text-right">            
            <a class="btn btn-outline-success btn_link" href="index.php?acao=vazio&comportamento=vazio"><img src="./images/voltar.svg" >Voltar</a>
         </div>
      </div>
   
   <div class="container">
      <div class="row">
         <div class="col-12">
            <br>
            <?php
            $mens  = "<br>Inclusão realizada com sucesso. ";
            $mens .= "Imóvel código: {$_GET['id_imovel']}";
            print $mens;
            ?>

            <br><br><br>
            <a href="cadastro_imovel.php?acao=inclusao&comportamento=exibir_listagem">Quero Incluir um IMÓVEL</a>
            <br><br><br>
            <a href="cadastro_imovel.php?acao=alteracao&comportamento=exibir_listagem">Quero alterar um IMÓVEL</a>              
          
         </div>            
      </div>         

   </div> <!-- container -->

   <footer>
      <div class="row">
         <div class="col-md-12 div_rodape">
            <br>
            <span class="font_cinza_p">Copyright © 2018 www,imobiliaria.com Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>         
   </footer>

   <!--  -->
   <script src="./dist/js/load-image/load-image.all.min.js"></script>
   <script src="./dist/js/jquery-3.3.1.min.js"></script>
   <script src="./dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="./dist/jquery-ui/jquery-ui.min.js"></script>
   <script src="./dist/js/upload.js"></script>
   <script src="./dist/js/cadastro_imovel.js"></script>
   <script src="./dist/jquery_mask/dist/jquery.mask.min.js"></script>

   


</body>

</html>
