<?php
session_start(); 

include_once 'conecta.php'; 
include_once 'cad_usuario_hlp.php'; 
include_once 'utils.php';

$acao = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : '';

if ( $acao == 'logout' ) {
   session_unset();
   session_destroy();
   Utils::set_session(0);
   header("Location: ../index.php");
   exit();
}

if ( $acao == 'logar' ) {
   if ( validar_login() ) {
      header("Location: ".$_SESSION['programa']."?acao={$_SESSION['acao']}&comportamento={$_SESSION['comportamento']}");
   }
}


function validar_login() {
   $_REQUEST['div_mens'] ='';
   $resultado = false;
   $conecta   = new Conecta();
   $email     = $_REQUEST['frm_email'];
   $senha     = $_REQUEST['frm_senha'];
   //..
   $usuario = new Cad_Usuario_Hlp();
   $usuario->set_email($email);
   $usuario->set_senha($senha);
   $usuario->obter_dados_usuario( $dados_usuario );
   if ( $dados_usuario != '' ) {
      Utils::set_session( $dados_usuario->id_usuario);
      //header("Location: cad_anuncio.php?acao=inclusao&comportamento=exibir_formulario");
      header("Location: index.php");
   } else {
      $_REQUEST['div_mens'] = 'E-mail ou Senha incorreta!';
   }
   return $resultado;
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Adotar! Um ato de Amor. Mude sua vida, adote um amiguinho PET. Adoção e Doação de cães, gatos, etc... oViraLata.</title>
   <meta charset="utf-8">   
   <meta name="keywords"    content="adoçao de animais doação-cachorro-gato-oViraLata-Pet Doação de Pets-cão-gato-roedor-ração-doação de cão e gato, amor e respeito aos animais"/>
   <meta name="description" content="Faça seu cadastro no site oViraLata. Anúncios pet gratuítos - Adoção e Doação PET. O site oViraLata também disponibiza espaço para publicação de anúncios de PET DESAPARECIDOS. Adote um amiguinho PET. EM TODO BRASIL">   
   <meta name="viewport"    content="width=device-width, initial-scale=1, maximum-scale=1">

   <!--  .css -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css"> 
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
   <!--  .js -->
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/popper.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.min.js"></script>

</head>

<body>

   <div class="container">
      <form action="cad_login.php" method="POST" name="formulario"  > 
         <input type="hidden" id="acao" name="acao" value = "logar">

         <?php
         if ( !isset($_REQUEST['div_mens']) ) {
            $_REQUEST['div_mens'] = '';         
         }
         if ( !isset($_REQUEST['frm_email']) ) {
            $_REQUEST['frm_email'] = '';         
         }

         ?>
        
         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <br>
               <a href="../index.php"><img src="../images/logo.png"></a>
            </div>
         </div>

         <div class="form-group text-center">
            <div class="   col-md-6 offset-md-3">
               <?php
               include_once 'link_facebook.php'; 
               ?>
            </div>
         </div>
         
         <div class="row">
            <div class="col-12">

               <div class="form-group">
                  <div class="   col-md-6 offset-md-3">
                     <label >Entrar com e-mail e senha!</label>
                     <input type="text" name="frm_email" class="form-control form-control-sm" placeholder="digite o seu e-mail" required="required" value='<?=$_REQUEST['frm_email']?>' >    
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-md-6 offset-md-3">
                     <input type="password" name="frm_senha" class="form-control" placeholder="digite sua senha" required="required" value='' >
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-md-6 offset-md-3">               
                     <div id='div_mens' class="font_vermelha_m"><?=$_REQUEST['div_mens']?></div>              
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-12 text-center">
                     <input type="submit" value="Entrar" class="btn btn-success" />
                  </div>         
               </div>               
            </div>
         </div>           

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <br>
               <a class="link_a" href="cadastro.php" role="button">Quero me Cadastrar</a>
            </div>         
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <a class="link_a" href="cad_esqueceu_senha.php?acao=alteracao&comportamento=exibir_formulario&modo=&frm_email=" role="button">Esqueci minha senha</a>
            </div>         
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <a class="link_a" href="../index.php" role="button">Início</a>
               <br><br>
            </div>         
         </div>

      </form>
   </div>

</body>
</html>

