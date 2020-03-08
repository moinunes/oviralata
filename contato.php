<?php
session_start();

include_once 'cadastro/enviar_email_hlp.php';
include_once 'cadastro/utils.php';

if ( isset($_REQUEST['acao']) && $_REQUEST['acao']=='enviar_email' ) {
   enviar_email();
} else {
   exibir_formulario();
}

function exibir_formulario() {
   exibir_html_inicial();
   
   $nome     = isset($_REQUEST['frm_nome'])     ? trim($_REQUEST['frm_nome'])    : '';
   $email    = isset($_REQUEST['frm_email'])    ? trim($_REQUEST['frm_email'])   : '';
   $assunto  = isset($_REQUEST['frm_assunto'])  ? trim($_REQUEST['frm_assunto']) : '';
   $mensagem = isset($_REQUEST['frm_mensagem']) ? trim($_REQUEST['frm_mensagem']): '';

   ?>

   <?php  
   include_once 'cabecalho.php';
   ?>

   <form id="frmContato" name="frmContato" class="form-horizontal" action="contato.php" method="post" role="form" >
      <div id='div_buscar'></div>         

      <input type="hidden" id="acao" name="acao" value = "enviar_email">
      

      <div class="row fundo_cinza_1">            
         <div class="col-12 altura_linha_2">
         </div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3 text-center">
             <span class="font_preta_g">Fale Conosco</span>
         </div>
      </div>
   
      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_nome">Nome*</label>
            <input type="text" class="form-control form-control-sm" id="frm_nome" name="frm_nome" required maxlength="70" placeholder='seu nome' value="<?=$nome?>" />
         </div>
      </div>
      
      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_email">E-mail*</label>
            <input type="email" class="form-control form-control-sm" id="frm_email" name="frm_email" required  maxlength="70" placeholder='seu e-mail' value="<?=$email?>" />
         </div>
      </div>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_assunto">Assunto*</label>               
            <input type="text" class="form-control form-control-sm" id="frm_assunto" name="frm_assunto" required  maxlength="70" placeholder='assunto' value="<?=$assunto?>" />
       </div>
      </div>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_senha_r">Mensagem*</label>               
            <textarea id='frm_mensagem' name='frm_mensagem' class="form-control form-control-sm" rows="6" required ><?=$mensagem?></textarea>
         </div>
      </div>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3">               
            <div id='div_mens_inclusao' class="font_vermelha_m"></div>              
         </div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3 text-center">               
            <input type="submit" name="btnEnviar" class="btn btn_inserir_anuncio" value="Enviar">
         </div>
      </div>
      
   </form>
      
<?php
exibir_html_final();
}?>

<?php  
function enviar_email() {
   exibir_html_inicial();   
   include_once 'cabecalho.php';

   Utils::obter_links( $link_site, $link_blog, $link_grupo_face_oviralata, $link_pagina_face );

   $assunto = $_REQUEST['frm_assunto'];
   $nome    = $_REQUEST['frm_nome'];

   $mensagem = "<br>";
   $mensagem = "<img src='cid:logo' alt='logo' />";
   $mensagem .= "<br>";
   $mensagem .= "Assunto: {$assunto}";
   $mensagem .= "<br>";
   $mensagem .= "Contato: {$nome}";
   $mensagem .= "<br><br>Mensagem:<br>";
   $mensagem .= $_REQUEST['frm_mensagem'];
   $mensagem .= "<br><br>";
   $mensagem .= "<br><br>";

   $mensagem .= $link_site."<br>";
   $mensagem .= $link_blog."<br>";
   $mensagem .= $link_grupo_face_oviralata."<br>";
   $mensagem .= $link_pagina_face."<br>";
   $mensagem .= " <br>";
   
   $email = new Enviar_Email_Hlp();
   $email->email_responder_para = $_REQUEST['frm_email'];
   $email->nome_responder_para  = $_REQUEST['frm_nome'];
   $email->email_destinatario   = 'contato@oviralata.com.br';
   $email->assunto              = 'oViraLata - CONTATO';
   $email->mensagem             = nl2br($mensagem);
   $email->enviar_email();
   $vetor = array( 'resultado' => $email->enviado );
   ?>

   <div class="form-group">
      <div class="col-12 text-center">
         <br><br><br>
         <span>Olá, </span> 
         <span><?=$_REQUEST['frm_nome']?></span>         
         <br><br>   
         <span>Seu e-mail foi enviado com sucesso!</span> 
      </div>
   </div>
      
<?php
exibir_html_final();
}?>

  
<?php
function exibir_html_inicial() {?>
   <!DOCTYPE HTML>
      <html lang="pt-br">
      <head>
         <?php Utils::meta_tag() ?>

         <!-- Bootstrap styles -->
         <link rel="stylesheet" href="dist/bootstrap-4.1/css/bootstrap.min.css">
         <link rel="stylesheet" href="dist/jquery-ui/jquery-ui.min.css" >
           
          <!-- estilo.css -->  
         <link rel="stylesheet" href="dist/css/estilo.css" >
         
         <script src="dist/js/jquery-3.3.1.min.js"></script>
         <script src="dist/jquery-ui/jquery-ui.min.js"></script>
         <script src="dist/bootstrap-4.1/js/popper.min.js"></script>
         <script src="dist/bootstrap-4.1/js/bootstrap.min.js"></script>
      </head>

      
      <body>

      <div class="container-fluid">
<?php 

} // html_inicial

function exibir_html_final() {?>
   </div> <!-- container -->

   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <br>
            <br>
            <br><br>
         </div>            
      </div>
   </div> <!-- container -->

   <?php  
   include_once 'rodape_1.php';
   ?>

   </body>
   </html>
<?php 
} // exibir_html_final