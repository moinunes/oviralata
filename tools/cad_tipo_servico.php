<?php
session_start(); 

include_once 'cad_tipo_servico_hlp.php';
include_once '../cadastro/utils.php';

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
   
</head>

<body class="fundo_cinza_1">

   <header>
      <?php include_once 'tools_cabecalho.php';?>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-3">         
            <p style="font-size: 18px">Cadastro - Tipo Serviço</p>
         </div>
         <div class="col-md-2 text-right">            
            <a class="btn btn-outline-success btn_link" href="cad_tipo_servico.php?acao=inclusao&comportamento=exibir_formulario&frm_id_tipo_servico=0"><img src="../images/novo.svg"  > Novo</a>
         </div>
         <div class="col-md-1 text-right">            
             <a class="btn btn-outline-success btn_link" href="cad_tipo_servico.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/editar.svg" alt="Alterar" >Alterar</a>            
         </div>         
        <div class="col-md-5 text-right">            
            <a class="btn btn-outline-success btn_link" href="tools.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
         </div>
      </div>
   </header>  

   <div class="container">

   <?php
   verificar_acao();
   ?>


   <?php
   function exibir_formulario() {
      $tiposervico = new Cad_Tipo_Servico_Hlp();
      $tiposervico->obter_tipos_servico($tiposervicos);
      $tiposervico = $_REQUEST['frm_id_tipo_servico'];  
      if ( $_REQUEST['acao']=='exclusao' ) {
         $disabled = "disabled='true'";
         $readonly = 'readonly';
         $titulo   = 'Excluir';

      } else if ( $_REQUEST['acao']=='alteracao' ) {
         $disabled = "disabled='true'";;
         $readonly = '';
         $titulo   = 'Salvar';
      
      } else if ( $_REQUEST['acao']=='inclusao' ) {
         $readonly = '';
         $titulo   = 'Salvar';
      }

      ?>

      <form id="frmCadTipoServico" class="form-horizontal" action="cad_tipo_servico.php" method="POST" enctype="multipart/form-data" role="form">

         <div id='div_buscar'></div>

         <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">         
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_tipo_servico"   name="frm_id_tipo_servico"   value = "<?=$_REQUEST['frm_id_tipo_servico']?>">
         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col-md-12">
               <span class="destaque_3"><?=$_REQUEST['frm_modo']?></span>
            </div>
         </div>
         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col-md-12"  >
               <label for="frm_tiposervico">Tipo Serviço</label>
               <input type="text" class="form-control form-control-sm" id="frm_tiposervico" name="frm_tiposervico" value="<?=$_REQUEST['frm_tiposervico']?>" required  <?=$readonly?> >
            </div>
         </div>
         <div class="row">
            <div class="col-md-12"  >
               <label for="frm_tiposervico">Ordem</label>
               <input type="text" class="form-control form-control-sm" id="frm_ordem" name="frm_ordem" value="<?=$_REQUEST['frm_ordem']?>" required  <?=$readonly?> >
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row text-right">
            <div class="col-12">
               <input type="submit" name="b1" class="btn btn-success btn_salvar" value="<?=$titulo?>">
            </div>
         </div>

      </form>

   <?php
   } // exibir_formulario
   ?>


   <?php
   function exibir_listagem() {  
      $_REQUEST['frm_filtro_id_categoria'] = isset($_REQUEST['frm_filtro_id_categoria']) ? $_REQUEST['frm_filtro_id_categoria'] : '';
      $_REQUEST['frm_filtro_tiposervico'        ] = isset($_REQUEST['frm_filtro_tiposervico'])         ? $_REQUEST['frm_filtro_tiposervico'        ] : '';
            
      ?>
      
      <form id="formulario" class="form-horizontal" action="cad_tipo_servico.php" method="POST" role="form">

         <input type="hidden" id="comportamento" name="comportamento" value = "exibir_listagem">
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
               
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
               
         <div class="row fundo_branco_1">

            <div class="col-md-2">
               <label for="frm_titulo">Tipo Serviço</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_tiposervico" name="frm_filtro_tiposervico" value="<?=$_REQUEST['frm_filtro_tiposervico']?>" />
            </div>
            <div class="col-md-2">
               <br>               
               <input type="submit" id="btnFiltrar" name="btnFiltrar" class="btn btn-success btn_salvar" value="Filtrar">
                          
            </div>
         
         </div>

         <div class="row">
             <div class="col-12 altura_linha_2 fundo_branco_1"></div>
         </div>
         

         <div class="row fundo_branco_1 border">           
            <div class="col-2"></div>
            <div class="col-4">Tipo Serviço</div>
            <div class="col-4">Ordem</div>
            <div class="col-2"></div>
         </div>
         

         <div class="row">
             <div class="col-12 altura_linha_1 fundo_branco_1"></div>
         </div>

         <?php
         if ( isset($_REQUEST['frm_filtro_tiposervico']) ) {
            $instancia = new Cad_Tipo_Servico_Hlp();
            $instancia->set_tiposervico( $_REQUEST['frm_filtro_tiposervico'] );            
            $instancia->obter_tipos_servico( $tiposervicos );
            $i = 0;
            foreach ( $tiposervicos as $tiposervico ) { 
               if( $i % 2 == 0 ) {
                  $cor='cor_zebra_1';
                  $i=1;
               } else {
                  $cor='cor_zebra_2';
                  $i = 0;
               }?>

               <div class="row <?= "{$cor}" ?>">
                  <div class="col-2">
                     <a class="btn btn-outline-success btn_link2" href="cad_tipo_servico.php?acao=alteracao&comportamento=exibir_formulario&frm_id_tipo_servico=<?=$tiposervico->id_tipo_servico?>"><img src="../images/editar.svg"></a>
                  </div>                  
                  <div class="col-4"><?=$tiposervico->tiposervico ?></div>
                  <div class="col-4"><?=$tiposervico->ordem ?></div>
                  <div class="col-2">                  
                     <a class="btn btn-outline-success btn_link2" href="cad_tipo_servico.php?acao=exclusao&comportamento=exibir_formulario&frm_id_tipo_servico=<?=$tiposervico->id_tipo_servico?>"><img src="../images/excluir.svg"></a>
                  </div>
                  
               </div>
            <?php   
            }
         }         
         ?>        
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
      if ( isset($_REQUEST['frm_id_tipo_servico']) ) {
         $instancia = new Cad_Tipo_Servico_Hlp();
         $instancia->set_id_tipo_servico( $_REQUEST['frm_id_tipo_servico'] );
         $instancia->obter_tipos_servico( $tiposervicos );         
         if ( count($tiposervicos)>0 ) {
            $tiposervico = $tiposervicos[0];           
         }
      }
      $_REQUEST['frm_id_tipo_servico' ] = !isset($tiposervico) ? '' : $tiposervico->id_tipo_servico;
      $_REQUEST['frm_tiposervico'     ] = !isset($tiposervico) ? '' : $tiposervico->tiposervico; 
      $_REQUEST['frm_ordem'           ] = !isset($tiposervico) ? '' : $tiposervico->ordem; 
      
      if ( $_REQUEST['acao']=='inclusao' ) {
         $_REQUEST['frm_ativo'] = 'N';
         $_REQUEST['frm_modo'] = '<< NOVO - Tipo Serviço >>';
      
      } else if ( $_REQUEST['acao']=='alteracao' ) {
         $_REQUEST['frm_modo'] = '<< Alterar - Tipo Serviço >>';

      } else if ( $_REQUEST['acao']=='exclusao' ) {
         $_REQUEST['frm_modo'] = '<< Excluir - Tipo Serviço >>';
      
      } else {
         die(' deu ruin.' );
      }

   } // igualar_formulario
  
   function efetivar() {
      $tiposervico = new Cad_Tipo_Servico_Hlp();
      igualar_objeto($tiposervico);
      if ( $_REQUEST['acao'] =='inclusao' ) {
         $tiposervico->incluir();
         if ( $tiposervico->cod_erro ) {
            print 'Não foi possivel incluir o Tipo Serviço:  '.$_REQUEST['frm_tiposervico'].'<br>';
            print $tiposervico->cod_erro;
         } else {            
            $mens  = "<br>Inclusão realizada com sucesso.<br>";
            $mens .= "Tipo Serviço: {$tiposervico->get_tiposervico()}";
            print $mens;
         }
      } 

      if ( $_REQUEST['acao'] =='alteracao' ) {  
         $tiposervico->set_id_tipo_servico( $_REQUEST['frm_id_tipo_servico'] );      
         $tiposervico->alterar();
         $mens  = "<br>Alteração realizada com sucesso.<br>";
         $mens .= "Tipo Serviço: {$tiposervico->get_tiposervico()}";
         print $mens;
      }

      if ( $_REQUEST['acao'] =='exclusao' ) {  
         $tiposervico->set_id_tipo_servico( $_REQUEST['frm_id_tipo_servico'] );      
         $tiposervico->excluir();         
         if ( $tiposervico->cod_erro ) {
            print 'Não foi possivel excluir o tipo de serviço:  '.$_REQUEST['frm_tiposervico'].'<br>';
            print $tiposervico->cod_erro;
         } else {
            $mens  = "<br>Exclusão realizada com sucesso.<br>";
            $mens .= "Tipo Serviço: {$tiposervico->get_tiposervico()}";
            print $mens;
         }

      }

   } // efetivar
   
   function igualar_objeto( &$tiposervico ) {  
      $tiposervico->set_tiposervico( $_REQUEST['frm_tiposervico'] );
      $tiposervico->set_ordem( $_REQUEST['frm_ordem'] );
      
   } // igualar_objeto
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

</body>

</html>
