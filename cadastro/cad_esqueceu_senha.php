<?php
ini_set('display_errors', true); error_reporting(E_ALL);
session_start(); 

include_once 'conecta.php'; 
include_once 'cad_usuario_hlp.php'; 
include_once 'utils.php';
include_once 'enviar_email_hlp.php';


verificar_acao();

function enviar_email($dados_usuario, $codigo_ativacao) {
   $href = "https://oviralata.com.br/cadastro/cad_esqueceu_senha.php?comportamento=lembrar_senha&codigo_ativacao=".$codigo_ativacao;
   $link  = "<a class='btn btn-success' href='".$href."'>";
   $link .= "Clique aqui para redefinir sua Senha";
   $link .= "</a>";

   $mensagem = "<br>";
   $mensagem = "<img src='cid:logo' alt='logo' /><br>";
   $mensagem .= "Portal de anúncios PET<br>";
   $mensagem .= "Amor e respeito aos Animais!<br>";

   $mensagem .= "<br>";
   $mensagem .= " Olá, {$dados_usuario->nome_completo}<br>";
   $mensagem .= " Por favor, clique no link abaixo para redefinir sua Senha! <br>";
   $mensagem .= " <br>";
   $mensagem .= $link;
   $mensagem .= " <br><br>";
   $mensagem .= " Atenciosamente, <br>";
   $mensagem .= " oViraLata <br>";
   
   $assunto     = 'Por favor valide sua conta no site oViraLata';
        
   $email = new Enviar_Email_Hlp();
   $email->email_responder_para = 'contato@oviralata.com.br';
   $email->nome_responder_para  = 'oViraLata';
   $email->email_destinatario   = $dados_usuario->email;
   $email->nome_destinatario    = $dados_usuario->apelido;
   $email->assunto              = $assunto;
   $email->mensagem             = $mensagem;
   $email->enviar_email();
   
   $sucesso = $email->enviado;
   //.. e se o email não foi enviado ??? pensar em algo 
} 

   function exibir_formulario() {  
      $email = '';
      if ( isset($_REQUEST['frm_email']) ) {
        $email = $_REQUEST['frm_email']; 
      } 

      exibir_html_inicial();
      ?>
       <form action="cad_esqueceu_senha.php" method="POST" name="formulario" onsubmit="Javascript:return validar_email()"   > 
         <input type="hidden" id="acao"          name="acao"          value = "alteracao">
         <input type="hidden" id="comportamento" name="comportamento" value = "redefinir_senha">
        
         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <br><br>
               <img src="../images/logo.png" >
            </div>
         </div>

         
         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <br>
               <label><hr class="hr1">Redefinir sua senha<hr class="hr1"></label>
               <br><br>
            </div>

         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label class="font_cinza_m">Digite seu email e clique em enviar </label>
               <input type="email" id="frm_email" name="frm_email" class="form-control form-control-sm" placeholder="digite seu e-mail" required="required" value="<?=$email?>" >    
            </div>
         </div>

         
         <div class="form-group">
            <div class="col-12 text-center">
               <input type="submit" value="Enviar" class="btn btn-success btn_enviar" >
            </div>         
         </div>


         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <div id='div_email' class="font_vermelha_m"></div>
            </div>
         </div>


         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <a class="link_a" href="cad_usuario.php?acao=inclusao&comportamento=exibir_formulario_inclusao&id_usuario=" role="button">Quero me Cadastrar</a>
            </div>         
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <a class="link_a" href="../index.php" role="button">Voltar</a>
            </div>         
         </div>

      </form>
   <?php
    exibir_html_final();
   } // exibir_formulario

   function exibir_formulario_redefinir_senha() {
      $email = $_REQUEST['frm_email'];
      //..
      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_email($email);
      $usuario->obter_dados_usuario( $dados_usuario );

      if ( $dados_usuario->codigo_ativacao != '' ) {
         $codigo_ativacao = $dados_usuario->codigo_ativacao;
      } else {
         $usuario->obter_codigo_ativacao( $codigo_ativacao, $dados_usuario->id_usuario );
      }

      enviar_email($dados_usuario,$codigo_ativacao);
      
      $mens  = " Olá, {$dados_usuario->nome_completo}<br>";
      $mens .=" Dentro de minutos você receberá um e-mail com as instruções de reinicialização de sua senha.<br>";
      $mens .="<br>";
      $mens .= " É só verificar o seu e-mail <br>";
      $mens .= " e clicar no link que lhe enviamos.";

      $obs  = "Obs: Se você não encontrou o e-mail na Caixa de entrada, verifique também sua pasta Spam ou lixo eletrônico.<br>";
    
      exibir_html_inicial();
      ?>
      <form action="cad_lembrar_senha.php" method="POST" name="formulario"  > 


         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <br>
               <img src="../images/logo.png" >
               <span class="font_verde_g"> oViraLata!</span>
            </div>
         </div>

         <div class="row fundo_verde_claro">
            <div class="col-12 border">

               <div class="form-group">
                  <div class="col-md-6 offset-md-3 text-center">
                     <span class="font_preta_m"><?=$mens?></span>
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-md-6 offset-md-3 text-center">
                     <span class="font_cinza_p"><?=$obs?></span>
                  </div>
               </div>

            </div>
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <br>
            </div>         
         </div>

         <div class="row text-center">
            <div class="col-12 altura_linha_2"></div>
         </div>
         <!-- depois do rodapé -->
         <div class="row">
            <div class="col-12 text-center" style="border-color: #f3f9f0;" >
              <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-2582645504069233",
    enable_page_level_ads: true
  });
