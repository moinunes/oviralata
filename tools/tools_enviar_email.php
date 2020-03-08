<?php
session_start(); 

include_once '../cadastro/utils.php';
include_once '../cadastro/conecta.php';
include_once '../cadastro/infra_cod_erro.php';
include_once '../cadastro/enviar_email_hlp.php';
include_once 'tools_cad_usuario_hlp.php';

ini_set('display_errors', true); error_reporting(E_ALL);

Utils::validar_login_tools();

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
   <link rel="stylesheet" href="../dist/fonts/fonts.css" >
   
</head>

<body class="fundo_cinza_1">

   <header>
      <?php include_once 'tools_cabecalho.php';?>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-5 text-right">            
            <a class="btn btn-outline-success btn_link" href="tools_marketing.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/voltar.svg" >Voltar</a>
         </div>
      </div>

      
   </header>  

<div class="container">

   <?php
   verificar_acao();
   ?>


   <?php
   
   function exibir_listagem() { 
      $titulo = 'Enviar E-mails';

      $limit = 10;     
      obter_usuarios( $usuarios, 'enviar_email', $limit );
      obter_totais_emails( $dados );

      ?>

         <form id="frmEnviarEmail" class="form-horizontal" action="tools_enviar_email.php" method="POST" role="form">
            <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">
            <input type="hidden" id="acao" name="acao" value = "<?=$_REQUEST['acao']?>">
            
            <div class="row">
               <div class="col-md-3">         
                  <span class="destaque_3"><?=$titulo?></span>
               </div>
            </div>

            <div class="row">
               <div class="col-12">                     
                  <hr class="hr1">
               </div>
            </div>  

            <div class="row">
            
               <div class="col-2">
                   <span class="font_cinza_g"><?='Limite diário: '.$limit?></span>
               </div>

               <div class="col-2">
                   <span class="font_cinza_g"><?='Enviados: '.$dados->total_enviado?></span>
               </div>
               <div class="col-2">
                   <span class="font_cinza_g"><?='À Enviar: '.$dados->total_a_enviar?> </span>                
               </div>

               <div class="col-2">
                   <span class="font_cinza_g"><?='Inválidos: '.$dados->total_invalidos?> </span>                
               </div>            
            </div>

            <div class="row">
               <div class="col-12">                     
                  <hr class="hr1">
               </div>
            </div>  
          
            <div class="row">
               <div class="col-2">
                  <input type="checkbox" id="checkTodos" name="checkTodos"  > Selecionar Todos
               </div> 
               <div class="col-2">
                  <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Enviar">
               </div>            
            </div>
                      
            <div class="row">
               <div class="col-12">                     
                  <hr class="hr1">
               </div>
            </div>  

            <?php
         
      
            $i = 0;
            foreach ( $usuarios as $usuario ) {
               $id_usuario = $usuario->id_usuario;
               ?>
               <div class="row">            
                  <div class="col-12 altura_linha_1">
                  </div>
               </div>

               <div class="row">
                  <div class="col-12" >
                     <input type="checkbox" id="<?='chk_'.$usuario->id_usuario?>" name="<?='chk_'.$usuario->id_usuario ?>"  >&nbsp;<span class="font_azul_m"><?=$usuario->email.' --> '.$usuario->nome_completo?></span>
                  </div>  
               </div>
            
            <?php
            }?>
         </form>
      <?php 
      } // exibir_listagem
      ?>


   <?php
   function exibir_form_liberar_usuarios() {
      obter_usuarios( $usuarios, 'liberar_usuarios' );
      obter_totais_emails( $dados );
      ?>

      <form id="frmInvalidarEmails" class="form-horizontal" action="tools_enviar_email.php" method="POST" role="form">
         <input type="hidden" id="comportamento" name="comportamento" value = "liberar_usuarios_efetivar">
         <input type="hidden" id="acao" name="acao" value = "<?=$_REQUEST['acao']?>">
         
         <div class="row">
            <div class="col-12">         
               <span class="text">Liberar Usuários</span>
            </div>
         </div>
         <div class="row">
            <div class="col-12">         
               <span class="tit_0">desmarca o campo email_enviado para o usuário receber e-mail de marketing novamente</span>
            </div>
         </div>

         <div class="row">
            <div class="col-12">                     
               <hr class="hr1">
            </div>
         </div>  

         <div class="row">
         
           
            <div class="col-2">
                <span class="font_cinza_g"><?='Enviados: '.$dados->total_enviado?></span>
            </div>
            <div class="col-2">
                <span class="font_cinza_g"><?='À Enviar: '.$dados->total_a_enviar?> </span>                
            </div>

            <div class="col-2">
                <span class="font_cinza_g"><?='Para Liberar: '.$dados->total_invalidos?> </span>                
            </div>            
         </div>

         <div class="row">
            <div class="col-12">                     
               <hr class="hr1">
            </div>
         </div>  
       
         <div class="row">
            <div class="col-2">
               <input type="checkbox" id="checkTodos" name="checkTodos">Selecionar Todos
            </div> 
            <div class="col-2">
               <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Liberar">
            </div>            
         </div>
                   
         <div class="row">
            <div class="col-12">                     
               <hr class="hr1">
            </div>
         </div>  

         <?php
      
   
         $i = 0;
         foreach ( $usuarios as $usuario ) {
            $id_usuario = $usuario->id_usuario;
            ?>
            <div class="row">            
               <div class="col-12 altura_linha_1">
               </div>
            </div>

            <div class="row">
               <div class="col-12" >
                  <input type="checkbox" id="<?='chk_'.$usuario->id_usuario?>" name="<?='chk_'.$usuario->id_usuario ?>"  >&nbsp;<span class="font_azul_m"><?=$usuario->email.' --> '.$usuario->nome_completo?></span>
               </div>  
            </div>
         
         <?php
         }?>
      
      </form>

   <?php
   } // exibir_formulario
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
   
      <div class="row">
         <div class="col-md-12 border">
            <br>
            <span class="font_cinza_p">Copyright © 2018 www.adotabrasil.com.br Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>         
   
   </div> <!-- container -->

   <!--  -->

   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>
   

   <?php
   function verificar_acao() {
      $comportamento = $_REQUEST['comportamento'];

      switch ($comportamento) {         
         
         case 'exibir_listagem':
            exibir_listagem();
            break;

         case 'liberar_usuarios':
            exibir_form_liberar_usuarios();
            break;

         case 'efetivar':
            efetivar();
            break;

         case 'liberar_usuarios_efetivar':
            liberar_usuarios_efetivar();
            break;   

         default:
            die(' vixi...');
            break;
      }

   } // verificar_acao

   function obter_usuarios( &$usuarios, $comportamento, $limit = NULL  ) {
      $limit = $limit != '' ? "limit {$limit}" : '';
      if ($comportamento=='enviar_email') {
         $filtro = "email_enviado IS NULL AND ativo='S' AND bloqueado IS NULL";
      } else {
         $filtro = "email_enviado='S' AND ativo='S' AND bloqueado IS NULL";
      }

      $conecta = new Conecta();
      $sql = " SELECT 
                  id_usuario,
                  nome_completo,
                  apelido,
                  email                  
               FROM 
                  tbusuario
               WHERE {$filtro}
               ORDER BY id_usuario
               {$limit}
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $usuarios = $stmt->fetchAll(PDO::FETCH_CLASS);  
   }   

   function obter_totais_emails( &$dados ) {
      $dados = new StdClass();
      $conecta = new Conecta();
      //..
      $sql = " SELECT 
                  count(*) as total_a_enviar
               FROM 
                  tbusuario
               WHERE email_enviado IS NULL AND ativo='S' AND bloqueado IS NULL
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      $dados->total_a_enviar = $resultado->total_a_enviar;
      //..
      $sql = " SELECT 
                  count(*) as total_enviado
               FROM 
                     tbusuario
               WHERE email_enviado IS NOT NULL AND ativo='S' AND bloqueado IS NULL
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      $dados->total_enviado = $resultado->total_enviado;

      //..
      $sql = " SELECT 
                  count(*) as total_invalidos
               FROM 
                  tbemails
               WHERE email_invalido IS NOT NULL
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      $dados->total_invalidos = $resultado->total_invalidos;

   }

   
   function atualizar_envio($id_usuario) {
      $conecta = new Conecta();
      try {
         $conecta->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbusuario
                  SET email_enviado ='S'
                  WHERE id_usuario={$id_usuario} ";
         $stmt = $conecta->con->prepare($sql);
         $stmt->execute();         
      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
      }
      return null;
   }
    
   function efetivar() {
      foreach( $_REQUEST as $campo => $valor ) {
         if (substr($campo,0,4)=='chk_') {
            $id_usuario = explode( '_', $campo );
            $id_usuario = $id_usuario[1];

            $instancia = new Tools_Cad_Usuario_Hlp();
            $instancia->id_usuario = $id_usuario;
            $instancia->obter_dados_usuario( $usuario );
            $do_usuario = $usuario[0];
 
            enviar_email($do_usuario);
            atualizar_envio($id_usuario);
         }
      }

      print ' E-mails enviados com sucesso!';     
   
   } // efetivar

   function liberar_usuarios_efetivar() {
      foreach( $_REQUEST as $campo => $valor ) {
         if (substr($campo,0,4)=='chk_') {
            $id_usuario = explode( '_', $campo );
            $id_usuario = $id_usuario[1];

            //.. libera
            $conecta = new Conecta();
            $conecta->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = " UPDATE tbusuario
                     SET email_enviado=NULL
                     WHERE id_usuario='{$id_usuario}' ";
            $stmt = $conecta->con->prepare($sql);
            $stmt->execute();
         }
      }

      print ' E-mails liberados com sucesso!';     
   
   } // liberar_usuarios_efetivar

   function enviar_email( $dados ) {
      Utils::obter_links( $link_site, $link_blog, $link_grupo_face_oviralata, $link_pagina_face );
   
      $mensagem = "<br>";
      $mensagem = "<img src='cid:logo' alt='logo' /><br>";
      $mensagem .= "Portal de anúncios PET<br>";
      $mensagem .= "Amor e respeito aos Animais!<br><br>";
      $mensagem .= 
               " <table>
                  <tr>
                     <td>
                        <span style='font-size:16px'>
                        Olá $dados->apelido, como vai você?<br>
                        Gostaria de lhe dizer que o site oViraLata agora está com novo visual.<br>
                        </span>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <span style='font-size:16px'>
                           <b><br>E temos Novidades para você que tem anúncios publicados no site!<b><br>
                        </span>
                        <span style='font-size:14px'>   
                           Agora você pode RENOVAR seus anúncios sempre que desejar...<br>
                           É só acessar seu cadastro na sessão [Meus anúncios] e clicar em RENOVAR.<br>
                        </span>
                        <span style='font-size:16px'>   
                           <b>Ao renovar o anúncio ele irá aparecer entre os primeiros nas pesquisas do site.</b><br>      
                        </span>
                     </td>
                  </tr>
               </table>

               <span style='font-size:15px;color:black;background-color:powderblue;'>   
                  <br>
                  Fique a vontade para RENOVAR.<br>
               </span>
               <span style='font-size:15px;color:black;background-color:powderblue;'>
                  Ou INCLUIR novos anúncios.<br>
               </span>
               ";
      $mensagem .= "<br><br>";
      $mensagem .= "<span style='font-size:16px;color:black;'>
                      $link_site
                    </span>
                   <br><br>";

      $mensagem .= $link_blog."<br>";
      $mensagem .= $link_grupo_face_oviralata."<br>";
      $mensagem .= $link_pagina_face."<br>";
      $mensagem .= " <br>";

      $mensagem .= " <br><br>";
      $mensagem .= " Atenciosamente, <br>";
      $mensagem .= " oViraLata<br>";
      
      $email = new Enviar_Email_Hlp();
      $email->email_responder_para = 'contato@oviralata.com.br';
      $email->nome_responder_para  = 'oViraLata';
      $email->email_destinatario   = $dados->email;
      $email->nome_destinatario    = $dados->apelido;
      $email->assunto              = 'oViraLata! - Novidades para você!';
      $email->mensagem             = $mensagem;

      $email->enviar_email();
      
      $vetor = array( 'resultado' => $email->enviado );
      
   } // enviar_email
  
   ?>  

   <script type="text/javascript">
      //.. marcar/desmarcar todos
      var checkTodos = $("#checkTodos");
      checkTodos.click(function () {
        if ( $(this).is(':checked') ){
          $('input:checkbox').prop("checked", true);
        }else{
          $('input:checkbox').prop("checked", false);
        }
      });
   </script>



</body>

</html>
