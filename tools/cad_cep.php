<?php
session_start(); 
include_once 'cad_cep_hlp.php';
include_once '../cadastro/utils.php';

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
   
</head>


<body class="fundo_cinza_1">

   <header>
      <?php include_once 'tools_cabecalho.php';?>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-2">         
            <p style="font-size: 18px">Cadastro - CEP automático</p>
         </div>
         <div class="col-md-7">            
             <p class="font_azul_m">Utilizar esse cadastro somente se não encontrar o CEP na base de dados</p>
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
      $_REQUEST['frm_filtro_cep'       ] = isset($_REQUEST['frm_filtro_cep'])        ? $_REQUEST['frm_filtro_cep']        : '';
      $_REQUEST['frm_filtro_logradouro'] = isset($_REQUEST['frm_filtro_logradouro']) ? $_REQUEST['frm_filtro_logradouro'] : '';
      $_REQUEST['frm_filtro_municipio' ] = isset($_REQUEST['frm_filtro_municipio'])  ? $_REQUEST['frm_filtro_municipio']  : '';
      $_REQUEST['frm_filtro_uf'        ] = isset($_REQUEST['frm_filtro_uf'])         ? $_REQUEST['frm_filtro_uf']         : '';

      //$_REQUEST['frm_filtro_logradouro'] ='engenheiro caetano a';
      //$_REQUEST['frm_filtro_municipio']='são paulo';
      ?>
      
      <form id="formulario" class="form-horizontal" action="cad_cep.php" method="POST" role="form">

         <input type="hidden" id="comportamento"      name="comportamento"      value = "efetivar">         
         <input type="hidden" id="acao"               name="acao"               value = "<?=$_REQUEST['acao']?>">

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
               
         <div class="row fundo_branco_1">           
            <div class="col-md-2">
               <label for="frm_filtro_cep">CEP</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_cep" name="frm_filtro_cep" value="<?=$_REQUEST['frm_filtro_cep']?>" />
            </div>            
         </div>

         <div class="row fundo_branco_1">
             <div class="col-md-1">
               <label for="frm_filtro_uf">UF</label>               
               <input type="text" class="form-control form-control-sm" id="frm_filtro_uf" name="frm_filtro_uf" value="<?=$_REQUEST['frm_filtro_uf']?>" maxlength='2' />
            </div>
            <div class="col-md-2">
               <label for="frm_filtro_cep">Município</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_municipio" name="frm_filtro_municipio"  value="<?=$_REQUEST['frm_filtro_municipio']?>" placeholder='informe o município'  />
            </div>
            <div class="col-md-3">
               <label for="frm_filtro_cep">Logradouro</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_logradouro" name="frm_filtro_logradouro" value="<?=$_REQUEST['frm_filtro_logradouro']?>" placeholder='informe o logradouro' />
            </div>
            <div class="col-md-2">
               <br>               
               <input type="submit" id="btnFiltrar" name="btnFiltrar" class="btn btn-success btn_salvar" value="Filtrar" onclick="validar_filtros();"  >
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_2 fundo_branco_1"></div>
         </div>

         <div class="row fundo_branco_1 border">
            <div class="col-md-1"></div>            
            <div class="col-md-9">Cep</div>
            <div class="col-md-2">Status</div>
         </div>

         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         <?php

         $instancia = new Cadastro_Cep_Hlp();
         $instancia->set_filtro_cep( $_REQUEST['frm_filtro_cep'] );
         $instancia->set_filtro_logradouro( $_REQUEST['frm_filtro_logradouro'] );
         $instancia->set_filtro_municipio( $_REQUEST['frm_filtro_municipio'] );
         $instancia->set_filtro_uf( $_REQUEST['frm_filtro_uf'] );
         $instancia->obter_ceps( $ceps );
         $instancia->validar_se_ja_existe( $ceps );

         $i = 0;
         foreach ( $ceps as $item ) { 
            if ( $item->existe=='S' ) {
               $disabled ='disabled';
               $status = 'já cadastrado';
            } else {
               $disabled = '';
               $status = '';
            }

            $string = "{$item->cep} - {$item->logradouro} - {$item->bairro} - {$item->localidade} - {$item->uf} - {$item->complemento}";

            if( $i % 2 == 0 ) {
               $cor='cor_zebra_1';
               $i=1;
            } else {
               $cor='cor_zebra_2';
               $i = 0;
            }?>
            <div class="row <?= "{$cor}" ?>">
               <div class="col-md-1">                  
                  <input type="checkbox" id="frm_marcar_<?=$item->cep?>" name="frm_marcar_<?=$item->cep?>" value = "<?=$item->cep?>" <?=$disabled?> >
               </div>                  
               <div class="col-md-9"><?=$string ?></div>
               <div class="col-md-2"><?=$status ?></div>
            </div>
         <?php   
         }
         ?>  

         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_2"></div>
         </div>

         <div class="row text-right">
            <div class="col-12">
               <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Salvar" onclick="return validar_form();" >
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
      $instancia = new Cadastro_Cep_Hlp();
      foreach ( $_REQUEST as $indice => $valor ) {
         if ( substr($indice,0,10 ) == 'frm_marcar' ) {
            $instancia->guardar_ceps($valor);
         }
         
      }
      $instancia->incluir();
      
      print '<br><br>';
      print 'Inclusão realizada com sucesso.<br>';
      print $instancia->retorno;
      print '<br><br>';
      ?>

      <br>
      <a class="btn_link" href="cad_cep.php?acao=alteracao&comportamento=exibir_listagem" role="button">Click Aqui para cadastrar outro CEP ?</a>
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

      $( "#frm_filtro_logradouro" ).focus(function() {
         $('#frm_filtro_cep').val('');
      });

   </script>


</body>

</html>
