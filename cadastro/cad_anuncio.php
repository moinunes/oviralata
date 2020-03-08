<?php
session_start();

include_once 'utils.php';
include_once 'cad_anuncio_hlp.php';
include_once 'cad_servico_hlp.php';
include_once 'cad_usuario_hlp.php';
   
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
     
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   <link rel="stylesheet" href="../dist/fonts/fonts.css" >
   
</head>

<body class="fundo_cinza_1">

<div class="container">
   <?php
   include_once 'cad_cabecalho_1.php';
 
   verificar_acao();

   function exibir_formulario() {
      $acao = $_REQUEST['acao'];
      $comportamento = $_REQUEST['comportamento'];

      $tipo_anuncio = new Cad_Anuncio_Hlp();
      $tipo_anuncio->obter_tipo_anuncio($tipos_anuncio);
      $id_tipo_anuncio = $_REQUEST['frm_tipo_anuncio'];

      $categoria = new Cad_Anuncio_Hlp();
      $categoria->obter_categoria($todas_categorias);
      $id_categoria = $_REQUEST['frm_categoria'];

      $racas = new Cad_Anuncio_Hlp();
      $racas->obter_todas_racas( $todas_racas, $id_categoria);
      $id_raca = $_REQUEST['frm_raca'];

      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($_SESSION['id_usuario']);
      $usuario->obter_dados_usuario( $usuario );
      
      
      if ( $acao=='inclusao' ) {  
         $texto_1 = 'Preencha os campos abaixo:';  
      } else if ($acao=='alteracao') {
         $texto_1 = 'Aqui você pode <b>editar as informações e fotos</b> do seu anúncio!';
      }

      ?>
      <form id="frmCadAnuncio" name="frmCadAnuncio" class="form-horizontal" action="cad_anuncio.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return validar_submit();">

         <div id='div_buscar'></div>         

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_logradouro" name="frm_id_logradouro" value = "<?=$_REQUEST['frm_id_logradouro']?>">         
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">     
         <input type="hidden" id="frm_ativo"         name="frm_ativo"         value = "<?=$_REQUEST['frm_ativo']?>">          
         <input type="hidden" id="frm_origem"        name="frm_origem"        value ="anuncio" >

         <?php

         if ( $acao=='inclusao' ) {
            $texto_1 = 'Preencha os campos abaixo:';  
         } else if ($acao=='alteracao') {
            $texto_1 = 'Aqui você pode <b>editar as informações e fotos</b> do seu anúncio!';
         }

         $dir_tmp = $_SESSION['dir_tmp'];

         if ( trim($usuario->id_logradouro)=='' ) {?>
           <div class="row">
              <div class="col-12 altura_linha_2"></div>
           </div>
            <div class="row">
                <div class="col-12 border border-sucess rounded fundo_laranja_1">
                     <br>
                     <a class="link_a" href="cad_usuario.php?acao=alteracao&comportamento=exibir_formulario_alteracao">Olá, <?=$usuario->nome_completo?><br><br>Por favor Clique Aqui e termine de preencher seu Cadastro!</a>
                     <br><br>
                </div>
            </div>
            <?php
            die();
         }

         if ( $acao=='inclusao' ) {
            $titulo='< Inserir Anúncio >';
            ?>
            <input type="hidden" id="frm_id_anuncio"  name="frm_id_anuncio" value ="<?=$dir_tmp?>" >
         <?php
         } else if ( $acao=='alteracao' ) {    
            $titulo='<<< Editar Anúncio >>>';
            ?>
            <input type="hidden" id="frm_id_anuncio"  name="frm_id_anuncio" value ="<?=$dir_tmp?>" >
         <?php
         }
         ?>
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row  margem_1">
            <div class="col-12 text">
                <span class="font_verde_g"><?=$titulo?></span>
            </div>
            <div class="col-12 text">
                <span class="font_verde_g">Doação ou Pet Desaparecido</span>
            </div>
         </div>
      
         <div class="row">
            <div class="col-12 altura_linha_2"></div>
         </div>  

         <div class="row fundo_branco_1">
            <div class="col-12">
               <span class="font_cinza_g"><?=$texto_1?></span>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">                     
               <hr class="hr1">
               <div id='div_mens_0' class="font_vermelha_m"></div>
            </div>
         </div>  

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_tipo_anuncio">Tipo*</label>
               <select id='frm_tipo_anuncio' name='frm_tipo_anuncio' class="form-control form-control-sm" onchange="obter_categorias(this)" >
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
               <select id='frm_categoria' name='frm_categoria' class="form-control form-control-sm"  onchange="obter_racas(this)" >
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
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo"  value="<?=$_REQUEST['frm_titulo']?>" maxlength="70"  />
            </div>
            
         </div>   

          <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         <div class="row">    
            <div class="col-md-12">
               <label for="frm_descricao">Descrição*</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="5"  placeholder="inclua uma breve descrição para o seu anúncio" ><?=$_REQUEST['frm_descricao']?></textarea>
               <div id='div_descricao' class="font_vermelha_p"></div>
            </div>
            <div class="col-12 altura_linha_1"></div>
         </div>
         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row border border-sucess rounded fundo_verde_claro fundo_verde_claro">
            <div class="col-md-12">
               Adicione até 3 fotos
               <label for='fileupload' class='file_personalizado'>Escolha as Fotos...</label>            
               <input id="fileupload" name="files[]" type="file" data-url="server/php/"  multiple />
                <div id='div_status' style="display: inline-block"></div>                
               <div id="progress" class="progress">
                   <div class="progress-bar progress-bar-success"></div>
               </div>
               <div id='div_fotos'></div>
               <br>
            </div>           
         </div>

         <div class="row text-center">
            <div class="col-12">
               <div id='div_mens_1' class="font_vermelha_m"></div> 
            </div>
            <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col text-center">
               <input type="submit" name="btnSalvarAnuncio" class="btn btn_inserir_anuncio" value="Enviar anúncio">
            </div>
         </div>

      </form>
   <?php
   } // exibir_formulario   

   function exibir_formulario_exclusao() {
      
      $anuncios = new Cad_Anuncio_Hlp();
      $anuncios->set_id_anuncio($_REQUEST['frm_id_anuncio']);
      $anuncios->obter_anuncios($consulta_anuncios);
      $anuncio = $consulta_anuncios[0];

      $tipo_anuncio = new Cad_Anuncio_Hlp();
      $tipo_anuncio->obter_tipo_anuncio($tipo_anuncio, $anuncio->id_tipo_anuncio );
      $tipo_anuncio = $tipo_anuncio[0]->tipo_anuncio;

      $instancia = new Cad_Anuncio_Hlp();
      $instancia->obter_categoria( $resultado, $anuncio->id_categoria );
      $categoria = $resultado[0]->categoria;
      
      $instancia = new Cad_Anuncio_Hlp();
      $instancia->obter_raca( $raca, $anuncio->id_raca );
      
      ?>

      <form id="frmCadAnuncioExclusao" name="frmCadAnuncioExclusao" class="form-horizontal" action="cad_anuncio.php" method="POST" enctype="multipart/form-data" role="form">

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_anuncio"    name="frm_id_anuncio"    value = "<?=$_REQUEST['frm_id_anuncio']?>">
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">
   

         <div class="row  margem_1">
            <div class="col-12 text-center">
                <span class="font_verde_g"><<< Excluir meu Anúncio >>></span>
            </div>
         </div>

         <div class="row">
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
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="3" readonly="readonly" ><?=$_REQUEST['frm_descricao']?></textarea>
            </div>
         </div>

         <div class="row">            
            <div class="col-md-12">
               <br>
            </div>
         </div>


         <div class="row">
            <div class="col-5 text-center">
               <a class="link_a" href="cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">Cancelar</a>
            </div>
            <div class="col-7">
                 <input type="submit" name="btnSalvarAnuncio" class="btn btn_inserir_anuncio" value="Confirmar Exclusão">
            </div>
         </div>

      </form>
   <?php
   } // exibir_formulario_exclusao


   function exibir_formulario_renovar() {
      
      $instancia = new Cad_Anuncio_Hlp();
      $instancia->set_id_anuncio($_REQUEST['frm_id_anuncio']);
      $instancia->renovar_anuncio();

      $anuncio = new Cad_Anuncio_Hlp();
      $anuncio->obter_dados_do_anuncio( $dados, $_REQUEST['frm_id_anuncio'] );
      ?>

      <div class="row  margem_pequena">
         <div class="col-12 altura_linha_1"></div>
         <div class="col-12">
         </span><span class="text">Olá <?=$_SESSION['apelido']?><br></span>
            <span class="tit_1">Seu anúncio foi renovado com sucesso, e agora será exibido no topo das pesquisas do site.<br></span>
            <span class="font_courier_p">Data de Publicação: </span>
            <span class="tit_1"><?=date('d-m-Y')?><br></span>
         </div>
         <div class="col-12 altura_linha_2"></div> 
         <div class="col-12">
            <span class="text">
                Quero visualizar<a href='../adotar.php'> meu Anúncio!</a><br><br>
            </span>
         </div>
      </div>

      <div class="row">
         <div class="col-12 altura_linha_1"></div>
         <div class="col-12 altura_linha_2"></div>
      </div> 
      <!-- depois do rodapé -->
      <div class="shadow p-1 mb-1 bg-white rounded">
         <div class="col-12 text-center" style="border-color: #f3f9f0;" >
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-format="fluid"
                 data-ad-layout-key="-fb+5w+4e-db+86"
                 data-ad-client="ca-pub-2582645504069233"
                 data-ad-slot="8484848734"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>    
         
         </div>
      </div>
   <?php
   } // exibir_formulario_renovar

      
   function exibir_listagem() {?>
      <form id="formulario" class="form-horizontal" action="cadastro_imovel.php" method="POST" enctype="multipart/form-data" role="form">

         <input type="hidden" id="comportamento" name="comportamento" value = "exibir_listagem">
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
      
         <div class="row margem_1">
            <div class="col-md-12 text-center">
                <span class="font_verde_g">< Meus Anúncios ></span>
            </div>
         </div>
         <?php
         $tem_anuncio = false;
         
         // anúncios Doação-Pet Desaparecido
         $instancia = new Cad_Anuncio_Hlp();
         $instancia->set_id_usuario( $_SESSION['id_usuario'] );
         $instancia->obter_anuncios( $anuncios );
         $i = 0;
         foreach ( $anuncios as $anuncio ) {
            $tem_anuncio = true;         
            if ( $anuncio->ativo == 'S' ) {
               $ativo     = 'Data de Publicação: ';
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
            <div class="row shadow p-1 mb-1 bg-white rounded">
               <div class="col-12">

                  <div class="row">
                     <div class="col-12 altura_linha_2"></div>
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
                        <span class="font_verde_g"><?=Utils::data_anuncio($anuncio->data_atualizacao)?></span>
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
                        <a class="btn btn-outline link_a" href="cad_anuncio.php?acao=alteracao&comportamento=exibir_formulario&frm_id_anuncio=<?=$anuncio->id_anuncio?>"><img src="../images/editar.svg">&nbsp;Editar</a>               
                        
                        <a class="btn btn-outline link_a" href="cad_anuncio.php?acao=alteracao&comportamento=exibir_formulario_renovar&frm_id_anuncio=<?=$anuncio->id_anuncio?>"><img src="../images/novo.svg">&nbsp;Renovar</a>               
                        
                        <a class="btn btn-outline link_a" href="cad_anuncio.php?acao=exclusao&comportamento=exibir_formulario_exclusao&frm_id_anuncio=<?=$anuncio->id_anuncio?>"><img src="../images/excluir.svg">&nbsp;Excluir</a>
                        
                     </div>
                  </div>
            
               </div>
            </div>
         <?php
         }      

         // anúncios - Serviços ou Produtos
         $instancia_servico = new Cad_Servico_Hlp();
         $instancia_servico->set_id_usuario( $_SESSION['id_usuario'] );
         $instancia_servico->obter_servicos( $anuncios_servicos );
         $i = 0;
         foreach ( $anuncios_servicos as $servico ) {
            $tem_anuncio = true;         
            if ( $servico->ativo == 'S' ) {
               $ativo     = 'Data de Publicação: ';
               $cor_ativo = 'font_verde_p';
            } else {
               $ativo     = 'Aguardando Publicação';
               $cor_ativo = 'font_vermelha_p';
            }            
            $dados = Utils::obter_array_fotos_servico( $servico->id_servico, $servico->data_cadastro, 'S' );
            $pasta_dc = '../fotos_servico/'.date("d_m_Y", strtotime($servico->data_cadastro)).'/';
            if ( $dados->total_fotos>0 ) { 
               $nome_thumbnail = $pasta_dc.$dados->fotos[0];
            } else {
               $nome_thumbnail = '../images/sem_foto1.png';
            }
            ?>
            <div class="row shadow p-1 mb-1 bg-white rounded">
               <div class="col-12">

                  <div class="row">
                     <div class="col-12 altura_linha_2"></div>
                  </div>  

                   <div class="row">
                     <div class="col-auto">
                        <span class="font_verde_m">Servico ou Produto</span>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-auto">
                        <span class="font_preta_g"><?=$servico->tiposervico?></span>
                     </div>
                  </div>
                  
                   <div class="row">               
                     <div class="col-auto">
                        <span class="font_preta_p"><?=$servico->titulo?></span>
                     </div>
                  </div>              

                  <div class="row">
                     <div class="col-auto">
                        <span class="<?=$cor_ativo?>"><?=$ativo;?></span>
                        <span class="font_verde_g"><?=Utils::data_anuncio($servico->data_atualizacao)?></span>
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
                        <a class="btn btn-outline link_a" href="cad_servico.php?acao=alteracao&comportamento=exibir_formulario&frm_id_servico=<?=$servico->id_servico?>"><img src="../images/editar.svg">&nbsp;Editar</a>                        
                        <a class="btn btn-outline link_a" href="cad_servico.php?acao=alteracao&comportamento=exibir_formulario_renovar&frm_id_servico=<?=$servico->id_servico?>"><img src="../images/novo.svg">&nbsp;Renovar</a>
                        <a class="btn btn-outline link_a" href="cad_servico.php?acao=exclusao&comportamento=exibir_formulario_exclusao&frm_id_servico=<?=$servico->id_servico?>"><img src="../images/excluir.svg">&nbsp;Excluir</a>                        
                     </div>
                  </div>
            
               </div>
            </div>
         <?php
         }      

         if ( !$tem_anuncio ) {?>
            <div class="row">
               <div class="col-12">
                  <span class="font_cinza_m">Você ainda não tem nenhum anúncio cadastrado!</span>
               </div>
            </div>
         <?php    
         } else{ ?>
            <div class="row shadow">
               <div class="col-12">

                  <div class="row margem_1">
                     <div class="col-12">
                        <span class="text"><br><b>Olá: <?=$_SESSION['apelido']?></b></span>
                     </div>
                  </div>

                  <div class="row margem_1">
                     <div class="col-12">
                        <span class="text">1) Para alterar informações ou fotos do seu anúncio: clique acima em <b><ins>Editar</ins></b></span>
                     </div>
                 </div>

                  <div class="row margem_1">
                     <div class="col-12">
                        <span class="text">2) Para Renovar a Data de Publicação do seu anúncio clique acima em <b><ins>Renovar</ins></b></span>
                        <span class="text">, faça isso sempre que quiser que seu anúncio apareça entre os primeiros nas pesquisas do site.</span>
                     </div>
                  </div> 

                  <div class="row margem_1">
                     <div class="col-12">
                        <span class="text">3) Para remover o anúncio clique acima em <b><ins>Excluir</ins></b></span>
                     </div>
                  </div> 
                  

                  <div class="row shadow p-1 mb-1 bg-white rounded" >
                     <div class="col-12 alert alert-danger">
                        <span class="text small">- utilize as opções acima sempre que desejar!<br></span>
                        <span class="text small">- fique a vontade para incluir novos anúncios!</span>
                     </div>
                  </div> 
                  

               </div>
            </div>
         <?php    
         }?>
      
      </form>
   <?php
   } // exibir_listagem

   function exibir_formulario_ok( $do) {     
      ?>
      <div class="row margem_1">
         <div class="col-12">
            <?php
            if ( $do->acao=='inclusao' ) {?>
               <span class="font_verde_g">Olá <?=$_SESSION['apelido']?>,<br></span>
               <span class="font_cinza_m">Seu anúncio foi inserido com sucesso e já foi publicado!</span><br>
               <span class="font_cinza_n"><br>
                  Veja como ficou
                 <a class="link_a" href="../mostrar_detalhes.php?frm_id_anuncio=<?=$do->id_anuncio?>" role="button">seu anúncio.</a>
               </span>
               <span class="font_cinza_n"><br><br>
                    Caso queira alterar informações ou fotos do anúncio
                   <a class="link_a" href="cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">clique aqui.</a>
               </span>
            <?php
            } elseif ( $do->acao=='alteracao' ) {?>
               <span class="font_verde_g">Olá <?=$_SESSION['apelido']?>,<br></span>
               <span class="font_cinza_m">Seu anúncio foi Alterado!</span><br>               
               <span class="font_cinza_n"><br>
                  Veja como ficou
                 <a class="link_a" href="../mostrar_detalhes.php?frm_id_anuncio=<?=$do->id_anuncio?>" role="button">seu anúncio.</a>
               </span>
               <span class="font_cinza_n"><br><br>
                    Alterar informações ou fotos do anúncio
                   <a class="link_a" href="cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">clique aqui.</a>
               </span>
            <?php
            
            } elseif ( $do->acao=='exclusao' ) {?>
               <span class="font_cinza_m">Olá <?=$_SESSION['apelido']?>,<br></span>
               <span class="font_cinza_m">Seu anúncio foi EXCLUÍDO com sucesso.</span>
            <?php
            }
            ?>
            <br>
         </div>          
      </div>           
  
      <div class="row">
         <div class="col-12 altura_linha_1"></div>
         <div class="col-12 altura_linha_2"></div>
      </div> 
      <!-- depois do rodapé -->
      <div class="shadow p-1 mb-1 bg-white rounded">
         <div class="col-12 text-center" style="border-color: #f3f9f0;" >
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-format="fluid"
                 data-ad-layout-key="-fb+5w+4e-db+86"
                 data-ad-client="ca-pub-2582645504069233"
                 data-ad-slot="8484848734"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>    
         
         </div>
      </div>

       <div class="row">
         <div class="col-12 altura_linha_2"><br><br><br></div>
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
            igualar_formulario();
            exibir_listagem();
            break;

         case 'exibir_formulario_renovar':
            igualar_formulario();
            exibir_formulario_renovar();
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
      if ( isset($_REQUEST['frm_id_anuncio']) ) {
         $instancia = new Cad_Anuncio_Hlp();
         $instancia->set_id_anuncio( $_REQUEST['frm_id_anuncio'] );
         $instancia->obter_anuncios( $anuncio );
         if ( count($anuncio)>0 ) {
            $anuncio = $anuncio[0];
         }      
      }

      $_REQUEST['frm_id_anuncio'     ] = !isset($anuncio) ? '' : $anuncio->id_anuncio;
      $_REQUEST['frm_tipo_anuncio'   ] = !isset($anuncio) ? '' : $anuncio->id_tipo_anuncio;
      $_REQUEST['frm_categoria'      ] = !isset($anuncio) ? '' : $anuncio->id_categoria;
      $_REQUEST['frm_raca'           ] = !isset($anuncio) ? '' : $anuncio->id_raca;
      $_REQUEST['frm_titulo'         ] = !isset($anuncio) ? '' : $anuncio->titulo;
      $_REQUEST['frm_descricao'      ] = !isset($anuncio) ? '' : $anuncio->descricao;  
      
      
      $_REQUEST['frm_ddd_celular'    ] = "({$_SESSION['ddd_celular']}) ";
      $_REQUEST['frm_ddd_whatzapp'   ] = "({$_SESSION['ddd_whatzapp']}) ";
      $_REQUEST['frm_ddd_fixo'       ] = "({$_SESSION['ddd_fixo']}) ";
      
      $_REQUEST['frm_tel_celular'    ] = "({$_SESSION['tel_celular']}) ";
      $_REQUEST['frm_tel_whatzapp'   ] = "({$_SESSION['tel_whatzapp']}) ";
      $_REQUEST['frm_tel_fixo'       ] = "({$_SESSION['tel_fixo']}) ";      
      
      if ( $_REQUEST['acao']=='inclusao' ) {
         $_REQUEST['frm_data_cadastro'  ] = Utils::obter_data_hora_atual();      
         $_SESSION['dir_tmp'] = 'tmp_'.date('Ymd').'_'.rand();  
         $_SESSION['acao'   ] = 'inclusao';
         $_REQUEST['frm_ativo'] = 'N';
       
         
         $_REQUEST['frm_id_logradouro'  ] = $_SESSION['id_logradouro'];   
           
      
      } else if ( $_REQUEST['acao']=='alteracao' ) {
         $_REQUEST['frm_data_cadastro'] = $anuncio->data_cadastro;
         $_REQUEST['frm_ativo'        ] = $anuncio->ativo;
         
         $_SESSION['dir_tmp'] = date('Ymd').'_'.$_REQUEST['frm_id_anuncio'];  
         $_SESSION['acao'   ] = 'alteracao';
         
         $fotos = new Fotos();         
         $fotos->prepara_pasta_foto_para_alteracao($anuncio->id_anuncio,$anuncio->data_cadastro);
         $_REQUEST['frm_id_logradouro'  ] = $anuncio->id_logradouro;
         
      } else {
       
      }

   } // igualar_formulario
  
   function efetivar() {
      $anuncio = new Cad_Anuncio_Hlp();
      
      $do      = new StdClass();
      $do->acao = $_REQUEST['acao'];
      
      switch ($_REQUEST['acao']) {
         case 'inclusao':
            igualar_objeto($anuncio);
            $anuncio->incluir();
            
            $do->id_anuncio = $anuncio->get_id_anuncio();
            $do->titulo     = $anuncio->get_titulo(); 
            exibir_formulario_ok( $do );
            break;
         
         case 'alteracao':
            igualar_objeto($anuncio);
            $anuncio->set_id_anuncio( $_REQUEST['frm_id_anuncio'] );      
            $anuncio->alterar();
            
            $id_anuncio = explode( '_', $_REQUEST['frm_id_anuncio'] );
            $do->id_anuncio = $id_anuncio[1];
            $do->titulo     = $anuncio->get_titulo(); 
            exibir_formulario_ok( $do );
            break;
         
         case 'exclusao':
            $anuncio->set_id_anuncio( $_REQUEST['frm_id_anuncio'] );
            $anuncio->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );
            $anuncio->excluir();
            
            $do->id_anuncio = $anuncio->get_id_anuncio();
            $do->titulo     = $anuncio->get_titulo(); 
            $do->ativo      = $anuncio->get_ativo();
            exibir_formulario_ok( $do );
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
      $anuncio->set_id_usuario( $_SESSION['id_usuario'] );
      $anuncio->set_titulo( $_REQUEST['frm_titulo'] );
      $anuncio->set_descricao( $_REQUEST['frm_descricao'] );
      
      $anuncio->set_ativo( $_REQUEST['frm_ativo'] );
      $anuncio->set_id_logradouro( $_REQUEST['frm_id_logradouro'] );
      $anuncio->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );      
      $anuncio->set_data_atualizacao( date('Y-m-d H:i:s') );      
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
   
      <?= Utils::exibir_copyright();?>
   
   </div> <!-- container -->

   <!--  -->
   <script src="../dist/js/load-image/load-image.all.min.js"></script>
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>


    <script src="../dist/js/upload.js"></script>
   
   <!--  
   -->
   
   <script src="../dist/js/cadastro_anuncio.js"></script>
   <script src="../dist/jquery_mask/dist/jquery.mask.min.js"></script>

   <script src="../dist/jquery_file_upload/js/jquery.fileupload.js"></script>
   <script src="../dist/jquery_file_upload/js/jquery.iframe-transport.js"></script>
   <script src="../dist/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>

<script>
   
   
</script>



</body>

</html>