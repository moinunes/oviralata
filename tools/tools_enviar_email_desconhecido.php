<?php
session_start(); 

include_once '../cadastro/utils.php';
include_once '../cadastro/conecta.php';
include_once '../cadastro/infra_cod_erro.php';
include_once '../cadastro/enviar_email_hlp.php';

ini_set('display_errors', true); error_reporting(E_ALL);

Utils::validar_login_tools();

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <meta charset="utf-8">
   <meta name="keywords"    content="AdotaBrasil,Pet,Feliz,Doação de Pets,cão,gato,roedor,ração, doação de cão e gato"/>
   <meta name="description" content="O AdotaBrasil é um site de anúncios, voltado para Adoção e Doação de cães, gatos e outros pets, filhote ou adulto. Adote essa idéia.">   
   <meta name="viewport"    content="width=device-width, initial-scale=1, maximum-scale=1">

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
            <a class="btn btn-outline-success btn_link" href="tools_marketing_desconhecido.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/voltar.svg" >Voltar</a>
         </div>
      </div>
   </header>  

<div class="container">

   <?php
   verificar_acao();
   ?>
   <?php
   
   function exibir_listagem() { 
      $titulo = 'Enviar E-mails para Desconhecido';      
      $limit = 50;     
      obter_emails( $emails, $limit );
      obter_totais_emails( $dados );
      ?>
      <form id="frmEnviarEmail" class="form-horizontal" action="tools_enviar_email_desconhecido.php" method="POST" role="form">
         <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">
         <input type="hidden" id="acao" name="acao" value = "<?=$_REQUEST['acao']?>">
         
         <div class="row">
            <div class="col-12">         
               <span class="destaque_1"><?=$titulo?></span>
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
               <input type="checkbox" id="checkTodos" name="checkTodos" checked="checked" > Selecionar Todos
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
         foreach ( $emails as $email ) {
            $id_email = $email->id_email;
            ?>
            <div class="row">            
               <div class="col-12 altura_linha_1">
               </div>
            </div>
            <div class="row">
               <div class="col-12" >
                  <input type="checkbox" id="<?='chk_'.$email->id_email?>" name="<?='chk_'.$email->id_email ?>" >&nbsp;<span class="font_azul_m"><?=$email->email?></span>
               </div>  
            </div>            
         <?php
         }?>
      </form>
   <?php 
   } // exibir_listagem
   
   function invalidar_emails() {
      $titulo = 'Invalidar E-mails';   
      $_REQUEST['frm_emails_invalidos'] = !isset($frm_emails_invalidos) ? '' : $_REQUEST['frm_emails_invalidos'];
      ?>
      <form id="frmInvalidarEmails" class="form-horizontal" action="tools_enviar_email_desconhecido.php" method="POST" enctype="multipart/form-data" role="form">
         <div id='div_buscar'></div>
         <input type="hidden" id="comportamento" name="comportamento" value = "efetivar_invalidar_emails">         
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <span class="destaque_3">Invalidar E-mails</span>
            </div>
         </div>
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <label for="frm_descricao">E-mails Inválidos</label>
               <textarea id='frm_emails_invalidos' name='frm_emails_invalidos' class="form-control form-control-sm" rows="5" required placeholder="digitar aqui os e-mails separados por vígula" ><?=$_REQUEST['frm_emails_invalidos']?></textarea>
               <div id='div_descricao' class="font_vermelha_p"></div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Confirmar">
            </div>
         </div>
      </form>
   <?php
   } // invalidar_emails

   
   function obter_enganjamentos( &$emails, $limit = 50  ) {
      $conecta = new Conecta();
      $sql = " SELECT 
                  id_email,
                  email,
                  data,
                  marketing_aceito
               FROM 
                  tbemails
               WHERE ativo='S' AND email_invalido IS NULL
                     AND marketing_aceito IN ('S','N')
               ORDER BY data desc
               limit {$limit}
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $emails = $stmt->fetchAll(PDO::FETCH_CLASS);  
   }   

   function listar_enganjamento() { 
      $titulo = 'Listar enganjamento';
      obter_enganjamentos( $emails, 500 );
      ?>
      <form id="frmEnviarEmail" class="form-horizontal" action="tools_enviar_email_desconhecido.php" method="POST" role="form">
         <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">
         <input type="hidden" id="acao" name="acao" value = "<?=$_REQUEST['acao']?>">
         
         <div class="row">
            <div class="col-12">         
               <span class="destaque_1"><?=$titulo?></span>
            </div>
         </div>
         <div class="row">
            <div class="col-12">                     
               <hr class="hr1">
            </div>
         </div>

         <div class="row">            
            <div class="col-auto">
               <span class="tit_0">Enganjamento</span>
            </div>
            <div class="col-auto">
               <span class="tit_0">Data</span>
            </div>
            <div class="col-auto">
               <span class="tit_0">E-mail</span>
            </div>
         </div>

         <?php
         $i = 0;
         foreach ( $emails as $email ) {
            $id_email = $email->id_email;
            ?>
            <div class="row">            
               <div class="col-12 altura_linha_1">
               </div>
            </div>
            <div class="row">
               <div class="col-auto" >
                  <span class="tit_0"><?=$email->marketing_aceito?></span>
               </div>  
               <div class="col-auto" >
                  <span class="tit_0"><?=$email->data?></span>
               </div>  
               <div class="col-auto" >
                  <span class="tit_0"><?=$email->email?></span>
               </div>  
            </div>            
         <?php
         }?>
      </form>
   <?php 
   } // listar_enganjamento
   



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
            <span class="font_cinza_p">Copyright © 2018 www.oviralata.com.br Todos os direitos reservados. </span>
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
         case 'invalidar_emails':
            invalidar_emails();
            break;
         case 'listar_enganjamento':
            listar_enganjamento();
            break;   
         case 'efetivar':
            efetivar();
            break;
         case 'efetivar_invalidar_emails':
            efetivar_invalidar_emails();
            break;   
         default:
            die(' vixi...');
            break;
      }
   } // verificar_acao

   function obter_emails( &$emails, $limit = 50  ) {
      $conecta = new Conecta();
      $sql = " SELECT 
                  id_email,
                  email,
                  nome,
                  codigo
               FROM 
                  tbemails
               WHERE enviado IS NULL AND ativo='S' AND email_invalido IS NULL
               ORDER BY id_email DESC
               limit {$limit}
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $emails = $stmt->fetchAll(PDO::FETCH_CLASS);  
   }   

   function obter_totais_emails( &$dados ) {
      $dados = new StdClass();
      $conecta = new Conecta();
      //..
      $sql = " SELECT 
                  count(*) as total_a_enviar
               FROM 
                  tbemails
               WHERE enviado IS NULL AND ativo='S' AND email_invalido IS NULL 
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      $dados->total_a_enviar = $resultado->total_a_enviar;
      //..
      $sql = " SELECT 
                  count(*) as total_enviado
               FROM 
                  tbemails
               WHERE enviado IS NOT NULL AND ativo='S' AND email_invalido IS NULL
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

   function obter_email( &$email, $id_email ) {
      $conecta = new Conecta();
      $sql = " SELECT 
                  id_email,
                  email,
                  nome,
                  codigo
               FROM 
                  tbemails
               WHERE id_email={$id_email} AND ativo='S' AND email_invalido IS NULL 
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $email = $stmt->fetch(PDO::FETCH_OBJ); 
   }   
   
   function atualizar_envio($id_email) {
      $conecta = new Conecta();
      try {
         $conecta->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbemails
                  SET enviado ='S'
                  WHERE id_email={$id_email} ";
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
            $array_email = explode( '_', $campo );
            $id_email = $array_email[1];
            obter_email( $do_email, $id_email );
            enviar_email($do_email);
            atualizar_envio($id_email);
         }
      }
      print ' E-mails enviados com sucesso!';     
   } // efetivar

   function efetivar_invalidar_emails() {
      $array_emails = explode( ',', $_REQUEST['frm_emails_invalidos'] );
      foreach( $array_emails as $i => $email ) {         
          invalidar_o_email($email);
      }
      print '<span class="destaque_3">Invalidar E-mails</span><br><br>';
      print ' E-mails INVÁLIDADOS com sucesso!';   
   } // efetivar_invalidar_emails

   function invalidar_o_email($email) {
      $email = trim($email);
      $conecta = new Conecta();
      try {
         $conecta->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbemails
                  SET email_invalido ='S'
                  WHERE email='{$email}' ";
         $stmt = $conecta->con->prepare($sql);
         $stmt->execute();
         
      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
         die(' erro: function invalidar_o_email ');
      }
      return null;
   }
   
  function enviar_email( $do_email ) {
      $id_email       = $do_email->id_email;
      $email_destino  = $do_email->email;      
      $mensagem = 
               "  <table>
                     <tr>
                        <td>
                           <br>
                           <span style='font-size:16px'>
                              Olá, tudo bem?                            
                           </span>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <span style='font-size:16px'>
                              <br>
                              Pensando em Adotar ou Doar um Pet?<br>
                              <strong>Doação e Adoção de Cães e Gatos</strong> e outros animais de estimação.<br>
                              E também um local exclusivo para ajudar a encontrar os <strong>Animais DESAPARECIDOS</strong>
                           </span>
                        </td>
                     </tr>
                  </table                  
                  <table>
                     <tr>
                        <td>
                           <br>
                           <a href='www.oviralata.com.br/cadastro/remover_email_da_lista.php?email={$email_destino}&marketing_aceito=S' >
                              <span style='font-size:16px'>
                                  <strong>Saiba mais sobre a Doação e Adoção de Cães e Gatos</strong>
                              </span>
                           </a>
                        </td>
                     </tr> 
                  </table>
                  <table>
                     <tr>
                        <td>
                           <br>
                           <span style='font-size:15px'>
                              Abraços,<br>
                           </span>
                           <span style='font-size:15px'>
                              Moises<br>Amor e respeito aos Animais<br>
                           </span>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <br><br>
                           <span style='font-size:16px'>
                              Caso não queira mais receber nossos emails,
                           </span>
                           <span style='font-size:15px'>
                              <a href='www.oviralata.com.br/cadastro/remover_email_da_lista.php?email={$email_destino}&marketing_aceito=N' >
                                 remova aqui.
                              </a>
                           </span>
                        </td>
                     </tr>                  
                  </table>               
               ";      
      $email = new Enviar_Email_Hlp();
      $email->tem_logo='N';
      $email->email_nome = 'Amor aos Animais';
      $email->email_responder_para = 'contato@oviralata.com.br';
      $email->nome_responder_para  = '';
      $email->email_destinatario   = $email_destino;
      $email->nome_destinatario    = '';
      $email->assunto              = 'Doação e Adoção de cães e gatos';
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
