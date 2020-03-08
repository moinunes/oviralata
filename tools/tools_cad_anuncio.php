<?php
session_start();

include_once '../cadastro/utils.php';
include_once 'tools_cad_anuncio_hlp.php';
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
      $id_anuncio = $_REQUEST['frm_id_anuncio'];

      $tipo_anuncio = new Tools_Cad_Anuncio_Hlp();
      $tipo_anuncio->obter_tipo_anuncio($tipos_anuncio);
      $id_tipo_anuncio = $_REQUEST['frm_tipo_anuncio'];

      $categoria = new Tools_Cad_Anuncio_Hlp();
      $categoria->obter_categoria($todas_categorias);
      $id_categoria = $_REQUEST['frm_categoria'];

      $racas = new Tools_Cad_Anuncio_Hlp();
      $racas->obter_todas_racas( $todas_racas, $id_categoria);
      $id_raca = $_REQUEST['frm_raca'];

      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($_REQUEST['frm_id_usuario']);
      $usuario->obter_dados_usuario( $usuario );

      include_once 'tools_cabecalho.php';
         
      ?>
      <form id="frmCadAnuncio" name="frmCadAnuncio" class="form-horizontal" action="tools_cad_anuncio.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return validar_submit();">

         <div id='div_buscar'></div>         

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_logradouro" name="frm_id_logradouro" value = "<?=$_REQUEST['frm_id_logradouro']?>">         
         <input type="hidden" id="frm_id_usuario"    name="frm_id_usuario"    value = "<?=$_REQUEST['frm_id_usuario']?>">         
         <input type="hidden" id="frm_endereco"      name="frm_endereco"      value = "<?=$usuario->endereco?>">         
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">     
         <input type="hidden" id="frm_origem"        name="frm_origem"        value ="anuncio" >
        
         <?php
         $acao    = $_REQUEST['acao'];
         $dir_tmp = $_SESSION['dir_tmp'];

         ?>

         <input type="hidden" id="frm_id_anuncio"  name="frm_id_anuncio" value ="<?=$dir_tmp?>" >

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row fundo_branco_1">
            <div class="col-12">
                <span class="font_vermelha_m">Alterar Anúncio</span>
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
                  print "id_anuncio: {$id_anuncio}<br>";
                  print "usuário...: {$usuario->apelido}<br>";
                  print "email.....: {$usuario->email}<br>";
                  print "celular...: {$usuario->ddd_celular} {$usuario->tel_celular}<br>";
                  print "WhatzApp..: {$usuario->ddd_whatzapp} {$usuario->tel_whatzapp}<br>";
                  print "Fixo......: {$usuario->ddd_fixo} {$usuario->tel_fixo}<br>";
                  
                  print "endereco..: {$usuario->endereco}<br>";
                  ?>
               </span>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">                     
               <hr class="hr1">
            </div>
         </div>  

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_tipo_anuncio">Tipo*</label>
               <select id='frm_tipo_anuncio' name='frm_tipo_anuncio' class="form-control form-control-sm" required="required" onchange="obter_categorias(this)" >
                  <option value=""></option>
                  <?php
                  foreach ( $tipos_anuncio as $item ) {?>
                     <option value="<?=$item->id_tipo_anuncio?>" <?= $id_tipo_anuncio==$item->id_tipo_anuncio ? "selected" : '';?> data-codigo="<?=$item->codigo?>" ><?=$item->tipo_anuncio?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>

            <div class="col-md-2" id='div_categoria'>
               <label for="frm_categoria">Categoria*</label>
               <select id='frm_categoria' name='frm_categoria' class="form-control form-control-sm" required="required" onchange="obter_racas(this)" >
                  <option value=""></option>
                  <?php
                  if($_REQUEST['acao']=='alteracao') {
                     foreach ( $todas_categorias as $item ) {?>
                        <option value="<?=$item->id_categoria?>" <?= $id_categoria==$item->id_categoria ? "selected" : '';?> data-codigo="<?=$item->codigo?>" ><?=$item->categoria?></option>
                     <?php
                     }
                  }
                  ?>
               </select>
            </div>   

            <div class="col-md-2" id='div_raca' style="display:none;" >
               <label for="frm_raca">Raça*</label>
               <select id='frm_raca' name='frm_raca' class="form-control form-control-sm" >
                  <option value=""></option>
                  <?php
                  if($_REQUEST['acao']=='alteracao') {
                     foreach ( $todas_racas as $item ) {?>
                        <option value="<?=$item->id_raca?>" <?= $id_raca==$item->id_raca ? "selected" : '';?> data-codigo="<?=$item->codigo?>" ><?=$item->raca?></option>
                     <?php
                     }
                  }
                  ?>            
               </select>
            </div>   
               
            <div class="col-md-4">
               <label for="frm_titulo">Título*</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" required  value="<?=$_REQUEST['frm_titulo']?>" maxlength="70"  />
            </div>
            
         </div>   

          <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         <div class="row">    
            <div class="col-md-12">
               <label for="frm_descricao">Descrição*</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="5" required placeholder="inclua uma breve descrição para o seu anúncio" ><?=$_REQUEST['frm_descricao']?></textarea>
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
            <div class="col-md-2"> 
               <label for="frm_cep">Cep*</label>               
                <input type="text" class="form-control form-control-sm" id="frm_cep" name="frm_cep" value="<?=$_REQUEST['frm_cep']?>" required="required" data-mask="00000-000" >
            </div>
            <div class="col-md-12"> 
               <div id='div_endereco'><?=$_REQUEST['frm_endereco']?></div>
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
               <label for='fileupload' class='file_personalizado'>Escolha as Fotos...</label>            
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
               <input type="submit" name="btnSalvarAnuncio" class="btn btn_inserir_anuncio" value="Enviar anúncio">
            </div>
         </div>

      </form>
   <?php
   } // exibir_formulario   

   function exibir_formulario_exclusao() {
      
      $anuncios = new Tools_Cad_Anuncio_Hlp();
      $anuncios->set_id_anuncio($_REQUEST['frm_id_anuncio']);
      $anuncios->obter_anuncios($consulta_anuncios);
      $anuncio = $consulta_anuncios[0];
      
      $tipo_anuncio = new Tools_Cad_Anuncio_Hlp();
      $tipo_anuncio->obter_tipo_anuncio($tipo_anuncio, $anuncio->id_tipo_anuncio );
      $tipo_anuncio = $tipo_anuncio[0]->tipo_anuncio;

      $instancia = new Tools_Cad_Anuncio_Hlp();
      $instancia->obter_categoria( $resultado, $anuncio->id_categoria );
      $categoria = $resultado[0]->categoria;
      
      $instancia = new Tools_Cad_Anuncio_Hlp();
      $instancia->obter_raca( $raca, $anuncio->id_raca );

      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario( $anuncio->id_usuario );
      $usuario->obter_dados_usuario( $usuario );

      $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'S' );
      $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
      
      if ( $dados->total_fotos>0 ) { 
         $thumbnail = $pasta_dc.$dados->fotos[0];
      } else {
         $thumbnail = '../images/sem_foto1.png';
      }
      ?>

      <form id="frmCadAnuncioExclusao" name="frmCadAnuncioExclusao" class="form-horizontal" action="tools_cad_anuncio.php" method="POST" enctype="multipart/form-data" role="form">

         <input type="hidden" id="comportamento"   name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"            name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_anuncio"  name="frm_id_anuncio"    value = "<?=$_REQUEST['frm_id_anuncio']?>">
         <input type="hidden"   id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">
         
         <div class="row fundo_branco_1">
            <div class="col-md-8">
                <span class="font_cinza_g"><<< Excluir Anúncio >>></span>
            </div>
            <div class="col-4 text-right">
               <a class="link_a" href="tools_cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">Voltar</a>
            </div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_tipo_anuncio">ID anúncio</label>
               <input type="text" class="form-control form-control-sm" id="frm_id_anuncio" name="frm_id_anuncio" value="<?=$_REQUEST['frm_id_anuncio']?>" readonly  />
            </div>    

            <div class="col-md-2">
               <label for="frm_tipo_anuncio">Tipo</label>
               <input type="text" class="form-control form-control-sm" id="frm_tipo_anuncio" name="frm_tipo_anuncio" value="<?=$tipo_anuncio?>" readonly  />
            </div>    

            <div class="col-md-2">
               <label for="frm_titulo">Categoria</label>
               <input type="text" class="form-control form-control-sm" id="frm_codigo" name="frm_codigo" required  value="<?=$categoria?>" readonly />
            </div>
            <?php
            if($anuncio->raca) {?>
               <div class="col-md-2">
                  <label for="frm_titulo">Raça</label>
                  <input type="text" class="form-control form-control-sm" value="<?=$raca->raca?>" readonly />
               </div>
               <?php
            }?>
            <div class="col-md-8">
               <label for="frm_titulo">Título</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" required  value="<?=$_REQUEST['frm_titulo']?>" readonly />
            </div>

         </div>

         <div class="row">    
            <div class="col-md-12">
               <label for="frm_descricao">Descrição</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="2" readonly="readonly" ><?=$_REQUEST['frm_descricao']?></textarea>
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
                            Celular...: ({$usuario->ddd_celular}) {$usuario->tel_celular}<br>
                            WhatzApp..: ({$usuario->ddd_whatzapp}) {$usuario->tel_whatzapp}<br>
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
      <form id="formulario" name="formulario" class="form-horizontal" action="tools_cad_anuncio.php" method="POST" enctype="multipart/form-data" role="form">

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
                <span class="font_vermelha_m"><<< Manutenção de Anúncios >>></span>
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
            $instancia = new Tools_Cad_Anuncio_Hlp();
            $instancia->set_filtro_palavra_chave($filtro_palavra_chave);
            $instancia->obter_anuncios( $anuncios ); 
            $i = 0;
            foreach ( $anuncios as $anuncio ) {
               
               $usuario = new Cad_Usuario_Hlp();
               $usuario->set_id_usuario( $anuncio->id_usuario );
               $usuario->obter_dados_usuario( $usuario );

               if ( $anuncio->ativo == 'S' ) {
                  $ativo     = 'Publicado';
                  $cor_ativo = 'font_verde_p';
               } else {
                  $ativo     = 'Aguardando Publicação';
                  $cor_ativo = 'font_vermelha_p';
               }
               
               $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'S' );
               
               $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
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
                     <span class="font_preta_g"><?=$anuncio->tipo_anuncio.' - '.$anuncio->categoria?></span>
                  </div>
               </div>
               
                <div class="row">               
                  <div class="col-auto">
                     <span class="font_preta_p"><?=$anuncio->titulo?></span>
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
                     <a class="btn btn-outline link_a" href="tools_cad_anuncio.php?acao=alteracao&comportamento=exibir_formulario&frm_id_anuncio=<?=$anuncio->id_anuncio?>"><img src="../images/editar.svg">&nbsp;Editar</a>               
                     <a class="btn btn-outline link_a" href="tools_cad_anuncio.php?acao=exclusao&comportamento=exibir_formulario_exclusao&frm_id_anuncio=<?=$anuncio->id_anuncio?>"><img src="../images/excluir.svg">&nbsp;Excluir</a>
                     <br>
                     <span class="font_cinza_p"><?=Utils::data_anuncio($anuncio->data_atualizacao)?><br></span>
                     <span class="font_cinza_p"><?="id_anuncio......: {$anuncio->id_anuncio}"?><br></span>
                     <span class="font_cinza_p"><?="apelido.........: {$usuario->apelido}"?><br></span>
                     <span class="font_cinza_p"><?="email...........: {$usuario->email}"?><br></span>
                     <span class="font_cinza_p"><?="data_cadastro...: {$anuncio->data_cadastro}"?><br></span>
                     <span class="font_cinza_p"><?="data_atualizacao: {$anuncio->data_atualizacao}"?><br></span>
                     <span class="font_cinza_p"><?="palavras........: {$anuncio->palavras}"?><br></span>
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
               <span class="font_cinza_p">O anúncio:</span>
               <span class="font_azul_p"><?=$titulo?><br></span>
               <span class="font_cinza_p">Foi Alterado com sucesso.</span><br>
            <?php
            
            } elseif ( $acao=='exclusao' ) {?>
               <span class="font_cinza_p"><?=$_SESSION['apelido']?><br></span>
               <span class="font_cinza_p">Seu anúncio:</span>
               <span class="font_azul_p"><?=$titulo?></span>
               <span class="font_cinza_p">foi EXCLUÍDO com sucesso.</span><br>
            <?php
            }
            ?>
            <br>               
         </div>            
      </div>    

      <div class="row fundo_branco_1">
         <div class="col-12">
            <a class="link_a" href="tools_cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">Voltar</a>
         </div>
      </div>

   <?php
   } // exibir_formulario_ok  
   
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
      $instancia = new Tools_Cad_Anuncio_Hlp();
      $instancia->set_id_anuncio( $_REQUEST['frm_id_anuncio'] );
      $instancia->obter_anuncios( $anuncio );
      $anuncio = $anuncio[0];

      $_REQUEST['frm_id_anuncio'     ] = $anuncio->id_anuncio;
      $_REQUEST['frm_id_usuario'     ] = $anuncio->id_usuario;  
      $_REQUEST['frm_tipo_anuncio'   ] = $anuncio->id_tipo_anuncio;
      $_REQUEST['frm_categoria'      ] = $anuncio->id_categoria;
      $_REQUEST['frm_raca'           ] = $anuncio->id_raca;
      $_REQUEST['frm_titulo'         ] = $anuncio->titulo;
      $_REQUEST['frm_descricao'      ] = $anuncio->descricao;  
      $_REQUEST['frm_data_cadastro'  ] = $anuncio->data_cadastro;
      $_REQUEST['frm_data_atualizacao'] = $anuncio->data_atualizacao;
      
      $_REQUEST['frm_ddd_fixo'       ] = $anuncio->ddd_fixo;
      $_REQUEST['frm_ddd_celular'    ] = $anuncio->ddd_celular;
      $_REQUEST['frm_ddd_whatzapp'   ] = $anuncio->ddd_whatzapp;
      
      $_REQUEST['frm_tel_fixo'       ] = $anuncio->tel_fixo;
      $_REQUEST['frm_tel_celular'    ] = $anuncio->tel_celular;
      $_REQUEST['frm_tel_whatzapp'   ] = $anuncio->tel_whatzapp;
      
      $_REQUEST['frm_endereco'       ] = $anuncio->endereco;
      $_REQUEST['frm_cep'            ] = $anuncio->cep;
      $_REQUEST['frm_id_logradouro'  ] = $anuncio->id_logradouro;
      $_REQUEST['frm_ativo'          ] = $anuncio->ativo;
      $_REQUEST['frm_palavras'       ] = $anuncio->palavras;
      $_REQUEST['frm_mais_palavras'  ] = $anuncio->mais_palavras;
   
      $_SESSION['dir_tmp'] = date('Ymd').'_'.$_REQUEST['frm_id_anuncio'];  
      $_SESSION['acao'   ] = 'alteracao';  
      
      $fotos = new Fotos();
      $fotos->prepara_pasta_foto_para_alteracao($anuncio->id_anuncio,$anuncio->data_cadastro);
      
   } // igualar_formulario
  
   function efetivar() {
      $anuncio = new Tools_Cad_Anuncio_Hlp();

      switch ($_REQUEST['acao']) {
         
         case 'alteracao':
            igualar_objeto($anuncio);
            $anuncio->set_id_anuncio( $_REQUEST['frm_id_anuncio'] );      
            $anuncio->alterar();
            exibir_formulario_ok( $_REQUEST['acao'], $anuncio->get_titulo() );
            break;
         
         case 'exclusao':
            $anuncio->set_id_anuncio( $_REQUEST['frm_id_anuncio'] );
            $anuncio->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );
            $anuncio->excluir();
            exibir_formulario_ok( $_REQUEST['acao'], $anuncio->get_titulo() );
            break;
         
         default:
            # code...
            break;            
      }
      ?>          
            
   <?php
   } // efetivar
   
   function igualar_objeto( &$anuncio ) {      
      $anuncio->set_id_tipo_anuncio( $_REQUEST['frm_tipo_anuncio'] );
      $anuncio->set_id_categoria( $_REQUEST['frm_categoria'] );
      $anuncio->set_id_raca( $_REQUEST['frm_raca'] );
      $anuncio->set_id_usuario( $_REQUEST['frm_id_usuario'] );
      $anuncio->set_titulo( $_REQUEST['frm_titulo'] );
      $anuncio->set_mais_palavras( $_REQUEST['frm_mais_palavras'] );
      $anuncio->set_descricao( $_REQUEST['frm_descricao'] );
      $anuncio->set_ativo(  $_REQUEST['frm_ativo'] );
      $anuncio->set_id_logradouro( $_REQUEST['frm_id_logradouro'] );
      $anuncio->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );      
      $anuncio->set_data_atualizacao(  $_REQUEST['frm_data_atualizacao'] );      
      $anuncio->set_endereco($_REQUEST['frm_endereco'] );      
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
            <span class="font_cinza_p">Copyright © 2018 www.adotabrasil.com.br<br></span>
            <span class="font_cinza_p">Todos os direitos reservados. </span>
            
            <br><br>
         </div>            
      </div>         
   
   </div> <!-- container -->

   <!--  -->
   <script src="../dist/js/load-image/load-image.all.min.js"></script>
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>


    <script src="../dist/js/tools_upload_anuncio.js"></script>
   
   <!--  
   -->
   
   <script src="../dist/js/tools_cadastro_anuncio.js"></script>
   <script src="../dist/jquery_mask/dist/jquery.mask.min.js"></script>

   <script src="../dist/jquery_file_upload/js/jquery.fileupload.js"></script>
   <script src="../dist/jquery_file_upload/js/jquery.iframe-transport.js"></script>
   <script src="../dist/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>

<script>
   
   function submeter_form( pagina = '1') {
      $('#comportamento').val( 'exibir_listagem' );
      document.forms['formulario'].submit();
   }
   
</script>



</body>

</html>