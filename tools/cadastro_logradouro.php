<?php
session_start(); 
include_once 'cadastro_logradouro_hlp.php';
include_once 'endereco_hlp.php';

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

<body class="fundo_cinza_1">

   <header>
       <?php include_once 'cabecalho_tools.php';?>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-3">         
            <p style="font-size: 18px">Cadastro - Logradouro</p>
         </div>
         <div class="col-md-2 text-right">            
            <a class="btn btn-outline-success btn_link" href="cadastro_logradouro.php?acao=inclusao&comportamento=exibir_formulario&frm_id_logradouro=0"><img src="../images/novo.svg"  > Novo</a>
         </div>
         <div class="col-md-1 text-right">            
             <a class="btn btn-outline-success btn_link" href="cadastro_logradouro.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/editar.svg" alt="Alterar" >Alterar</a>            
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
      $municipio = new Endereco_Hlp();
      $municipio->obter_municipios($municipios);

      $id_municipio = $_REQUEST['frm_id_municipio'];  

      if ( $_REQUEST['acao']=='inclusao' ) {
         $titulo   = 'Excluir';
      } else {         
         $disabled = 'disabled="disabled"'; 
         $titulo   = 'Alterar';
      }

      ?>

      <form id="frmCadastroTipo" class="form-horizontal" action="cadastro_logradouro.php" method="POST" enctype="multipart/form-data" role="form">

         <div id='div_buscar'></div>

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_logradouro" name="frm_id_logradouro" value = "<?=$_REQUEST['frm_id_logradouro']?>">
         <input type="hidden" id="frm_id_bairro"     name="frm_id_bairro"     value = "<?=$_REQUEST['frm_id_bairro']?>">
         <input type="hidden" id="frm_id_municipio"  name="frm_id_municipio"  value = "<?=$_REQUEST['frm_id_municipio']?>">
         
         <div class="row">
            <div class="col-md-12">
               <span class="destaque_3"><?=$_REQUEST['frm_modo']?></span>
            </div>
         </div>

         <div class="row fundo_branco_1">

            <div class="col-md-1">
               <label for="frm_filtro_uf">UF</label>               
               <select id='frm_filtro_uf' name='frm_filtro_uf' class="form-control form-control-sm" value="<?=$_REQUEST['frm_filtro_uf']?>"   />
                  <option value="SP">SP</option>                  
               </select>
            </div>

            <div class="col-md-2">
               <label for="frm_municipio">Município</label>
               <select id='frm__municipio' name='frm_municipio' class="form-control form-control-sm" <?=$disabled;?> required >
                  <option value="">...</option>
                  <?php
                  foreach ( $municipios as $item ) {?>
                     <option value="<?=$item['id_municipio']?>" <?= $id_municipio==$item['id_municipio'] ? "selected" : '';?> ><?=$item['nome_municipio']?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>
               
            <div class="col-md-2">
               <label for="frm_cep">CEP</label>
               <input type="text" class="form-control form-control-sm" id="frm_cep" name="frm_cep" required  value="<?=$_REQUEST['frm_cep']?>" />
            </div>

            <div class="col-md-3">
               <label for="frm_nome_logradouro">Logradouro</label>
               <input type="text" class="form-control form-control-sm" id="frm_nome_logradouro" name="frm_nome_logradouro" required  value="<?=$_REQUEST['frm_nome_logradouro']?>" />
            </div>

            <div class="col-md-3">
               <label for="frm_nome_logradouro">Bairro</label>
               <input type="text" class="form-control form-control-sm" id="frm_nome_bairro" name="frm_nome_bairro" required  value="<?=$_REQUEST['frm_nome_bairro']?>" />
            </div>

         </div>


         <div class="row fundo_branco_1">
            <div class="col-12">
               <br>
            </div>
         </div>

         <div class="text-right">
            <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Salvar">
         </div>
      </form>

   <?php
   } // exibir_formulario
   ?>


   <?php
   function exibir_listagem() {
      $municipio = new Endereco_Hlp();
      $municipio->obter_municipios($municipios);
      

      $_REQUEST['frm_filtro_cep'             ] = isset($_REQUEST['frm_filtro_cep'             ]) ? $_REQUEST['frm_filtro_cep'              ] : '';
      $_REQUEST['frm_filtro_nome_logradouro' ] = isset($_REQUEST['frm_filtro_nome_logradouro' ]) ? $_REQUEST['frm_filtro_nome_logradouro'  ] : '';
      $_REQUEST['frm_filtro_nome_bairro'     ] = isset($_REQUEST['frm_filtro_nome_bairro'     ]) ? $_REQUEST['frm_filtro_nome_bairro'      ] : '';
      
      $municipio = isset($_REQUEST['frm_filtro_municipio']) ? $_REQUEST['frm_filtro_municipio'] : '';

      ?>
      
      <form id="formulario" class="form-horizontal" action="cadastro_logradouro.php" method="POST" role="form">

         <input type="hidden" id="comportamento" name="comportamento" value = "exibir_listagem">
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
               
         
         <div class="row text-right">
            <div class="col-12">
               <span class="font_azul_p">Cadastro de logradouro manual</span>               
            </div>
         </div>

               
         <div class="row fundo_branco_1">


            <div class="col-md-2">
               <label for="frm_filtro_municipio">Município</label>
               <select id='frm_filtro_municipio' name='frm_filtro_municipio' class="form-control form-control-sm" >
                  <option value="">...</option>
                  <?php
                  foreach ( $municipios as $item ) {?>
                     <option value="<?=$item['id_municipio']?>" <?= $municipio==$item['id_municipio'] ? "selected" : '';?> ><?=$item['nome_municipio']?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>

            <div class="col-md-2">
               <label for="frm_filtro_cep">CEP</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_cep" name="frm_filtro_cep" value="<?=$_REQUEST['frm_filtro_cep']?>" />
            </div>
            <div class="col-md-2">
               <label for="frm_filtro_nome_logradouro">Logradouro</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_nome_logradouro" name="frm_filtro_nome_logradouro" value="<?=$_REQUEST['frm_filtro_nome_logradouro']?>" />
            </div>
            <div class="col-md-2">
               <br>               
               <input type="submit" id="btnFiltrar" name="btnFiltrar" class="btn btn-success btn_salvar" value="Filtrar">
            </div>
         </div>
 
         <div class="row fundo_branco_1">
            <div class="col-md-12">&nbsp;</div>
         </div>

         <div class="row">            
            <div class="col-1 text-center"></div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">Cep</div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 text-left">Logradouro</div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">Bairro</div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left">Município</div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-1 col-xl-1 text-left">UF</div>
            <div class="col-1 text-center"></div>
         </div>

         <?php
         if ( isset($_REQUEST['frm_filtro_cep']) ) {
            $instancia = new Cadastro_Logradouro_Hlp();
            $instancia->set_cep( $_REQUEST['frm_filtro_cep'] );
            $instancia->set_nome_logradouro( $_REQUEST['frm_filtro_nome_logradouro'] );
            $instancia->set_nome_bairro( $_REQUEST['frm_filtro_nome_bairro'] );
            $instancia->set_id_municipio( $municipio );
            //print_r($_REQUEST);
            $instancia->obter_logradouros( $consulta );
            $i = 0;
            foreach ( $consulta as $item ) { 
               if( $i % 2 == 0 ) {
                  $cor='cor_zebra_1';
                  $i=1;
               } else {
                  $cor='cor_zebra_2';
                  $i = 0;
               }?>
               <div class="row <?= "{$cor}" ?>">
                  <div class="col-1">
                     <a class="btn btn-outline-success btn_link2" href="cadastro_logradouro.php?acao=alteracao&comportamento=exibir_formulario&frm_id_logradouro=<?=$item->id_logradouro ?>"><img src="../images/editar.svg"></a>
                  </div>                  
                  <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left"><span class="font_preta_p"><?=$item->cep ?></span></div>
                  <div class="col-4 col-sm-4 col-md-4 col-lg-3 col-xl-3 text-left"><span class="font_preta_p"><?=$item->nome_logradouro ?></span></div>
                  <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left"><span class="font_preta_p"><?=$item->nome_bairro ?></span></div>
                  <div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2 text-left"><span class="font_preta_p"><?=$item->nome_municipio ?></span></div>
                  <div class="col-4 col-sm-4 col-md-4 col-lg-1 col-xl-1 text-left"><span class="font_preta_p"><?=$item->nome_uf ?></span></div>
                  
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
      if ( isset($_REQUEST['frm_id_logradouro']) ) {
         $instancia = new Cadastro_Logradouro_Hlp();
         $instancia->set_id_logradouro( $_REQUEST['frm_id_logradouro'] );
         $instancia->obter_logradouros( $logradouros );
         if ( count($logradouros)>0 ) {
            $logradouro = $logradouros[0];           
         }
      }
      $_REQUEST['frm_id_logradouro'  ] = !isset($logradouro) ? '' : $logradouro->id_logradouro;
      $_REQUEST['frm_id_municipio'   ] = !isset($logradouro) ? '' : $logradouro->id_municipio;
      $_REQUEST['frm_id_bairro'      ] = !isset($logradouro) ? '' : $logradouro->id_bairro;
      $_REQUEST['frm_nome_logradouro'] = !isset($logradouro) ? '' : $logradouro->nome_logradouro;
      $_REQUEST['frm_nome_bairro'    ] = !isset($logradouro) ? '' : $logradouro->nome_bairro;
      $_REQUEST['frm_cep'            ] = !isset($logradouro) ? '' : $logradouro->cep;

      if ( $_REQUEST['acao']=='inclusao' ) {
         $_REQUEST['frm_modo'] = '<< NOVO Logradouro >>';
      }      
      if ( $_REQUEST['acao']=='alteracao' ) {
         $_REQUEST['frm_modo'] = '<< Alteração de Logradouro >>';
      }

   } // igualar_formulario
  
   function efetivar() {
      $instancia = new Cadastro_Logradouro_Hlp();
      igualar_objeto($instancia);

      if ( $_REQUEST['acao'] =='inclusao' ) {
         $instancia->incluir();      
         print '-------------->'.$_REQUEST['acao'];
         if ( $instancia->cod_erro ) {
            print 'Não foi possivel incluir o logradouro:  '.$_REQUEST['frm_nome_logradouro'].'<br>';
            print $instancia->cod_erro;
         } else {            
            $mens  = "<br>Inclusão realizada com sucesso.<br>";
            $mens .= "Logradouro: {$instancia->get_nome_logradouro()}";
            print $mens;
         }
      } 

      if ( $_REQUEST['acao'] =='alteracao' ) {  
         $instancia->set_nome_logradouro( $_REQUEST['frm_nome_logradouro'] );      
         $instancia->alterar();
         $mens  = "<br>Alteração realizada com sucesso.<br>";
         $mens .= "Logradouro: {$instancia->get_nome_logradouro()}";
         print $mens;
      }
      
   } 
   
   function igualar_objeto( &$instancia ) { 
      $instancia->set_id_municipio( $_REQUEST['frm_municipio'] );     
      $instancia->set_id_bairro( $_REQUEST['frm_id_bairro'] );     
      $instancia->set_id_logradouro( $_REQUEST['frm_id_logradouro'] );      
      $instancia->set_cep( $_REQUEST['frm_cep'] );
      $instancia->set_nome_logradouro( $_REQUEST['frm_nome_logradouro'] );
      $instancia->set_nome_bairro( $_REQUEST['frm_nome_bairro'] );     

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
