<?php
session_start();

include_once 'utils.php';
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
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body class="fundo_cinza_1">

<div class="container">
   <?php
   include_once 'cad_cabecalho_1.php';
 
   verificar_acao();

   function exibir_formulario() { 
      $acao = $_REQUEST['acao'];

      $instancia = new Cad_Servico_Hlp();
      $instancia->obter_tipo_servico($tipos);
      $id_tipo_servico = $_REQUEST['frm_tipo_servico'];

      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($_SESSION['id_usuario']);
      $usuario->obter_dados_usuario( $usuario );
      ?>

      

      <?php
      if ( $acao=='inclusao' ) {
              
         $texto_1 = 'Preencha os campos abaixo:';  
      } else if ($acao=='alteracao') {
         $texto_1 = 'Aqui você pode editar as informações e fotos do seu anúncio!';
      }    
         
      ?>
      <form id="frmCadAnuncio" name="frmCadAnuncio" class="form-horizontal" action="cad_servico.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return validar_submit();">

         <div id='div_buscar'></div>         

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_logradouro" name="frm_id_logradouro" value = "<?=$_REQUEST['frm_id_logradouro']?>">         
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">
         <input type="hidden" id="frm_ativo"         name="frm_ativo"         value = "<?=$_REQUEST['frm_ativo']?>">     
         <input type="hidden" id="frm_origem"        name="frm_origem"        value ="servico" >
         <?php
         $dir_tmp = $_SESSION['dir_tmp'];

         if ( trim($usuario->id_logradouro)=='' ) {?>
           <div class="row">
              <div class="col-12 altura_linha_2"></div>
           </div>
            <div class="row">
                <div class="col-12 border border-sucess rounded fundo_laranja_1">
                     <br>
                     <a class="link_a" href="cad_usuario.php?acao=alteracao&comportamento=exibir_formulario_alteracao">Olá,<br>Por favor [Clique Aqui] e termine de preencher seu Cadastro!</a>
                     <br><br>
                </div>
            </div>
            <?php
            die();
         }

         if ( $acao=='inclusao' ) {
            $titulo='<<< Inserir Anúncio >>>';
            ?>
            <input type="hidden" id="frm_id_servico"  name="frm_id_servico" value ="<?=$dir_tmp?>" >
         <?php
         } else if ( $acao=='alteracao' ) {    
            $titulo='<<< Editar Anúncio >>>';
            ?>
            <input type="hidden" id="frm_id_servico"  name="frm_id_servico" value ="<?=$dir_tmp?>" >
         <?php
         }
         ?>
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row fundo_branco_1">
            <div class="col-12">
                <span class="font_verde_g"><?=$titulo?></span>
            </div>
            <div class="col-12">
               <span class="font_verde_g">Serviços ou Produtos PET</span>
            </div>
      </div>

         <div class="row">
            <div class="col-md-12">                     
               <hr class="hr1">
            </div>
         </div>  
         <div class="row fundo_branco_1">
            <div class="col-md-12">
               <span class="font_cinza_m"><?=$texto_1?></span>
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_tipo_servico">Tipo*</label>
               <select id='frm_tipo_servico' name='frm_tipo_servico' class="form-control form-control-sm" >
                  <option value=""></option>
                  <?php
                  foreach ( $tipos as $item ) {?>
                     <option value="<?=$item->id_tipo_servico?>" <?= $id_tipo_servico==$item->id_tipo_servico ? "selected" : '';?> ><?=$item->tiposervico?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>
               
            <div class="col-md-4">
               <label for="frm_titulo">Título*</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" value="<?=$_REQUEST['frm_titulo']?>" maxlength="80"  />
            </div>
            
         </div>   

          <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         <div class="row">    
            <div class="col-md-12">
               <label for="frm_descricao">Descrição*</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="5" placeholder="inclua uma breve descrição para o seu anúncio..." ><?=$_REQUEST['frm_descricao']?></textarea>
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

         <div class="row border border-sucess rounded fundo_verde_claro">
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
               <input type="submit" name="btnSalvarServico" class="btn btn_inserir_anuncio" value="Enviar anúncio">
            </div>
         </div>

      </form>
   <?php
   } // exibir_formulario   

   function exibir_formulario_exclusao() {
      
      $instancia = new Cad_Servico_Hlp();
      $instancia->set_id_servico($_REQUEST['frm_id_servico']);
      $instancia->obter_servicos($dados);
      $anuncio = $dados[0];

      $instancia = new Cad_Servico_Hlp();
      $instancia->obter_tipo_servico( $tipo_servico, $anuncio->id_tipo_servico );
      $tiposervico = $tipo_servico[0]->tiposervico;
      ?>

      <form id="frmCadServicoExclusao" name="frmCadServicoExclusao" class="form-horizontal" action="cad_servico.php" method="POST" enctype="multipart/form-data" role="form">

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_servico"    name="frm_id_servico"    value = "<?=$_REQUEST['frm_id_servico']?>">
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">
         
         <div class="row">
            <div class="col-12 text-center">
                <span class="font_verde_g"><<< Excluir meu Anúncio >>></span>
            </div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_tipo_servico">Tipo</label>
               <input type="text" class="form-control form-control-sm" id="frm_tipo_servico" name="frm_tipo_servico" value="<?=$tiposervico?>" readonly  />
            </div>    

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
               <a class="link_a" href="cad_servico.php?acao=exibir&comportamento=exibir_listagem" role="button">Cancelar</a>
            </div>
            <div class="col-7">
               <input type="submit" name="btnSalvarServico" class="btn btn_inserir_anuncio" value="Confirmar Exclusão">
            </div>
         </div>

      </form>
   <?php
   } // exibir_formulario_exclusao

   function exibir_formulario_renovar() {
      
      $instancia = new Cad_Servico_Hlp();
      $instancia->set_id_servico($_REQUEST['frm_id_servico']);
      $instancia->renovar_anuncio();

      $anuncio = new Cad_Servico_Hlp();
      $anuncio->obter_dados_do_anuncio( $dados, $_REQUEST['frm_id_servico'] );
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
                Quero visualizar<a href='../servico.php'> meu Anúncio!</a><br><br>
            </span>
         </div>
      </div>

      <!-- desktop -->
      <div class="row text-center d-none d-lg-block">
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 tit_0">Publicidade</div>
      </div>
      <!-- anuncio_texto_1 -->
      <div class="row text-center d-none d-lg-block shadow p-1 mb-3 bg-white rounded">
         <div class="col-12 text-center"  style="border-color: #f3f9f0;" > 
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-format="fluid"
                 data-ad-layout-key="-fb+5w+4e-db+86"
                 data-ad-client="ca-pub-2582645504069233"
                 data-ad-slot="1718106319"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
         </div>
      </div>

      <!-- mobile -->
      <div class="row text-center d-lg-none">
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
      </div>
      <!-- anuncio_texto_1 -->
      <div class="row text-center d-lg-none shadow p-1 mb-3 bg-white rounded">
         <div class="col-12 text-center"  style="border-color: #f3f9f0;" > 
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-format="fluid"
                 data-ad-layout-key="-fb+5w+4e-db+86"
                 data-ad-client="ca-pub-2582645504069233"
                 data-ad-slot="1718106319"></ins>
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
         
         <div class="row fundo_verde_claro">
            <div class="col-12">
               <span class="font_preta_m">Publicar anúncios: SERVIÇOS PET</span>
            </div>
         </div>

         <?php
         include_once 'cad_cabecalho_servico.php';?>      
         
         <div class="row">
            <div class="col-md-12">                     
               <hr class="hr1">
            </div>
         </div>  

         <div class="row fundo_branco_1">
            <div class="col-md-12">
                <span class="font_verde_g"><<< Meus Anúncios >>></span>
            </div>
         </div>
         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_1 fundo_branco_1"></div>
         </div>
         <?php
            $instancia = new Cad_Servico_Hlp();
            $instancia->set_id_usuario( $_SESSION['id_usuario'] );
            $instancia->obter_servicos( $anuncios );
            
            $i = 0;
            foreach ( $anuncios as $anuncio ) {
               
               if ( $anuncio->ativo == 'S' ) {
                  $ativo     = 'Publicado';
                  $cor_ativo = 'font_verde_p';
               } else {
                  $ativo     = 'Aguardando Publicação';
                  $cor_ativo = 'font_vermelha_p';
               }
               
               $dados = Utils::obter_array_fotos_servico( $anuncio->id_servico, $anuncio->data_cadastro, 'S' );
               
               $pasta_dc = '../fotos_servico/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
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
                     <span class="font_preta_g"><?=$anuncio->tiposervico?></span>
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
                     <a class="btn btn-outline link_a" href="cad_servico.php?acao=alteracao&comportamento=exibir_formulario&frm_id_servico=<?=$anuncio->id_servico?>"><img src="../images/editar.svg">&nbsp;Editar</a>               
                     <a class="btn btn-outline link_a" href="cad_servico.php?acao=exclusao&comportamento=exibir_formulario_exclusao&frm_id_servico=<?=$anuncio->id_servico?>"><img src="../images/excluir.svg">&nbsp;Excluir</a>
                     <br>
                     <span class="font_cinza_p"><?=Utils::data_anuncio($anuncio->data_atualizacao)?></span>
                  </div>
               </div>
            <?php
            }
         ?>

         <div class="row">
            <div class="col-13">
               <br>
            </div>
         </div> 
         <div class="row fundo_laranja_1">
            <div class="col-13">
               <span class="font_cinza_m">obs: Sempre que quiser atualizar a [data do anúncio] ou outra informação é só Editar</span>
            </div>
         </div>       

      </form>
   <?php
   } // exibir_listagem

   function exibir_formulario_ok( $do ) {
      ?> 
      <div class="row margem_1">

         <div class="col-12">
            <?php     
            if ( $do->acao=='inclusao' ) {?>
               <span class="font_verde_g">Olá <?=$_SESSION['apelido']?>,<br></span>
               <span class="font_cinza_m">Seu anúncio foi inserido com sucesso e já foi publicado!</span><br>
               <span class="font_cinza_n"><br>
                  Veja como ficou
                 <a class="link_a" href="../mostrar_detalhes_servico.php?frm_id_servico=<?=$do->id_servico?>" role="button">seu anúncio.</a>
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
                 <a class="link_a" href="../mostrar_detalhes_servico.php?frm_id_servico=<?=$do->id_servico?>" role="button">seu anúncio.</a>
               </span>
               <span class="font_cinza_n"><br><br>
                    Alterar informações ou fotos do anúncio
                   <a class="link_a" href="cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">clique aqui.</a>
               </span>
            <?php
            
            } elseif ( $do->acao=='exclusao' ) {?>
               <span class="font_cinza_m">Olá <?=$_SESSION['apelido']?><br></span>
               <span class="font_cinza_m">Seu anúncio:</span>
               <span class="font_azul_m"><?=$do->titulo?></span>
               <span class="font_cinza_m">foi EXCLUÍDO com sucesso.</span><br>
            <?php
            }
            ?>
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
      if ( isset($_REQUEST['frm_id_servico']) ) {
         $instancia = new Cad_Servico_Hlp();
         $instancia->set_id_servico( $_REQUEST['frm_id_servico'] );
         $instancia->obter_servicos( $anuncio );
         if ( count($anuncio)>0 ) {
            $anuncio = $anuncio[0];
         }      
      }

      $_REQUEST['frm_id_servico'     ] = !isset($anuncio) ? '' : $anuncio->id_servico;
      $_REQUEST['frm_tipo_servico'   ] = !isset($anuncio) ? '' : $anuncio->id_tipo_servico;
      $_REQUEST['frm_titulo'         ] = !isset($anuncio) ? '' : $anuncio->titulo;
      $_REQUEST['frm_descricao'      ] = !isset($anuncio) ? '' : $anuncio->descricao;   
      $_REQUEST['ddd_celular'        ] = !isset($anuncio) ? '' : $anuncio->ddd_celular;
      $_REQUEST['tel_celular'        ] = !isset($anuncio) ? '' : $anuncio->tel_celular;
      
      
      if ( $_REQUEST['acao']=='inclusao' ) {
         $_REQUEST['frm_data_cadastro'  ] = Utils::obter_data_hora_atual();      
         $_SESSION['dir_tmp'] = 'tmp_'.date('Ymd').'_'.rand();  
         $_SESSION['acao'   ] = 'inclusao';
         $_REQUEST['frm_ativo'] = 'N';
         $_REQUEST['frm_endereco'       ] = $_SESSION['endereco'];
         
         $_REQUEST['frm_id_logradouro'  ] = $_SESSION['id_logradouro'];   
           
      } else if ( $_REQUEST['acao']=='alteracao' ) {
         $_REQUEST['frm_data_cadastro'] = $anuncio->data_cadastro;      
         $_SESSION['dir_tmp'] = date('Ymd').'_'.$_REQUEST['frm_id_servico'];  
         $_SESSION['acao'   ] = 'alteracao';
         $_REQUEST['frm_ativo'] = $anuncio->ativo;

         $fotos = new Fotos_Servico();         
         $fotos->prepara_pasta_foto_para_alteracao($anuncio->id_servico,$anuncio->data_cadastro);
         $_REQUEST['frm_endereco'       ] = $anuncio->endereco;
         
         
      } else {
       
      }

   } // igualar_formulario
  
   function efetivar() {
      $anuncio = new Cad_Servico_Hlp();

      $do       = new StdClass();
      $do->acao = $_REQUEST['acao'];

      switch ($_REQUEST['acao']) {
         case 'inclusao':
            igualar_objeto($anuncio);
            $anuncio->incluir();
            $do->id_servico = $anuncio->get_id_servico();
            $do->titulo     = $anuncio->get_titulo(); 
            exibir_formulario_ok( $do );
            break;
         
         case 'alteracao':
            igualar_objeto($anuncio);
            $anuncio->set_id_servico( $_REQUEST['frm_id_servico'] );      
            $anuncio->alterar();

            $id_servico = explode( '_', $_REQUEST['frm_id_servico'] );
            $do->id_servico = $id_servico[1];
            $do->titulo     = $anuncio->get_titulo(); 
            exibir_formulario_ok( $do );
            break;
         
         case 'exclusao':
            $anuncio->set_id_servico( $_REQUEST['frm_id_servico'] );
            $anuncio->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );
            $anuncio->excluir();
            $do->id_servico = $anuncio->get_id_servico();
            $do->titulo     = $_REQUEST['frm_titulo'];
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
      $anuncio->set_id_tipo_servico( $_REQUEST['frm_tipo_servico'] );
      $anuncio->set_id_usuario( $_SESSION['id_usuario'] );
      $anuncio->set_titulo( $_REQUEST['frm_titulo'] );
      $anuncio->set_descricao( $_REQUEST['frm_descricao'] );
      $anuncio->set_ativo( $_REQUEST['frm_ativo'] );
      $anuncio->set_id_logradouro( $_REQUEST['frm_id_logradouro'] );
      $anuncio->set_data_cadastro( $_REQUEST['frm_data_cadastro'] );
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
            <span class="font_cinza_p">Copyright © 2018 www.oviralata.com.br<br></span>
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


    <script src="../dist/js/upload_servico.js"></script>
   
   <!--  
   -->
   
   <script src="../dist/js/cadastro_anuncio_servico.js"></script>
   <script src="../dist/jquery_mask/dist/jquery.mask.min.js"></script>

   <script src="../dist/jquery_file_upload/js/jquery.fileupload.js"></script>
   <script src="../dist/jquery_file_upload/js/jquery.iframe-transport.js"></script>
   <script src="../dist/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>

<script>
   
   
</script>



</body>

</html>