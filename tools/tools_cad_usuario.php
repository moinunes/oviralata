<?php
session_start();

ini_set('display_errors', true); 
error_reporting(E_ALL);

include_once '../cadastro/utils.php';
include_once 'tools_cad_usuario_hlp.php';
   
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
      $id_usuario = $_REQUEST['frm_id_usuario'];

      $instancia = new Tools_Cad_Usuario_Hlp();
      $instancia->id_usuario = $_REQUEST['frm_id_usuario'];
      $instancia->obter_dados_usuario( $usuario );
      $usuario = $usuario[0];
        
      ?>
      <form id="frmCadUsuario" name="frmCadUsuario" class="form-horizontal" action="tools_cad_usuario.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return validar_submit();">

         <div id='div_buscar'></div>         

         <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
         <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_usuario"    name="frm_id_usuario"    value = "<?=$_REQUEST['frm_id_usuario']?>">     
         <input type="hidden" id="frm_data_cadastro" name="frm_data_cadastro" value = "<?=$_REQUEST['frm_data_cadastro']?>">     
         <input type="hidden" id="frm_nome_completo" name="frm_nome_completo" value = "<?=$usuario->nome_completo?>">   

         <?php
         $acao    = $_REQUEST['acao'];


         $id_usuario = isset($_REQUEST['frm_id_usuario']) ? trim($_REQUEST['frm_id_usuario']) : '';
         $ativo      = isset($_REQUEST['frm_ativo'])      ? trim($_REQUEST['frm_ativo'])      : '';
         $bloqueado  = isset($_REQUEST['frm_bloqueado'])  ? trim($_REQUEST['frm_bloqueado'])  : '';

         ?>
         <input type="hidden" id="frm_id_usuario"  name="frm_id_usuario" value ="<?=$id_usuario?>" >
         
      
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row fundo_branco_1">
            <div class="col-12">
               <span class="font_vermelha_m"><<< Usuário >>></span>
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
                  print "id_usuario......: {$id_usuario}<br>";
                  print "apelido.........: {$usuario->apelido}<br>";
                  print "nome completo...: {$usuario->nome_completo}<br>";                  
                  print "sexo............: {$usuario->sexo}<br>";
                  print "Celular.........: {$usuario->ddd_celular} {$usuario->tel_celular}<br>";
                  print "WhatzApp........: {$usuario->ddd_whatzapp} {$usuario->tel_whatzapp}<br>";
                  print "Fixo............: {$usuario->ddd_fixo} {$usuario->tel_fixo}<br>";
                  print "id_facebook.....: {$usuario->id_facebook}<br>";
                  print "data_cadastro...: ".Utils::data_anuncio($usuario->data_cadastro).'<br>';
                  print "<span class='font_azul_p'>{$usuario->email}</span><br>";
                  print "<span class='font_azul_p'>{$usuario->endereco}</span><br>";
                  
                  ?>
               </span>
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">

            <div class="col-2">
               <label for="frm_ativo">Ativo</label>
               <input type="text" class="form-control form-control-sm" id="frm_ativo" name="frm_ativo" value="<?=$ativo?>" maxlength="70"  />
            </div>
            <div class="col-2">
               <label for="frm_bloqueado">Bloqueado</label>
               <input type="text" class="form-control form-control-sm" id="frm_bloqueado" name="frm_bloqueado" value="<?=$bloqueado?>" maxlength="70"  />
            </div>
            
         </div>   

          <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>
         
         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         
         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         
         <div class="row">
            <div class="col text-right">
               <input type="submit" name="btnSalvarAnuncio" class="btn btn_inserir_anuncio" value="Salvar">
            </div>
         </div>

      </form>
   <?php
   } // exibir_formulario   

    function exibir_listagem() {?>
      <form id="formulario" name="formulario" class="form-horizontal" action="tools_cad_usuario.php" method="POST" enctype="multipart/form-data" role="form">

         <?php
         $nome_completo = isset($_REQUEST['frm_nome_completo']) ? trim($_REQUEST['frm_nome_completo']) : '';
         $apelido       = isset($_REQUEST['frm_apelido'])       ? trim($_REQUEST['frm_apelido'])       : '';
         $email         = isset($_REQUEST['frm_email'])         ? trim($_REQUEST['frm_email'])         : '';
         $ativo         = isset($_REQUEST['frm_ativo'])         ? trim($_REQUEST['frm_ativo'])         : '';
         $order         = isset($_REQUEST['frm_order'])         ? trim($_REQUEST['frm_order'])         : 'data_cadastro';
         $exibir        = isset($_REQUEST['frm_exibir'])        ? trim($_REQUEST['frm_exibir'])        : '';
         $tipo_cadastro = isset($_REQUEST['frm_tipo_cadastro']) ? trim($_REQUEST['frm_tipo_cadastro']) : '';
         
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

         <div class="row">
            <div class="col-md-12">
                <span class="font_vermelha_m"><<< Manutenção - Usuário >>></span>
            </div>
         </div>
         
         <div class="row">

            <div class="col-auto">
               <label for="frm_exibir">Exibir</label>
               <select id='frm_exibir' name='frm_exibir' class="form-control form-control-sm" onchange="submeter_form()"  >
                  <option value=""  <?=$exibir==''  ? 'selected' : '';?> >Todos</option>
                  <option value="C" <?=$exibir=='C' ? 'selected' : '';?> >Cadastro Completo</option>
                  <option value="I" <?=$exibir=='I' ? 'selected' : '';?> >Cadastro Incomplento</option>      
               </select>
            </div>

            <div class="col-auto">
               <label for="frm_tipo_cadastro">Cadastrou com</label>
               <select id='frm_tipo_cadastro' name='frm_tipo_cadastro' class="form-control form-control-sm" onchange="submeter_form()"  >
                  <option value=""  <?=$tipo_cadastro==''  ? 'selected' : '';?> >Todos</option>
                  <option value="F" <?=$tipo_cadastro=='F' ? 'selected' : '';?> >FaceBook</option>
                  <option value="E" <?=$tipo_cadastro=='E' ? 'selected' : '';?> >Email e Senha</option>      
               </select>
            </div>

            <div class="col-auto">
               <label for="frm_ativo">Ativo</label>
               <select id='frm_ativo' name='frm_ativo' class="form-control form-control-sm" onchange="submeter_form()"  >
                  <option value=""  <?=$ativo==''  ? 'selected' : '';?> ></option>
                  <option value="S" <?=$ativo=='S' ? 'selected' : '';?> >Ativo</option>
                  <option value="N" <?=$ativo=='N' ? 'selected' : '';?> >Inativo</option>      
               </select>
            </div>
         
            <div class="col-auto">
               <label for="frm_nome_completo">Nome Completo</label>
               <input type="text" class="form-control form-control-sm" id="frm_nome_completo" name="frm_nome_completo" value="<?=$nome_completo?>" maxlength="70"  />
            </div>  
         
            <div class="col-auto">
               <label for="frm_apelido">Apelido</label>
               <input type="text" class="form-control form-control-sm" id="frm_apelido" name="frm_apelido" value="<?=$apelido?>" maxlength="70"  />
            </div>  
         
            <div class="col-auto">
               <label for="frm_email">E-mail</label>
               <input type="text" class="form-control form-control-sm" id="frm_email" name="frm_email" value="<?=$email?>" maxlength="70"  />
            </div>  

            <div class="col-auto">
               <label for="frm_order">Ordenar por</label>
               <select id='frm_order' name='frm_order' class="form-control form-control-sm" onchange="submeter_form()"  >
                  <option value="data_cadastro" <?=$order=='data_cadastro' ? 'selected' : '';?> >Data Cadastro</option>
                  <option value="ativo"         <?=$order=='ativo'         ? 'selected' : '';?> >Ativo</option>
                  <option value="bloqueado"     <?=$order=='bloqueado'     ? 'selected' : '';?> >Bloqueado</option>
                  <option value="apelido"       <?=$order=='apelido'       ? 'selected' : '';?> >Apelido</option>
                  <option value="id_facebook"   <?=$order=='id_facebook'   ? 'selected' : '';?> >Facebook</option>     
               </select>
            </div>
         
         </div>  

         <div class="row">         
            <div class="col-2">
               <br>               
               <input type="submit" id="btnFiltrar" name="btnFiltrar" class="btn btn-success btn_salvar" value="Filtrar">
            </div>
         </div>

         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_1 fundo_branco_1"></div>
         </div>
         
         <?php
         $instancia = new Tools_Cad_Usuario_Hlp();
         $instancia->nome_completo = $nome_completo;
         $instancia->apelido       = $apelido;
         $instancia->email         = $email;
         $instancia->ativo         = $ativo;
         $instancia->order         = $order;
         $instancia->exibir        = $exibir;
         $instancia->tipo_cadastro = $tipo_cadastro;

         $instancia->obter_dados_usuario( $dados );
         $total_registros = count($dados);
         ?>
            
         <div class="row">
            <div class="col-md-12">                     
               <span class='font_cinza_p'>Total de usuários: <?=$total_registros?></span>
            </div>
         </div> 

         <?php
         $i = 0;
         foreach ( $dados as $item ) {
            $usuario = new Cad_Usuario_Hlp();
            $usuario->set_id_usuario( $item->id_usuario );
            $usuario->obter_dados_usuario( $usuario );

            if ( $item->ativo == 'S' ) {
               $ativo     = 'Ativo';
               $cor_ativo = 'font_verde_p';
            } else {
               $ativo     = 'Inativo';
               $cor_ativo = 'font_vermelha_p';
            }
            
            $facebook = $item->id_facebook != '' ? 'facebook' : 'email-senha';
            $cor_face = $item->id_facebook != '' ? 'font_vermelha_p' : 'font_azul_p';
            $bloqueado= $item->bloqueado   != '' ? 'bloqueado' : '';

            $cep = $item->cep != '' ? $item->cep : 'inclompleto';
            $cor_cep = $item->cep != '' ? 'font_azul_p' : 'font_vermelha_p';


            ?>

            <div class="row">
               <div class="col-md-12">                     
                  <hr class="hr1">
               </div>
            </div>  

            <div class="row fundo_cinza_2">
               <div class="col-2 text-left">   
                  <a class="btn btn-outline link_a" href="tools_cad_usuario.php?acao=alteracao&comportamento=exibir_formulario&frm_id_usuario=<?=$item->id_usuario?>"><img src="../images/editar.svg">&nbsp;Editar</a>               
               </div>
               <div class="col-3 text-right">
                  <span class="<?=$cor_ativo?>"><?=$ativo;?></span>
               </div>               
               <div class="col-4 text-right">
                  <span class="<?=$cor_face?>"><?=$facebook;?></span>
               </div>                   
               <div class="col-3">
                  <span class="font_preta_p"><?=Utils::data_anuncio($item->data_cadastro)?></span>
               </div>
            </div>
            <div class="row fundo_cinza_2">  
               <div class="col-auto">
                  <span class="<?=$cor_cep?>"><?="{$cep}"?></span>
               </div>               
               <div class="col-auto">
                  <span class="font_cinza_p"><?=$item->email;?></span>
               </div>
               <div class="col-auto">
                  <span class="font_cinza_p"><?=$item->apelido;?></span>
               </div>
               <div class="col-auto">
                  <span class="font_vermelha_m"><?=$bloqueado;?></span>
               </div>
               <div class="col-auto text-right">
                  <span class='font_preta_p'><?=$usuario->endereco?></span><br>
               </div>
            </div>

         <?php
         }
         ?>   

      </form>
   <?php
   } // exibir_listagem

   function exibir_formulario_ok( $acao, $nome) {
      include_once 'tools_cabecalho.php';
      ?>    
      <div class="row">

         <div class="col-12">
            <br>
            <?php
            if ( $acao=='alteracao' ) {?>
               <span class="font_cinza_p">O Usuário:</span>
               <span class="font_azul_p"><?=$nome?><br></span>
               <span class="font_cinza_p">Foi Alterado com sucesso.</span><br>
            <?php
            
            }
            ?>
            <br>               
         </div>            
      </div>    

      <div class="row fundo_branco_1">
         <div class="col-12">
            <a class="link_a" href="tools_cad_usuario.php?acao=exibir&comportamento=exibir_listagem" role="button">Voltar</a>
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
      $usuario = new Tools_Cad_Usuario_Hlp();
      $usuario->id_usuario = $_REQUEST['frm_id_usuario'];
      $usuario->obter_dados_usuario( $dados );
      $dados = $dados[0];

      $_SESSION['acao'] = 'alteracao';         

      $_REQUEST['frm_id_usuario'    ] = $dados->id_usuario;
      $_REQUEST['frm_ativo'         ] = $dados->ativo;
      $_REQUEST['frm_data_cadastro' ] = $dados->data_cadastro;
      $_REQUEST['frm_bloqueado'     ] = $dados->bloqueado;      
      $_REQUEST['frm_ativo'         ] = $dados->ativo;
      
   } // igualar_formulario
  
   function efetivar() {
      $usuario = new Tools_Cad_Usuario_Hlp();
      
      switch ($_REQUEST['acao']) {
         
         case 'alteracao':
            igualar_objeto($usuario);
            $usuario->id_usuario = $_REQUEST['frm_id_usuario'];      
            $usuario->alterar();
            exibir_formulario_ok( $_REQUEST['acao'], $_REQUEST['frm_nome_completo'] );
            break;
         
         default:
            # code...
            break;            
      }
       
   } // efetivar
   
   
   function igualar_objeto( &$usuario ) {    
      $usuario->id_usuario = $_REQUEST['frm_id_usuario'];
      $usuario->ativo      = $_REQUEST['frm_ativo'];
      $usuario->bloqueado  = $_REQUEST['frm_bloqueado'];  
       
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
            <span class="font_cinza_p">Copyright © 2018 www.adotabrasil.com.br<br>Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>         
   
   </div> <!-- container -->

   <!--  -->
   <script src="../dist/js/load-image/load-image.all.min.js"></script>
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>

   <!--  
   -->
   
   <script src="../dist/jquery_mask/dist/jquery.mask.min.js"></script>

   <script src="../dist/jquery_file_upload/js/jquery.fileupload.js"></script>
   <script src="../dist/jquery_file_upload/js/jquery.iframe-transport.js"></script>
   <script src="../dist/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>

   
   <script type="text/javascript">
   
       function submeter_form( pagina = '1') {
         $('#comportamento').val( 'exibir_listagem' );
         $('#acao').val( 'alteracao' );
         document.forms['formulario'].submit();
      }
   
   </script>



</body>

</html>