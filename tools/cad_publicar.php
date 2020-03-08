<?php
session_start(); 
include_once '../cadastro/utils.php';
include_once '../cadastro/cad_anuncio_hlp.php';
include_once '../cadastro/cad_usuario_hlp.php';
   
Utils::validar_login_tools();

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <?php Utils::meta_tag() ?>

   <!--  .css -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="../dist/jquery-ui/jquery-ui.min.css" >     
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   <link rel="stylesheet" href="../dist/css/estilo_slick.css" >
   <link rel="stylesheet" href="../dist/fSelect/fSelect.css" >
   <link rel="stylesheet" href="../dist/slick/slick/slick.css"/>
   <link rel="stylesheet" href="../dist/slick/slick/slick-theme.css"/>  

</head>

<body>

<div class="container">
   <?php 
    include_once 'tools_cabecalho.php';
 
   verificar_acao();

      
   function exibir_listagem() {      

      $instancia = new Cad_Anuncio_Hlp();
      $instancia->set_ativo( 'N' );
      $instancia->obter_anuncios( $anuncios );
      ?>

      <form id="frmCadPublicar" class="form-horizontal" action="cad_publicar.php" method="POST" role="form">
         <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">
         <input type="hidden" id="acao" name="acao" value = "<?=$_REQUEST['acao']?>">

         <div class="row">
            <div class="col-auto">
                <a class="link_a" href="cad_publicar.php?acao=alteracao&comportamento=exibir_listagem" role="button">Publicar Anúncio</a>
            </div>
            <div class="col-auto">
                <a class="link_a" href="cad_publicar_servico.php?acao=alteracao&comportamento=exibir_listagem" role="button">Publicar Serviço</a>
            </div>
         </div>  
         
         <div class="row">
            <div class="col-md-12">                     
               <hr class="hr1">
            </div>
         </div>  

         <div class="row fundo_branco_1">
            <div class="col-6">
               <span class="destaque_2">Publicar Anúncio</span><br>
                <span class="font_cinza_g">Publicar:</span>
                <span class="font_preta_g"><?=count($anuncios)?> anúncio(s)</span>                
            </div>
            <div class="col-6 text-right">            
               <a class="btn btn-outline-success btn_link" href="tools.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
            </div>
         </div>
       
         <div class="row fundo_branco_1">
             <div class="col-12 altura_linha_1 fundo_branco_1"></div>
         </div>          
         <?php
      
         montar_js($anuncios);
   
         $i = 0;
         foreach ( $anuncios as $anuncio ) {
            if ( $anuncio->ativo == 'S' ) {
               $ativo     = 'Publicado';
               $cor_ativo = 'font_verde_p';
            } else {
               $ativo     = 'Aguardando Publicação';
               $cor_ativo = 'font_vermelha_p';
            }
            
            $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro );
            
            $pasta_dc = '../fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
            $id_anuncio = $anuncio->id_anuncio;

            $usuario = new Cad_Usuario_Hlp();
            $usuario->set_id_usuario($anuncio->id_usuario);
            $usuario->obter_dados_usuario( $usuario );

            ?>

            <div class="row">
               <div class="col-md-12">                     
                  <hr class="hr1">
               </div>
            </div>  

             
            <div class="row">
               <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" >
                  <div class="anuncio_<?=$id_anuncio?> slide" id="div_anuncio_<?=$id_anuncio?>" style="display:none">
                     <?php         
                     foreach ( $dados->fotos as $imagem ) { 
                        $caminho = $pasta_dc.$imagem;?>
                        <div>
                           <img src="<?=$caminho?>" >
                        </div>
                     <?php
                     }
                     ?>
                     <div>
                        <img href='../images/sem_foto.png'>                                                      
                     </div>
                  </div>                     
               </div>   

                <div class="row">            
                  <div class="col-12 altura_linha_1">
                     &nbsp;
                  </div>
               </div>

               <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" >
                  <span class="font_cinza_p"><?= Utils::data_anuncio($anuncio->data_atualizacao)?></span><br>
                  <span class="font_preta_p">-----------------------------------</span><br>
                  <span class="font_preta_p"><?=$usuario->apelido?></span><br>
                  <span class="font_preta_p"><?=$usuario->email?></span><br>
                  <span class="font_preta_p"><?=$usuario->ddd.' '.$usuario->telefone?></span><br>
                  <span class="font_preta_p"><?=$usuario->endereco?></span><br>
                  <span class="font_preta_p">-----------------------------------</span><br>                  
                  <span class="font_verde_g"><?=$anuncio->tipo_anuncio.' - '.$anuncio->categoria.' - '.$anuncio->raca?></span><br>
                  <span class="font_preta_p"><?=$anuncio->titulo?></span><br>
                  <span class="font_cinza_p"><?=$anuncio->descricao?></span><br>
                  <span class="font_preta_p"><?=$anuncio->ddd.' '.$anuncio->telefone?></span><br>
                  <span class="font_preta_p"><?=$anuncio->endereco?></span><br>
                  <br>
                  <input type="checkbox" id="<?='chk_'.$anuncio->id_anuncio?>" name="<?='chk_'.$anuncio->id_anuncio?>" >&nbsp;<span class="font_azul_m">Tudo OK</span>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="submit" name="btnSalvarAnuncio" class="btn btn_detalhes" value="Publicar">
                  <br><br>
               
               </div>  

               <div class="col-12">
               </div>
                               
            </div>


         <?php
         }?>
      </form>
   <?php 
   } // exibir_listagem


function montar_js($anuncios) {
   echo "<script type='text/javascript'> \n";
      echo "window.onload = function(){ \n";   
         
         foreach ( $anuncios as $anuncio ) {
            $id_anuncio = $anuncio->id_anuncio;
            echo "$('.anuncio_".$id_anuncio."').slick({
                     infinite: true,
                     speed: 500,
                     adaptiveHeight: true,    
                     fade: true,               
                  });\n";

            //.. exibe as imagens
            $id_anuncio = $anuncio->id_anuncio;
            echo "$('#div_anuncio_".$id_anuncio."').show();\n";
         }
         
      echo "}";
    
   echo "</script>";
} // montar_js


   function verificar_acao() {
      $comportamento = $_REQUEST['comportamento'];

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
   
   function exibir_formulario_ok() {?>
      <div class="row">
         <div class="col-12">                     
            <br><br>
            <a href="index.php">Voltar</a>
         </div>
      </div>    
   <?php
   } // exibir_formulario_ok
  
   function efetivar() {
      $anuncio = new Cad_Anuncio_Hlp();

      switch ($_REQUEST['acao']) {
         case 'inclusao':
            break;
         
         case 'alteracao':
            igualar_objeto($anuncio);
            $anuncio->publicar();
            exibir_formulario_ok();
            break;
         
         case 'exclusao':
            break;
         
         default:
            # code...
            break;            
      }
      ?>

            
   <?php
   } // efetivar
   
   function igualar_objeto( &$anuncio ) {
      foreach( $_REQUEST as $campo => $valor ) {
         if (substr($campo,0,4)=='chk_') {
            $anuncio->adicionar_array_publicar( $campo );         
         }
      }
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
            <span class="font_cinza_p">Copyright © 2018 www.oviralata.com.br Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>         
   
   </div> <!-- container -->

   <!--  -->
   <script src="../dist/js/load-image/load-image.all.min.js"></script>
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>

    <script src="../dist/slick/slick/slick.min.js"></script>
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
