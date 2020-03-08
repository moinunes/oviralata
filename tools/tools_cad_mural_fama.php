<?php
session_start();

include_once '../cadastro/utils.php';
include_once 'tools_cad_mural_fama_hlp.php';
include_once '../cadastro/cad_usuario_hlp.php';
   
if ( !$_SESSION['login'] ) {
   Utils::validar_login();
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <?php Utils::meta_tag()?>

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="../dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body class="fundo_cinza_1">

<div class="container">
   <?php
   include_once 'tools_cabecalho.php';
 
   verificar_acao();

   function exibir_formulario() { 
      $id_mural_fama = $_REQUEST['frm_id_mural_fama'];

      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($_REQUEST['frm_id_usuario']);
      $usuario->obter_dados_usuario( $usuario );

      include_once 'tools_cabecalho.php';
         
      ?>
      <form id="frmCadMuralFama" name="frmCadMuralFama" class="form-horizontal" action="tools_cad_mural_fama.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return validar_submit();">

         <div id='div_buscar'></div>         

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_usuario"    name="frm_id_usuario"    value = "<?=$_REQUEST['frm_id_usuario']?>">     
         <input type="hidden" id="frm_origem"        name="frm_origem"        value ="mural_fama" >
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">     
         <input type="hidden" id="frm_endereco"      name="frm_endereco"      value = "<?=$usuario->endereco?>">   

         <?php
         $acao    = $_REQUEST['acao'];
         $dir_tmp = $_SESSION['dir_tmp'];

         ?>
         <input type="hidden" id="frm_id_mural_fama"  name="frm_id_mural_fama" value ="<?=$dir_tmp?>" >
         
      
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row fundo_branco_1">
            <div class="col-12">
               <span class="font_vermelha_m"><<< Mural da FAMA >>></span>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">                     
               <hr class="hr1">
            </div>
         </div>  

         <div class="row">
            <div class="col-md-12">
               <span class="font_courier_p">
                  <?php
                  print "id_mural_fama: {$id_mural_fama}<br>";
                  print "usuário......: {$usuario->apelido}<br>";
                  print "email........: {$usuario->email}<br>";
                  print "telefone.....: {$usuario->ddd} {$usuario->telefone}<br>";
                  print "endereco.....: {$usuario->endereco}<br>";
                  ?>
               </span>
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">

            <div class="col-md-4">
               <label for="frm_titulo">Título*</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" required  value="<?=$_REQUEST['frm_titulo']?>" maxlength="70"  />
            </div>
            
         </div>   

          <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         <div class="row">    
            <div class="col-12">
               <label for="frm_descricao">Descrição*</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="3" required placeholder="pode escrever sobre seu(s) pet(s)" ><?=$_REQUEST['frm_descricao']?></textarea>
               <div id='div_descricao' class="font_vermelha_p"></div>
            </div>
            <div class="col-12 altura_linha_1"></div>
         </div>
         
         <div class="row">    
            <div class="col-md-12">
               <label for="frm_palavras" class="font_preta_p">Palavras*</label>
               <input type="text" class="form-control form-control-sm" id="frm_palavras" name="frm_palavras" disabled="disabled" value="<?=$_REQUEST['frm_palavras']?>"  >
            </div>
            <div class="col-12 altura_linha_1"></div>
         </div>

          <div class="row">    
            <div class="col-md-8">
               <label for="frm_mais_palavras" class="font_verde_m">Acrescentar mais Palavras*</label>
               <input type="text" class="form-control form-control-sm" id="frm_mais_palavras" name="frm_mais_palavras" value="<?=$_REQUEST['frm_mais_palavras']?>"  >
            </div>
            <div class="col-md-3">
               <label for="frm_data_atualizacao" class="font_verde_m">Data Atualização*</label>
               <input type="text" class="form-control form-control-sm" id="frm_data_atualizacao" name="frm_data_atualizacao" value="<?=$_REQUEST['frm_data_atualizacao']?>"  >
            </div>            
            <div class="col-md-1">
               <label for="frm_ativo" class="font_verde_m">Ativo*</label>
               <input type="text" class="form-control form-control-sm" id="frm_ativo" name="frm_ativo" value="<?=$_REQUEST['frm_ativo']?>"  >
            </div>
            <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">    
            <div class="col-md-12"> 
               <span class="font_cinza_p"><?=$_REQUEST['frm_endereco']?></span>
            </div>
         </div>
         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row border border-sucess rounded fundo_verde_claro">
            <div class="col-md-8">
               Adicione até 3 fotos
               <label for='fileupload' class='file_personalizado'>Escolha as Fotos</label>            
               <input id="fileupload" name="files[]" type="file" data-url="../cadastro/server/php/"  multiple />
                <div id='div_status' style="display: inline-block"></div>                
               <div id="progress" class="progress">
                   <div class="progress-bar progress-bar-success"></div>
               </div>
               <div id='div_fotos'></div>
               <br>
            </div>
            <div class="col-md-4">
                <div id='div_foto_grande'></div>
            </div>
         </div>

         <div class="row">
            <div class="col text-right">
               <input type="submit" name="btnSalvarAnuncio" class="btn btn_inserir_anuncio" value="Enviar para o Mural">
            </div>
         </div>

      </form>
   <?php
   } // exibir_formulario   

   function exibir_formulario_exclusao() {
      
      $mural = new Tools_Cad_Mural_Fama_Hlp();
      $mural->set_id_mural_fama($_REQUEST['frm_id_mural_fama']);
      $mural->obter_dados_mural($dados);
      $dados = $dados[0];

      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario( $dados->id_usuario );
      $usuario->obter_dados_usuario( $usuario );
      
      $fotos = Utils::obter_array_fotos_mural_fama( $dados->id_mural_fama, $dados->data_cadastro, 'T' );
      $pasta_dc = '../fotos_mural/'.date("d_m_Y", strtotime($dados->data_cadastro)).'/';
      if ( $fotos->total_fotos>0 ) { 
         $thumbnail = $pasta_dc.$fotos->fotos[0];
      } else {
         $thumbnail = '../images/sem_foto1.png';
      }
      ?>
      
      <form id="frmCadMuralFamaExclusao" name="frmCadMuralFamaExclusao" class="form-horizontal" action="tools_cad_mural_fama.php" method="POST" enctype="multipart/form-data" role="form">

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_mural_fama" name="frm_id_mural_fama" value = "<?=$_REQUEST['frm_id_mural_fama']?>">
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">
         
         <div class="row fundo_branco_1">
            <div class="col-md-8">
                <span class="font_vermelha_m"><<< Excluir - Mural da Fama >>></span>
            </div>
            <div class="col-4 text-right">
               <a class="link_a" href="tools_cad_mural_fama.php?acao=exibir&comportamento=exibir_listagem" role="button">Voltar</a>
            </div>
         </div>

         <div class="row">            
            <div class="col-12">
               <label for="frm_titulo">Título</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" required  value="<?=$_REQUEST['frm_titulo']?>" readonly />
            </div>
            <div class="col-12">
               <label for="frm_titulo">URL</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" required  value="<?=$_REQUEST['frm_titulo']?>" readonly />
            </div>
         </div>

         <div class="row">    
            <div class="col-md-12">
               <label for="frm_descricao">Descrição</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="3" readonly="readonly" ><?=$_REQUEST['frm_descricao']?></textarea>
            </div>
         </div>

         <div class="row">    
            <div class="col-12">
               <label for="frm_descricao">Dados do Usuário</label><br>
               <div class=" fundo_cinza_2">
                  <span class="font_courier_p">
                     <?php                  
                     print "id_usuario: {$usuario->id_usuario}<br>
                            apelido...: {$usuario->apelido}<br>                         
                            telefone..: ({$usuario->ddd}) {$usuario->telefone}<br>
                            email.....: {$usuario->email}<br>
                            endereço..: {$usuario->endereco}<br>";
                     ?>
                  </span>
               </div>
            </div>
         </div>

         <div class="row">            
            <div class="col-md-12">
               <img src="<?=$thumbnail ?>" class='img-fluid img-thumbnail' >
            </div>
         </div>

         <div class="row">            
            <div class="col-md-12">
               <br>
            </div>
         </div>

         <div class="text-right">
              <input type="submit" name="btnSalvarAnuncio" class="btn btn_inserir_anuncio" value="Confirmar Exclusão">
         </div>

      </form>
   <?php
   } // exibir_formulario_exclusao

      
    function exibir_listagem() {?>
      <form id="formulario" name="formulario" class="form-horizontal" action="tools_cad_mural_fama.php" method="POST" enctype="multipart/form-data" role="form">

         <?php
         $filtro_palavra_chave = isset($_REQUEST['frm_filtro_palavra_chave']) ? trim($_REQUEST['frm_filtro_palavra_chave']) : '';
         ?>

         <div class="row">
            <div class="col-12 text-right">            
               <a class="btn btn-outline-success btn_link" href="tools_manutencao.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
            </div>  
         </div>

         <input type="hidden" id="comportamento" name="comportamento" value = "exibir_listagem">
         <input type="hidden" id="acao" name="acao" value = "<?=$_REQUEST['acao']?>">
        
         <?php
         include_once 'tools_cabecalho.php';?>      
         
         <div class="row">
            <div class="col-md-12">                     
               <hr class="hr1">
            </div>
         </div>  

         <div class="row fundo_branco_1">
            <div class="col-md-12">
                <span class="font_vermelha_m"><<< Manutenção - Mural Fama >>></span>
            </div>
         </div>
          
         <!-- filtros unico  -->
         <div class="row fundo_cinza_1">            
            <div class="col-12 col-sm-6 col-md-5 col-lg-3 col-xl-3 text-center">
               <div class="input-group">                     
                  <input type="text" class="form-control form-control-sm" id='frm_filtro_palavra_chave' name='frm_filtro_palavra_chave' value="<?=$filtro_palavra_chave;?>" placeholder="Buscar por palavra-chave" >
                  <div class="input-group-append">
                     <button type="button" class="btn btn_lupa1" id='btnBuscar' name='btnBuscar' onclick="submeter_form()"><img src="../images/lupa.png"></button>
                  </div>
               </div>
            </div>
         </div>

         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_1 fundo_branco_1"></div>
         </div>
         <?php
            $instancia = new Tools_Cad_Mural_Fama_Hlp();
            $instancia->set_filtro_palavra_chave($filtro_palavra_chave);
            $instancia->obter_dados_mural( $dados_mural );
              
            $i = 0;
            foreach ( $dados_mural as $item ) {

               $usuario = new Cad_Usuario_Hlp();
               $usuario->set_id_usuario( $item->id_usuario );
               $usuario->obter_dados_usuario( $usuario );


               if ( $item->ativo == 'S' ) {
                  $ativo     = 'Publicado';
                  $cor_ativo = 'font_verde_p';
               } else {
                  $ativo     = 'Aguardando Publicação';
                  $cor_ativo = 'font_vermelha_p';
               }
               
               
               $dados = Utils::obter_array_fotos_mural_fama( $item->id_mural_fama, $item->data_cadastro, 'S' );
               $pasta_dc = '../fotos_mural/'.date("d_m_Y", strtotime($item->data_cadastro)).'/';
               if ( $dados->total_fotos>0 ) { 
                  $nome_thumbnail = $pasta_dc.$dados->fotos[0];
               } else {
                  $nome_thumbnail = '../images/sem_foto1.png';
               }
               ?>

               <div class="row">
                  <div class="col-md-12">                     
                     <hr class="hr1">
                  </div>
               </div>  

                <div class="row">               
                  <div class="col-auto">
                     <span class="font_preta_p"><?=$item->titulo?></span>
                  </div>
               </div>              

               <div class="row">
                  <div class="col-auto">
                     <span class="<?=$cor_ativo?>"><?=$ativo;?></span>
                  </div>
                   
               </div> 

               <div class="row">
                  <div class="col-3">
                     <img src="<?=$nome_thumbnail ?>" class='img-fluid img-thumbnail sem_margem' style='min-width:110px;min-height:110px' width='40' >
                  </div>
                  <div class="col-2">                  
                      &nbsp;
                  </div>
                  <div class="col-7">   
                     <a class="btn btn-outline link_a" href="tools_cad_mural_fama.php?acao=alteracao&comportamento=exibir_formulario&frm_id_mural_fama=<?=$item->id_mural_fama?>"><img src="../images/editar.svg">&nbsp;Editar</a>               
                     <a class="btn btn-outline link_a" href="tools_cad_mural_fama.php?acao=exclusao&comportamento=exibir_formulario_exclusao&frm_id_mural_fama=<?=$item->id_mural_fama?>"><img src="../images/excluir.svg">&nbsp;Excluir</a>
                     <br>
                     <span class="font_cinza_p"><?=Utils::data_anuncio($item->data_atualizacao)?><br></span>
                     <span class="font_cinza_p"><?="apelido.: {$usuario->apelido}"?><br></span>
                     <span class="font_cinza_p"><?="email...: {$usuario->email}"?><br></span>
                     <span class="font_cinza_p"><?="palavras: {$item->palavras}-{$item->mais_palavras}"?><br></span>
                  </div>
               </div>
            <?php
            }
         ?>
       

      </form>
   <?php
   } // exibir_listagem

   function exibir_formulario_ok( $acao, $titulo) {
      include_once 'tools_cabecalho.php';
      ?>    
      <div class="row">

         <div class="col-12">
            <br>
            <?php
            if ( $acao=='alteracao' ) {?>
               <span class="font_cinza_p">O Mural da fama:</span>
               <span class="font_azul_p"><?=$titulo?><br></span>
               <span class="font_cinza_p">Foi Alterado com sucesso.</span><br>
            <?php
            
            } elseif ( $acao=='exclusao' ) {?>
               <span class="font_cinza_p">O Mural da fama:</span>
               <span class="font_azul_p"><?=$titulo?><br></span>
               <span class="font_cinza_p">Foi EXCLUÍDO com sucesso.</span><br>
            <?php
            }
            ?>
            <br>               
         </div>            
      </div>    

      <div class="row fundo_branco_1">
         <div class="col-12">
            <a class="link_a" href="tools_cad_mural_fama.php?acao=exibir&comportamento=exibir_listagem" role="button">Voltar</a>
         </div>
      </div>

   <?php
   } // exibir_formulario_ok  
      
   function verificar_acao() {      

      $comportamento = $_REQUEST['comportamento'];

      switch ($comportamento) {         
         
         case 'exibir_formulario':           
            igualar_formulario();
            exibir_formulario();
            break;
         
         case 'exibir_formulario_exclusao':
            igualar_formulario();
            exibir_formulario_exclusao();
            break;

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
   
   function igualar_formulario() {
      $mural = new Tools_Cad_Mural_Fama_hlp();
      $mural->set_id_mural_fama( $_REQUEST['frm_id_mural_fama'] );
      $mural->obter_dados_mural( $dados_mural );
      $dados = $dados_mural[0];

      $_REQUEST['frm_id_usuario'] = $dados->id_usuario;
      $_REQUEST['frm_endereco'  ] = $dados->endereco;
      
      
      $_REQUEST['frm_titulo'   ] = $dados->titulo;
      $_REQUEST['frm_descricao'] = $dados->descricao;
      $_REQUEST['frm_ativo'    ] = $dados->ativo;
      $_REQUEST['frm_data_cadastro'   ] = $dados->data_cadastro;
      $_REQUEST['frm_data_atualizacao'] = $dados->data_atualizacao;
      $_REQUEST['frm_ddd'             ] = $dados->ddd;
      $_REQUEST['frm_telefone'        ] = $dados->telefone;      
      $_REQUEST['frm_endereco'        ] = $dados->endereco;
      $_REQUEST['frm_cep'             ] = $dados->cep;
      $_REQUEST['frm_id_logradouro'   ] = $dados->id_logradouro;
      $_REQUEST['frm_ativo'           ] = $dados->ativo;
      $_REQUEST['frm_palavras'        ] = $dados->palavras;
      $_REQUEST['frm_mais_palavras'   ] = $dados->mais_palavras;

      $_SESSION['dir_tmp'      ] = date('Ymd').'_'.$dados->id_mural_fama;  
      $_SESSION['acao'         ] = 'alteracao';         

      $fotos = new Fotos_Mural_Fama();         
      $fotos->prepara_pasta_foto_para_alteracao( $dados->id_mural_fama, $dados->data_cadastro );

   } // igualar_formulario
  
   function efetivar() {
      $mural = new Tools_Cad_Mural_Fama_Hlp();
      $mural->set_id_mural_fama( $_REQUEST['frm_id_mural_fama'] );
      $mural->obter_dados_mural( $dados_mural );
      
      switch ($_REQUEST['acao']) {
         
         case 'alteracao':
            igualar_objeto($mural);
            $mural->set_id_mural_fama( $_REQUEST['frm_id_mural_fama'] );      
            $mural->alterar();
            exibir_formulario_ok( $_REQUEST['acao'], $_REQUEST['frm_titulo'] );
            break;
         
         case 'exclusao':
            $mural->set_id_mural_fama( $_REQUEST['frm_id_mural_fama'] );
            $mural->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );
            $mural->excluir();
            exibir_formulario_ok( $_REQUEST['acao'], $_REQUEST['frm_titulo'] );
            break;
         
         default:
            # code...
            break;            
      }
       
   } // efetivar
   
   
   function igualar_objeto( &$mural ) {      
      $mural->set_id_usuario( $_REQUEST['frm_id_usuario'] );
      $mural->set_titulo( $_REQUEST['frm_titulo'] );
      $mural->set_descricao( $_REQUEST['frm_descricao'] );
      $mural->set_mais_palavras( $_REQUEST['frm_mais_palavras'] );
      $mural->set_ativo( $_REQUEST['frm_ativo'] );
      $mural->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );  
      $mural->set_data_atualizacao(  $_REQUEST['frm_data_atualizacao'] );
      $mural->set_endereco(  $_REQUEST['frm_endereco'] ); 
   } // igualar_objeto
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
            <span class="font_cinza_p">Copyright © 2018 www.oviralata.com.br<br>Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>         
   
   </div> <!-- container -->

   <!--  -->
   <script src="../dist/js/load-image/load-image.all.min.js"></script>
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>

    <script src="../dist/js/tools_upload_mural.js"></script>

   
   <!--  
   -->
   
   <script src="../dist/jquery_mask/dist/jquery.mask.min.js"></script>

   <script src="../dist/jquery_file_upload/js/jquery.fileupload.js"></script>
   <script src="../dist/jquery_file_upload/js/jquery.iframe-transport.js"></script>
   <script src="../dist/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>

<sript>
   
   
</script>



</body>

</html>