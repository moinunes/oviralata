<?php
if(!isset($_SESSION)) {
   session_start();
} 

include_once 'cad_usuario_hlp.php';
include_once 'enviar_email_hlp.php';   
include_once 'utils.php';

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <?php Utils::meta_tag() ?>
    
   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="../dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body>

      
   <div class="container">
   
      <?php 
      
      verificar_acao();

      function exibir_formulario_validar_email() {
         $codigo_ativacao = $_REQUEST['codigo_ativacao'];

         $usuario = new Cad_Usuario_Hlp();
         $usuario->set_codigo_ativacao($codigo_ativacao);
         $usuario->obter_dados_usuario( $consulta_usuario );
 
         $usuario->ativar_usuario($consulta_usuario->id_usuario); 
         Utils::set_session($consulta_usuario->id_usuario);
         header("Location: ".'cad_usuario.php'."?acao=alteracao&comportamento=exibir_formulario_alteracao&id_usuario=".$consulta_usuario->id_usuario );

      } //  exibir_formulario_validar_email

      function verificar_acao() {
         $comportamento = isset($_REQUEST['comportamento']) ? $_REQUEST['comportamento'] : '' ;
   

         if( $_REQUEST['acao']=='inclusao' && $comportamento=='verificar_email' ) {
            exibir_formulario_verificar_email();
         }

         if( $_REQUEST['acao']=='alteracao' && $comportamento=='alteracao_ok' ) {
            exibir_formulario_alteracao_ok();
         }

         if( $_REQUEST['acao']=='validar_email') {
            exibir_formulario_validar_email();
         }

         switch ($comportamento) {         
         
            case 'efetivar':
               efetivar();
               break;

            default:
               die( '');
               break;
         }

      } // verificar_acao


      ?>

   </div> <!-- container -->


</body>

</html>
