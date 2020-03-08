<?php
session_start(); 
include_once '../cadastro/fotos.php';
include_once '../cadastro/utils.php';

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
   
</head>


<body class="fundo_cinza_1">

   <header>
      <?php include_once 'tools_cabecalho.php';?>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-2">         
            <p style="font-size: 18px">Limpeza de pastas</p>
         </div>
         <div class="col-md-7">            
             <p class="font_azul_m">Apagar pastas tmp</p>
         </div>         
        <div class="col-md-2">            
            <a class="btn btn-outline-success btn_link" href="tools.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
         </div>
      </div>
   </header>  

   <div class="container">

   <?php
   verificar_acao();
   ?>

   <?php
   function exibir_listagem() {
     ?>
      
      <form id="formulario" class="form-horizontal" action="tools_pastas_tmp.php" method="POST" role="form">

         <input type="hidden" id="comportamento"      name="comportamento"      value = "efetivar">         
         <input type="hidden" id="acao"               name="acao"               value = "<?=$_REQUEST['acao']?>">

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
        
         <div class="row">
             <div class="col-12 altura_linha_2 fundo_branco_1"></div>
         </div>

         <div class="row fundo_branco_1 border">
            <div class="col-md-1"></div>            
            <div class="col-md-9">Pasta</div>
             <div class="col-md-9"><input type="checkbox" id="checkTodos" name="checkTodos" checked> Selecionar Todos</div>
         </div>

         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         <?php


         $data_hoje = date('Ymd');
         $dir_fotos = str_replace( 'tools','fotos/', dirname(__FILE__) );
         foreach( glob( $dir_fotos."tmp_*", GLOB_ONLYDIR ) as $pasta ) {
            $nome_pasta = basename($pasta);
            $data_pasta = explode( '_', $nome_pasta );
            $data_pasta = $data_pasta[1];
            if ( $data_pasta<$data_hoje ) {?>
               <div class="row <?= "{$cor}" ?>">
                  <div class="col-1">                  
                     <input type="checkbox" id="<?=$nome_pasta?>" name="<?=$nome_pasta?>" value = "<?=$nome_pasta?>" checked >
                  </div>         
                  <div class="col-2">/fotos</div>         
                  <div class="col-9"><?=$nome_pasta ?></div>
               </div>
            <?php
            }
         }

         $data_hoje = date('Ymd');
         $dir_fotos = str_replace( 'tools','fotos_mural/', dirname(__FILE__) );
         foreach( glob( $dir_fotos."tmp_*", GLOB_ONLYDIR ) as $pasta ) {
            $nome_pasta = basename($pasta);
            $data_pasta = explode( '_', $nome_pasta );
            $data_pasta = $data_pasta[1];
            if ( $data_pasta<$data_hoje ) {?>
               <div class="row <?= "{$cor}" ?>">
                  <div class="col-1">                  
                     <input type="checkbox" id="<?=$nome_pasta?>" name="<?=$nome_pasta?>" value = "<?=$nome_pasta?>" checked >
                  </div>                  
                  <div class="col-2">/fotos_mural</div>
                  <div class="col-9"><?=$nome_pasta ?></div>
                  
               </div>
            <?php
            }
         }

         
         ?>  

         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_2"></div>
         </div>

         <div class="row text-right">
            <div class="col-12">
               <input type="submit" name="b1" class="btn btn_whatzapp" value="Excluir pastas" onclick="return validar_form();" >
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_2"></div>
         </div>

      </form>


   <?php
   } // exibir_listagem
   ?>

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
         
         case 'exibir_listagem':                       
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
   
  
  
   function efetivar() {
      $instancia = new Fotos();
      foreach ( $_REQUEST as $dir_tmp ) {
         if ( substr($dir_tmp,0,3 ) == 'tmp' ) {            
            $dir_fotos       = str_replace( 'tools','fotos/',       dirname(__FILE__) );
            $dir_fotos_mural = str_replace( 'tools','fotos_mural/', dirname(__FILE__) );
            if ( is_dir($dir_fotos.$dir_tmp) ) {
              $instancia->excluir_pasta_tmp( $dir_fotos.$dir_tmp.'/thumbnail/' );
              $instancia->excluir_pasta_tmp( $dir_fotos.$dir_tmp.'/' );
            } else {
              $instancia->excluir_pasta_tmp( $dir_fotos_mural.$dir_tmp.'/thumbnail/' );
              $instancia->excluir_pasta_tmp( $dir_fotos_mural.$dir_tmp.'/' );
            }

         }         
      }
      
      print '<br><br>';
      print 'Operação realizada com sucesso.<br>';
      print '<br><br>';
      ?>

      <br>
      <a class="btn_link" href="tools_pastas_tmp.php?acao=alteracao&comportamento=exibir_listagem" role="button">Click Aqui para excluir outra pasta</a>
      <br><br><br>
         <a class="btn btn-outline-success btn_link" href="tools.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>      <br><br><br>
   <?php
   }
   ?>

  
   </div> <!-- container -->

   <div class="container-fluid">

   
   </div> <!-- container -->

   <!--  -->   
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>



   <script type="text/javascript">
         
      function validar_filtros() {
         $('#comportamento').val('exibir_listagem');
         document.getElementById("formulario").submit();
      }

      function validar_form() {
         var resultado = false;
         $("#formulario input[type=checkbox]").each(function() {
            if ( this.checked == true ) {
               resultado = true;
            }
         });
         if ( resultado == false ) {
            alert('Pelo menos um item deve ser selecionado.')
         }         
        return resultado;
      } // validar_form


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
