<?php
session_start(); 

include_once '../cadastro/utils.php';
include_once '../cadastro/conecta.php';
include_once '../cadastro/infra_cod_erro.php';

ini_set('display_errors', true); error_reporting(E_ALL);

Utils::validar_login_tools();

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
         <div class="col-md-3">         
            <p style="font-size: 18px">Marketing-Desconhecidos</p>
         </div>
        <div class="col-md-5 text-right">            
            <a class="btn btn-outline-success btn_link" href="tools_marketing_desconhecido.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/voltar.svg" >Voltar</a>
         </div>
      </div>

      <div class="row">
         <div class="col-12 text-center">
            <span class="font_azul_p">Adiciona e-mails - DESCONHECIDO</span>            
         </div>
      </div>

   </header>  

   <div class="container">

   <?php
   verificar_acao();
   ?>


   <?php
   function exibir_formulario() {?>
          
      <form id="frmUpload" name="frmUpload" class="form-horizontal" action="tools_upload_email_desconhecido.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return validar_submit();">

         <div id='div_buscar'></div>

         <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">         
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
   
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         <div class="row">
            <div class="col-12">
               <label for="frm_descricao">Adicionar novos e-mails</label>
               <textarea id='frm_emails' name='frm_emails' class="form-control form-control-sm" rows="5" required placeholder="email1@gmail.com, email2@gmail.com" ></textarea>
               <div id='div_descricao' class="font_vermelha_p"></div>
            </div>
            <div class="col-12">
               <span class="tit_0">digitar os e-mails separados por vígula</span>
            </div>
         </div>

         <div class="row">
            <div class="col-6">
               <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Adicionar">
            </div>
         
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
         </div>

      </form>

   <?php
   } // exibir_formulario
   ?>

    
   <footer class="fixed-bottom">
      <div>
         <div class="col-md-12">            
            <br>
         </div>
      </div>   
      <div class="row div_cabecalho">
         <div class="col-md-12">            
            <br>
         </div>
      </div>   
   </footer>  

   </div> <!-- container -->


   <!--  -->   
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>

   <script type="text/javascript">
      
      // obtém o nome do arquivo e exibe na tela
      $('input:file').change(function () {
         var nome_arquivo = $( this ).val().split("\\").pop();
         $("#div_status").html("");
         $('#div_status').append('Arquivo: '+nome_arquivo ); 
      });

   </script>

<?php
   function verificar_acao() {      

      if ( !isset($_REQUEST['acao']) ) {         
         $acao          = '';
         $comportamento = 'exibir_listagem';         
      } else {
         $acao          = $_REQUEST['acao'];
         $comportamento = $_REQUEST['comportamento'];
      }
     
      switch ($comportamento) {         
         case 'exibir_formulario':
            igualar_formulario();
            exibir_formulario();
            break;
         
         case 'exibir_listagem':
            igualar_formulario();
            exibir_listagem();
            break;

         case 'efetivar':
            efetivar();
            break;

         default:
            die(' vixi...');
            break;
      }

   } // verificar_acao
   
   function igualar_formulario() {
   } // igualar_formulario
  
   function efetivar() {
      if ( isset($_REQUEST['frm_emails']) ) {
         incluir_emails();
      }
      print ' Terminou o processamento!';
   
   } // efetivar

   function tratar_email($email) {
      $email = trim($email);      
      //.. retira o último caractere se necessário
      $ultimo_caracter = substr( $email, strlen($email)-1, 1);
      if( $ultimo_caracter == '.' ) {
         $email = substr( $email, 0, strlen($email)-1 );
      }
      return $email;
   }

   function email_ja_cadastrado($email) {
      $resultado = false;
      $conecta   = new Conecta();
      $sql = " SELECT
                  nome,
                  email
               FROM 
                  tbemails
                WHERE
                  email='{$email}'
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      $do_email = $stmt->fetch(PDO::FETCH_OBJ);
      if ( $do_email != '' ) {
         $resultado = true;
      }      

      return $resultado;   
   }

   function incluir_emails() {
      $conecta   = new Conecta();
      $emails = explode( ',', $_REQUEST['frm_emails'] );
      foreach ( $emails as $key => $email) {
         $email  = tratar_email($email);
         $codigo = md5($email);
         if ( !email_ja_cadastrado($email) && $email !='' ) {
            try {
               $conecta->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $sql = "INSERT INTO tbemails( email,codigo,ativo )
                       VALUES ( :email, :codigo, :ativo )";
               $stmt = $conecta->con->prepare($sql);
               $stmt->bindValue(':email', $email,   PDO::PARAM_STR );
               $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR );
               $stmt->bindValue(':ativo', 'S', PDO::PARAM_STR );
               $stmt->execute();
               $id_email = $conecta->con->lastInsertId();               
            } catch(PDOException $e) {         
               $cod_erro = new Infra_Cod_Erro();
               $conecta->cod_erro = $cod_erro->obter_erros( $e->getMessage() );   
               Utils::Dbga_Abort( $e->getMessage() );    
            }
         }
      }  
   }

   ?>

</body>

</html>
