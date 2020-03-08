<?php
session_start(); 

include_once 'cad_raca_hlp.php';
include_once '../cadastro/utils.php';

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
   
</head>

<body class="fundo_cinza_1">

   <header>
      <?php include_once 'tools_cabecalho.php';?>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-3">         
            <p style="font-size: 18px">Cadastro - Raças</p>
         </div>
         <div class="col-md-2 text-right">            
            <a class="btn btn-outline-success btn_link" href="cad_raca.php?acao=inclusao&comportamento=exibir_formulario&frm_id_raca=0"><img src="../images/novo.svg"  > Novo</a>
         </div>
         <div class="col-md-1 text-right">            
             <a class="btn btn-outline-success btn_link" href="cad_raca.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/editar.svg" alt="Alterar" >Alterar</a>            
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
      $raca = new Cad_Raca_Hlp();
      $raca->obter_racas($racas);
      $raca = $_REQUEST['frm_id_raca'];  


      $categoria = new Cad_Raca_Hlp();
      $categoria->obter_categoria($categorias);
      
      $id_categoria = $_REQUEST['frm_id_categoria'];

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

      <form id="frmCadRaca" class="form-horizontal" action="cad_raca.php" method="POST" enctype="multipart/form-data" role="form">

         <div id='div_buscar'></div>

         <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">         
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_raca"   name="frm_id_raca"   value = "<?=$_REQUEST['frm_id_raca']?>">
         
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

         <?php
         if ( $_REQUEST['acao']=='alteracao' || $_REQUEST['acao']=='exclusao' ) {?>       
            <div class="row">
               <div class="col-md-2">
                  <label for="frm_id_categoria">Categoria*</label>
                  <input type="hidden" id="frm_id_categoria"   name="frm_id_categoria"   value = "<?=$_REQUEST['frm_id_categoria']?>">
                  <input type="text" class="form-control form-control-sm" id="frm_id_categoria" name="frm_id_categoria" value="<?=$_REQUEST['frm_categoria']?>" readonly >
               </div>
            </div>  
         <?php
         } else {?>
            <div class="row">
               <div class="col-md-2">
                  <label for="frm_id_categoria">Categoria*</label>
                  <select id='frm_id_categoria' name='frm_id_categoria' class="form-control form-control-sm" required="required" <?=$disabled?> >
                     <?php
                     foreach ( $categorias as $item ) {?>
                        <option value="<?=$item->id_categoria?>" <?= $id_categoria==$item->id_categoria ? "selected" : '';?> ><?=$item->categoria?></option>
                     <?php
                     }
                     ?>
                  </select>
               </div>
            </div>  
         <?php
         }?>

         <div class="row">
            <div class="col-md-12"  >
               <label for="frm_raca">Raça</label>
               <input type="text" class="form-control form-control-sm" id="frm_raca" name="frm_raca" value="<?=$_REQUEST['frm_raca']?>" required  <?=$readonly?> >
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
      $_REQUEST['frm_filtro_raca'        ] = isset($_REQUEST['frm_filtro_raca'])         ? $_REQUEST['frm_filtro_raca'        ] : '';
      
      $id_categoria = $_REQUEST['frm_filtro_id_categoria'];
      
      $categoria = new Cad_Raca_Hlp();
      $categoria->obter_categoria($categorias);
      
      
      ?>
      
      <form id="formulario" class="form-horizontal" action="cad_raca.php" method="POST" role="form">

         <input type="hidden" id="comportamento" name="comportamento" value = "exibir_listagem">
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
               
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
               
         <div class="row fundo_branco_1">
            
            <div class="col-md-2">
               <label for="frm_filtro_id_categoria">Categoria*</label>
               <select id='frm_filtro_id_categoria' name='frm_filtro_id_categoria' class="form-control form-control-sm" required="required" onchange="obter_racas(this)" >
                  <?php
                  foreach ( $categorias as $item ) {?>
                     <option value="<?=$item->id_categoria?>" <?= $id_categoria==$item->id_categoria ? "selected" : '';?> ><?=$item->categoria?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>   

            <div class="col-md-2">
               <label for="frm_titulo">Raça</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_raca" name="frm_filtro_raca" value="<?=$_REQUEST['frm_filtro_raca']?>" />
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
            <div class="col-4">Raça</div>
            <div class="col-4">Categoria</div>
            <div class="col-1"></div>
         </div>
         

         <div class="row">
             <div class="col-12 altura_linha_1 fundo_branco_1"></div>
         </div>

         <?php
         if ( isset($_REQUEST['frm_filtro_raca']) ) {
            $instancia = new Cad_Raca_Hlp();
            $instancia->set_id_categoria( $_REQUEST['frm_filtro_id_categoria'] );            
            $instancia->obter_racas( $racas );
            $i = 0;
            foreach ( $racas as $raca ) { 
               if( $i % 2 == 0 ) {
                  $cor='cor_zebra_1';
                  $i=1;
               } else {
                  $cor='cor_zebra_2';
                  $i = 0;
               }?>

               <div class="row <?= "{$cor}" ?>">
                  <div class="col-2">
                     <a class="btn btn-outline-success btn_link2" href="cad_raca.php?acao=alteracao&comportamento=exibir_formulario&frm_id_raca=<?=$raca->id_raca?>"><img src="../images/editar.svg"></a>
                  </div>                  
                  <div class="col-8"><?=$raca->raca ?></div>
                  <div class="col-1">                  
                     <a class="btn btn-outline-success btn_link2" href="cad_raca.php?acao=exclusao&comportamento=exibir_formulario&frm_id_raca=<?=$raca->id_raca?>"><img src="../images/excluir.svg"></a>
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
      if ( isset($_REQUEST['frm_id_raca']) ) {
         $instancia = new Cad_Raca_Hlp();
         $instancia->set_id_raca( $_REQUEST['frm_id_raca'] );
         $instancia->obter_racas( $racas );         
         if ( count($racas)>0 ) {
            $raca = $racas[0];           
         }
      }
      $_REQUEST['frm_id_raca'     ] = !isset($raca) ? '' : $raca->id_raca;
      $_REQUEST['frm_raca'        ] = !isset($raca) ? '' : $raca->raca; 
      $_REQUEST['frm_id_categoria'] = !isset($raca) ? '' : $raca->id_categoria; 
      $_REQUEST['frm_categoria'   ] = !isset($raca) ? '' : $raca->categoria; 

      if ( $_REQUEST['acao']=='inclusao' ) {
         $_REQUEST['frm_ativo'] = 'N';
         $_REQUEST['frm_modo'] = '<< NOVA - Raça >>';
      
      } else if ( $_REQUEST['acao']=='alteracao' ) {
         $_REQUEST['frm_modo'] = '<< Alterar - Raça >>';

      } else if ( $_REQUEST['acao']=='exclusao' ) {
         $_REQUEST['frm_modo'] = '<< Excluir - Raça >>';
      
      } else {
         die(' deu ruin.' );
      }

   } // igualar_formulario
  
   function efetivar() {
      $raca = new Cad_Raca_Hlp();
      igualar_objeto($raca);
      if ( $_REQUEST['acao'] =='inclusao' ) {
         $raca->incluir();
         if ( $raca->cod_erro ) {
            print 'Não foi possivel incluir a raca:  '.$_REQUEST['frm_raca'].'<br>';
            print $raca->cod_erro;
         } else {            
            $mens  = "<br>Inclusão realizada com sucesso.<br>";
            $mens .= "Raça: {$raca->get_raca()}";
            print $mens;
         }
      } 

      if ( $_REQUEST['acao'] =='alteracao' ) {  
         $raca->set_id_raca( $_REQUEST['frm_id_raca'] );      
         $raca->alterar();
         $mens  = "<br>Alteração realizada com sucesso.<br>";
         $mens .= "Raca: {$raca->get_raca()}";
         print $mens;
      }

      if ( $_REQUEST['acao'] =='exclusao' ) {  
         $raca->set_id_raca( $_REQUEST['frm_id_raca'] );      
         $raca->excluir();         
         if ( $raca->cod_erro ) {
            print 'Não foi possivel excluir a raça:  '.$_REQUEST['frm_raca'].'<br>';
            print $raca->cod_erro;
         } else {
            $mens  = "<br>Exclusão realizada com sucesso.<br>";
            $mens .= "Raça: {$raca->get_raca()}";
            print $mens;
         }

      }

   } // efetivar
   
   function igualar_objeto( &$raca ) {  
      $raca->set_raca( $_REQUEST['frm_raca'] );
      $raca->set_id_categoria( $_REQUEST['frm_id_categoria'] );
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
