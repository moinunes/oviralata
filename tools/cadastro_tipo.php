<?php
session_start(); 
include_once 'cadastro_hlp_tipo.php';

if ( !isset($_SESSION['login']) ) {
   session_destroy();
   header("Location:login.php");
}


?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Imobiliaria</title>

   <meta charset="utf-8">   
   <meta name="keywords" content="imobiliaria,imóvel,imóveis,apartamentos,casas,compra,venda,santos, são vicente,"/>
   <meta name="description" content="Escolha seu imóvel na baixada santista.">   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="../dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body>

   <header>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-3">         
            <p style="font-size: 18px">Cadastro - Tipo de imóvel</p>
         </div>
         <div class="col-md-2 text-right">            
            <a class="btn btn-outline-success btn_link" href="cadastro_tipo.php?acao=inclusao&comportamento=exibir_formulario&frm_id_imovel=0"><img src="../images/novo.svg"  > Novo</a>
         </div>
         <div class="col-md-1 text-right">            
             <a class="btn btn-outline-success btn_link" href="cadastro_tipo.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/editar.svg" alt="Alterar" >Alterar</a>            
         </div>         
        <div class="col-md-5 text-right">            
            <a class="btn btn-outline-success btn_link" href="index.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
         </div>
      </div>
   </header>  

   <div class="container">

   <?php
   verificar_acao();
   ?>


   <?php
   function exibir_formulario() {
      $tipo_imovel = new Cadastro_Hlp_Tipo();
      $tipo_imovel->obter_tipos($tipos_imoveis);
      $tipo = $_REQUEST['frm_id_tipo_imovel'];  

      if ( $_REQUEST['acao']=='exclusao' ) {
         $readonly = 'readonly';
         $titulo   = 'Excluir';
      } else {
         $readonly = '';
         $titulo   = 'Alterar';
      }

      ?>

      <form id="frmCadastroTipo" class="form-horizontal" action="cadastro_tipo.php" method="POST" enctype="multipart/form-data" role="form">

         <div id='div_buscar'></div>

         <input type="hidden" id="comportamento"      name="comportamento"      value = "efetivar">         
         <input type="hidden" id="acao"               name="acao"               value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_tipo_imovel" name="frm_id_tipo_imovel" value = "<?=$_REQUEST['frm_id_tipo_imovel']?>">
         
         <div class="row cor_azul">       
            <div class="col-md-12">
            <br>   
            </div>
         </div>

         <div class="row" >
            <br>
         </div>      

         <div class="row">
            <div class="col-md-12"  >
               <label for="frm_tipo_imovel">Tipo</label>
               <input type="text" class="form-control form-control-sm" id="frm_tipo_imovel" name="frm_tipo_imovel" value="<?=$_REQUEST['frm_tipo_imovel']?>" required  <?=$readonly?> >
            </div>
         </div>

         <div class="row">
            <br>
         </div>


         <div class="text-right">
            <input type="submit" name="b1" class="btn btn-success btn_salvar" value="<?=$titulo?>">
         </div>
      </form>

   <?php
   } // exibir_formulario
   ?>


   <?php
   function exibir_listagem() {  
      $_REQUEST['frm_filtro_tipo_imovel'  ] = isset($_REQUEST['frm_filtro_tipo_imovel'  ]) ? $_REQUEST['frm_filtro_tipo_imovel'  ] : '';
    
      ?>
      
      <form id="formulario" class="form-horizontal" action="cadastro_tipo.php" method="POST" role="form">

         <input type="hidden" id="comportamento" name="comportamento" value = "exibir_listagem">
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
               
         <div class="row">
            
            <div class="col-md-2">
               <label for="frm_titulo">Tipo de imóvel</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_tipo_imovel" name="frm_filtro_tipo_imovel" value="<?=$_REQUEST['frm_filtro_tipo_imovel']?>" />
            </div>
            <div class="col-md-2">
               <br>               
               <input type="submit" id="btnFiltrar" name="btnFiltrar" class="btn btn-success btn_salvar" value="Filtrar">
            </div>
         </div>

         <div class="row">
            <div class="col-md-12"><hr></div>
         </div>

         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"></div>            
            <div class="col-md-2">Tipo de imóvel</div>            
         </div>

         <div class="row">
            <div class="col-md-12"><hr></div>
         </div>

         
         <?php
         if ( isset($_REQUEST['frm_filtro_tipo_imovel']) ) {
            $instancia = new Cadastro_Hlp_Tipo();
            $instancia->set_tipo_imovel( $_REQUEST['frm_filtro_tipo_imovel'] );            
            $instancia->obter_tipos( $tipos );
            $i = 0;
            foreach ( $tipos as $tipo ) { 
               if( $i % 2 == 0 ) {
                  $cor='cor_zebra_1';
                  $i=1;
               } else {
                  $cor='cor_zebra_2';
                  $i = 0;
               }?>
               <div class="row <?= "{$cor}" ?>">
                  <div class="col-md-1">                  
                     <a class="btn btn-outline-success btn_link2" href="cadastro_tipo.php?acao=exclusao&comportamento=exibir_formulario&frm_id_tipo_imovel=<?=$tipo->id_tipo_imovel?>"><img src="../images/excluir.svg"> Excluir</a>
                  </div>
                  <div class="col-md-1">
                     <a class="btn btn-outline-success btn_link2" href="cadastro_tipo.php?acao=alteracao&comportamento=exibir_formulario&frm_id_tipo_imovel=<?=$tipo->id_tipo_imovel?>"><img src="../images/editar.svg"> Alterar</a>
                  </div>
                  <div class="col-md-2"><?=utf8_encode($tipo->tipo_imovel) ?></div>
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
      if ( isset($_REQUEST['frm_id_tipo_imovel']) ) {
         $instancia = new Cadastro_Hlp_Tipo();
         $instancia->set_id_tipo_imovel( $_REQUEST['frm_id_tipo_imovel'] );
         $instancia->obter_tipos( $tipos );         
         if ( count($tipos)>0 ) {
            $tipo = $tipos[0];           
         }
      }
      $_REQUEST['frm_id_tipo_imovel' ] = !isset($tipo) ? '' : $tipo->id_tipo_imovel;
      $_REQUEST['frm_tipo_imovel'    ] = !isset($tipo) ? '' : $tipo->tipo_imovel; 
      
   } // igualar_formulario
  
   function efetivar() {
      $tipo = new Cadastro_Hlp_Tipo();
      igualar_objeto($tipo);

      if ( $_REQUEST['acao'] =='inclusao' ) {
         $tipo->incluir();      
         if ( $tipo->cod_erro ) {
            print 'Não foi possivel incluir o tipo de imóvel:  '.$_REQUEST['frm_tipo_imovel'].'<br>';
            print $tipo->cod_erro;
         } else {            
            $mens  = "<br>Inclusão realizada com sucesso.<br>";
            $mens .= "Código: {$tipo->get_tipo_imovel()}";
            print $mens;
         }
      } 

      if ( $_REQUEST['acao'] =='alteracao' ) {  
         $tipo->set_id_tipo_imovel( $_REQUEST['frm_id_tipo_imovel'] );      
         $tipo->alterar();
         $mens  = "<br>Alteração realizada com sucesso.<br>";
         $mens .= "Tipo: {$tipo->get_tipo_imovel()}";
         print $mens;
      }

      if ( $_REQUEST['acao'] =='exclusao' ) {  
         $tipo->set_id_tipo_imovel( $_REQUEST['frm_id_tipo_imovel'] );      
         $tipo->excluir();         
         if ( $tipo->cod_erro ) {
            print 'Não foi possivel excluir o tipo de imóvel:  '.$_REQUEST['frm_tipo_imovel'].'<br>';
            print $tipo->cod_erro;
         } else {
            $mens  = "<br>Exclusão realizada com sucesso.<br>";
            $mens .= "Tipo: {$tipo->get_tipo_imovel()}";
            print $mens;
         }

      }

   } 
   
   function igualar_objeto( &$tipo ) {      
      $tipo->set_tipo_imovel( $_REQUEST['frm_tipo_imovel'] );
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
   <script src="../dist//jquery-ui/jquery-ui.min.js"></script>

</body>

</html>
