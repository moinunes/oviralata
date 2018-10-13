<?php
session_start();
include_once 'tools.php';



if ( !isset( $_SESSION['login'] ) ) {   
   $host  = $_SERVER['HTTP_HOST'].'/imobiliaria/tools/login.php';   
   header("Location: http://$host");
}



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
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body>

   <header>
      
      <div class="row cor_verde">
         <div class="col-md-11 text-right">            
            <?php Tools::exibir_data_extenso();?>
         </div>
         <div class="col-md-11 text-right">            
               Usuário: <?=$_SESSION['usuario']?>            
         </div>
         <div class="col-md-1">                           
         </div>
      </div>

      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-3">         
            <p style="font-size: 18px">Manutenção do Site</p>
         </div>
         <div class="col-md-2">        
             <a class="btn btn-outline-success btn_link" href="cadastro_imovel.php?acao=alteracao&comportamento=exibir_listagem" role="button"><img src="../images/casa.svg"> Imóvel</a>
         </div>
         <div class="col-md-2">
             <a class="btn btn-outline-success btn_link" href="cadastro_tipo.php?acao=alteracao&comportamento=exibir_listagem" role="button"><img src="../images/tipo.svg"> Tipo Imóvel</a>
         </div>
         <div class="col-md-2">
             <a class="btn btn-outline-success btn_link" href="cadastro_cep.php?acao=alteracao&comportamento=exibir_listagem" role="button"><img src="../images/mail.svg"> CEP</a>
         </div>

         <div class="col-md-2 text-right">
             <a class="btn btn-outline-success btn_link" href="login.php?acao=logout&comportamento=vazio" role="button"><img src="../images/sair.svg"> Sair</a>
         </div>        
         
      </div>   
   </header>  



   <div class="container">
      
      <div class="row">
         <div class="col-md-12">
            <br>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <?=$_SESSION['usuario']?><br>
            Essa é a tela de manutenção dos cadastros do SITE
            <br><br>
            <a href="cadastro_imovel.php?acao=inclusao&comportamento=exibir_formulario&frm_imovel=0">Click Aqui</a> para cadastrar um NOVO IMÓVEL
            <br><br>
            <a href="cadastro_imovel.php?acao=alteracao&comportamento=exibir_listagem">Click Aqui</a> para alterar os dados de um IMÓVEL
         </div>
      </div>
      

      
   </div> <!-- container -->

   <footer class="fixed-bottom">
      <div class="row">
         <div class="col-md-12">
            <nav class="navbar navbar-light cor_verde">
               <a target="_blank" class="btn btn-outline-success btn_link" href="/imobiliaria/" role="button">Abrir o Site</a>
            </nav>
         </div>
      </div> 
   </footer>


   <!--  -->
   <script src="../dist/js/load-image/load-image.all.min.js"></script>
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/js/upload.js"></script>


   <script type="text/javascript">
     
   </script>     
   

</body>

</html>
