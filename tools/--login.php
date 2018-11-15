<?php
include_once './utils.php';
session_start();

if ( isset($_REQUEST['acao']) && $_REQUEST['acao']=='logout' ) {
   logout();
}

if ( isset($_REQUEST['frm_usuario']) ) {
   if ( validar_login() ) { 
      header("Location: index.php");
   }
}

function validar_login() {
   $resultado = false;
   if ( $_REQUEST['frm_usuario']=='moinunes' ) {
      $resultado = true;
      $_SESSION['login'  ] = true;
      $_SESSION['usuario'] = 'moinunes';
   }   
   return $resultado;
}

function logout() {   
   if(isset($_SESSION['login'])){
       session_destroy();
       header("Location:login.php");
   }
}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Imobiliaria</title>

   <meta charset="utf-8" />
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
<div class="row  fundo_branco_1">
   <div class="col-1">
   </div>
   <div class="col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 text-center">
      <img src="./images/logo.png" >
   </div>
   <div class="col-7 col-sm-6 col-md-4 col-lg-3 col-xl-3 text-right">     
      <span class="font_azul_p"><?php Utils::exibir_data_extenso();?></span>
   </div>   


</div>
   </header>  

   <form id="frmLogin" class="form-horizontal" action="login.php" method="POST" role="form">
   
   <div class="container">
   
      <div class="row">            
         <div class="col-12 altura_linha_2"></div>
      </div>



      <div class="row">
         <div class="col-12 col-sm-6 col-md-4 col-lg-8 col-xl-4 border"> 
            
            <div class="row">
               <div class="col-md-12">
                  <label for="frm_usuario">Usuário</label>               
                  <input type="text" class="form-control form-control-sm" id="frm_usuario" name="frm_usuario" value="moinunes">            
               </div>      
            </div>

            <div class="row">
               <div class="col-md-12">
                  <label for="frm_usuario">Senha</label>
                  <input type="text" class="form-control form-control-sm" id="frm_senha" name="frm_senha" value="sucesso">
               </div>
            </div>

            <div class="row">
               <div class="col-md-12">
                  <div class="text-right">
                     <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Entrar">
                  </div>
               </div>
            </div>

         </div>
      </div>

   </div> <!-- /container -->

</form>

<!--  -->
<script src="../dist/js/jquery-3.3.1.min.js"></script>
   

</body>

</html>