</script>           
            </div>
            <br><br><br>
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <span class="font_laranja_2">
                  <br><br>
                  Obrigado por utilizar o site oViraLata! 
               </span>  
            </div>         
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <a class="link_a" href="../index.php" role="button">Início</a>
               <br><br>
            </div>         
         </div>

      </form>

   <?php
   exibir_html_final();
   }
   
   function exibir_formulario_final() {

      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($_REQUEST['id_usuario']);
      $usuario->set_senha($_REQUEST['frm_senha']);
      $usuario->redefinir_senha();
      
      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($_REQUEST['id_usuario']);
      $usuario->obter_dados_usuario( $dados_usuario );

      Utils::set_session( $dados_usuario->id_usuario ); //.. seta a sessão do usuario

      $mens  = "</br>";
      $mens .= " Olá, {$dados_usuario->nome_completo}<br><br>";
      $mens .=" Sua senha foi alterada com sucesso<br>";
      $mens .="<br>";
     
      exibir_html_inicial();
      ?>
      <form action="cad_lembrar_senha.php" method="POST" name="formulario"  > 
         <input type="hidden" id="acao" name="acao" value = "redefinir_senha">

         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <br>
               <img src="../images/logo.png" >

            </div>
         </div>
        
         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <br>
               <label><hr class="hr1"><?=$mens?>
               <br>
               <hr class="hr1"></label>
               <br><br><br>
            </div>

         </div>

         <div class="form-group fundo_azul_claro">
            <div class="col-md-6 offset-md-3">
            banner<br><br><br>   
            </div>         
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <a class="btn btn_inserir_anuncio" href="cad_anuncio.php?acao=inclusao&comportamento=exibir_formulario">Quero Anunciar</a>
            </div>         
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <a class="link_a" href="../index.php" role="button">Voltar</a>
            </div>         
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
            </div>         
         </div>

      </form>

   <?php
      exibir_html_final();
   }

   function exibir_html_inicial() {?>
      <!DOCTYPE HTML>
      <html lang="pt-br">
      <head>         
         <?php
         Utils::meta_tag();
         ?>
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
   <?php 
   } // html_inicial

   function exibir_html_final() {?>
         </div> <!--  container -->
       </body>
      </html>
   <?php 
   } // html_final

   function igualar_formulario() {
      $_REQUEST['frm_modo'] ='';
      if ($_REQUEST['modo']=='email_invalido') {
         $link="cad_usuario.php?acao=inclusao&comportamento=exibir_formulario_inclusao&id_usuario=";
         $_REQUEST['frm_modo']  = 'Seu e-mail não está cadastrado.<br>';
         $_REQUEST['frm_modo'] .= '<span class="font_preta_p">Confira se digitou o email corretamente. ';
      }
   }

   function exibir_formulario_lembrar_senha() {
      $codigo_ativacao = $_REQUEST['codigo_ativacao'];
      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_codigo_ativacao($codigo_ativacao);
      $usuario->obter_dados_usuario( $dados_usuario );       
      if ( $dados_usuario != '' ) {
         $id_usuario = $dados_usuario->id_usuario;         
         $senha    = '';
         $senha_r  = '';
         $div_mens = '';         
         if ( isset($_REQUEST['frm_senha']) ) {
            $senha = $_REQUEST['frm_senha'];
         }
         if ( isset($_REQUEST['frm_senha']) ) {
            $senha = $_REQUEST['frm_senha'];
         }
         if ( isset($_REQUEST['frm_senha_r']) ) {
            $senha_r = $_REQUEST['frm_senha_r'];
         }
         if ( isset($_REQUEST['div_mens']) ) {
            $div_mens = $_REQUEST['div_mens'];
         }

         exibir_html_inicial();
         ?>
         <form id="frmCadUsuario" name="frmCadUsuario" class="form-horizontal" action="cad_esqueceu_senha.php" method="post" role="form" onsubmit="Javascript:return validar_senhas()"  >

            <div id='div_buscar'></div>         

            <input type="hidden" id="acao"            name="acao"            value = "alteracao">
            <input type="hidden" id="comportamento"   name="comportamento"   value = "efetivar">
            <input type="hidden" id="id_usuario"      name="id_usuario"      value = "<?=$id_usuario?>"> 
            <input type="hidden" id="codigo_ativacao" name="codigo_ativacao" value = "<?=$codigo_ativacao?>">
            
            <div class="form-group">
               <div class="col-md-6 offset-md-3 text-center">
               <div class="col-12 altura_linha_1"></div>
            </div>
            
            <div class="row">
                <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3 text-center">
                  <img src="../images/logo.png" >
               </div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3 text-center">
                   <span class="font_cinza_g">Olá <?=$dados_usuario->nome_completo?></span>
               </div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3 text-center">
                   <span class="font_cinza_g">Por favor, informe sua nova senha</span>
               </div>
            </div>

            <div class="row">
                <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3">
                  <label for="frm_email">E-mail:</label>
                  <span class="font_cinza_g"><?=$dados_usuario->email?></span>           
                </div>
            </div>

            <div class="row">
                <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3">
                  <label for="frm_senha">Nova senha*</label>               
                  <input type="password" class="form-control form-control-sm" id="frm_senha" name="frm_senha" required   placeholder='Senha (mínimo 6 caracteres)'  value="<?=$senha?>"  />
               </div>
            </div>

            <div class="row">
                <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3">
                  <label for="frm_senha_r">Confirmar a nova senha*</label>               
                  <input type="password" class="form-control form-control-sm" id="frm_senha_r" name="frm_senha_r" required  placeholder='confirme a senha'  value="<?=$senha_r?>"   />
               </div>
            </div>

            <div class="row">
                <div class="col-12 altura_linha_1"></div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3 text-center">               
                  <input type="submit" name="btnCadastrar" class="btn btn-success btn_enviar" value="Cadastrar">
               </div>
            </div>

             <div class="form-group">
               <div class="col-md-6 offset-md-3">
                  <div id='div_mens' class="font_vermelha_m"><?=$div_mens?></div>               
               </div>
            </div>

            <div class="form-group">
               <div class="col-md-6 offset-md-3">
                  <br><br><br>
                  <a class="link_a" href="../index.php" role="button">Voltar</a>
               </div>         
            </div>
            
            
         </form>      
      <?php
      } else {?>
         <input type="hidden" id="comportamento"   name="comportamento"   value = "efetivar">         
         <input type="hidden" id="acao"            name="acao"            value = "alteracao">
         <input type="hidden" id="id_usuario"      name="id_usuario"      value = "<?=$id_usuario?>"> 
         <input type="hidden" id="codigo_ativacao" name="codigo_ativacao" value = "<?=$codigo_ativacao?>"> 

         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
            <div class="col-12 altura_linha_1"></div>
         </div>


         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3 text-center">
               <img src="../images/logo.png" >
            </div>
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <span class="font_vermelha_m">Seu código de validação está expiradado</span><br>
               <span class="font_cinza_m">por favor clique no link abaixo.</span>
            </div>
         </div>
         
          <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <br>
               <a class="link_a" href="cad_esqueceu_senha.php?acao=alteracao&comportamento=exibir_formulario&modo=&frm_email=" role="button">Esqueci minha senha</a>
            </div>         
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <a class="link_a" href="cad_usuario.php?acao=inclusao&comportamento=exibir_formulario_inclusao&id_usuario=" role="button">Quero me Cadastrar</a>
            </div>         
         </div>

         <div class="form-group">
            <div class="col-md-6 offset-md-3">
                  <br><br><br>
                  <a class="link_a" href="../index.php" role="button">Voltar</a>
            </div>         
         </div>

      <?php
      exibir_html_final();
      }?>

      <?php
      }

   

   function verificar_acao() {      
      if ( isset($_REQUEST['comportamento']) ) {
         $comportamento = $_REQUEST['comportamento'];
      } else {
         $comportamento = '';
      }
      
      switch ($comportamento) {         
         case 'exibir_formulario':           
            igualar_formulario();
            exibir_formulario();
            break;

         case 'redefinir_senha':
            exibir_formulario_redefinir_senha();
            break;

         case 'exibir_formulario_ok':
            igualar_formulario();
            exibir_formulario_ok();
            break;

         case 'lembrar_senha':
            exibir_formulario_lembrar_senha();
            break;           

         case 'efetivar':
            exibir_formulario_final();
            break;

         default:
            die(' vixi...');
            break;
      }

   } // verificar_acao
   ?>
   
   <script type="text/javascript">

   function validar_email() {
      var retorno = true;
      _email = $('#frm_email').val();
      $("#div_email").html("");
      $.ajax({ 
         url: 'cad_usuario_hlp.php',
         type: "POST",
         async: false,
         dataType: "html",
         data: { 
            acao: 'obter_usuario',         
            email: _email
         },
         success: function(resultado){  
            var res = JSON.parse(resultado);
            if ( res.status=='ok' ) {
               retorno = true;
            } else {
               $("#div_email").addClass("font_vermelha_m");
               $('#div_email').append( 'E-mail não cadastrado!' );         
               retorno = false;
            }              
         },
         failure: function( errMsg ) { alert(errMsg); } 
      });      
      return retorno;   
   } // validar_email

   function validar_senhas() { 
      $("#div_mens").addClass("font_vermelha_m");
      $("#div_mens").html("");
      _senha   = $("#frm_senha").val();
      _senha_r = $("#frm_senha_r").val();
      _result = true;
      if (_senha != _senha_r ) {
         $('#div_mens').append( 'As duas senhas devem ser iguais!'+'<br>' );         
         _result = false;
      }
      if ( _senha.length<4 ) {
         $('#div_mens').append( 'A senha deve ter no mínimo 4 caracteres!' );         
         _result = false;
      }
      return _result;
   } // validar_senhas

   </script>
