<?php
session_start(); 
if ( !isset($_SESSION['login']) ) {
   session_destroy();
   header("Location:login.php");
}

include_once 'cad_anuncio_hlp.php';
include_once 'utils.php';

$titulo = $_REQUEST['titulo'];

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
   
      <?php 
      include_once 'cad_cabecalho_1.php';
      include_once 'cad_cabecalho_2.php';
      
       ?>

      
   <div class="container">
      <div class="row">
         <div class="col-12">
            <br>
            <?php
            if ( $_REQUEST['acao']=='inclusao' ) {?>
               <span class="font_cinza_p">Seu anúncio:</span>
               <span class="font_azul_p"><?=$titulo?>x</span>
               <span class="font_cinza_p">foi inserido com sucesso.</span><br>
               <span class="font_cinza_p">A publicação do seu anúncio será efetuada em breve.</span>
            <?php
            } elseif ( $_REQUEST['acao']=='alteracao' ) {?>
               <span class="font_cinza_p">Seu anúncio:</span>
               <span class="font_azul_p"><?=$titulo?>x</span>
               <span class="font_cinza_p">foi inserido com sucesso.</span><br>
               <span class="font_cinza_p">A publicação do seu anúncio será efetuada em breve.</span>
            <?php
            
            } elseif ( $_REQUEST['acao']=='exclusao' ) {?>
               <span class="font_cinza_p"><?=$_SESSION['apelido']?><br></span>
               <span class="font_cinza_p">Seu anúncio:</span>
               <span class="font_azul_p"><?=$titulo?></span>
               <span class="font_cinza_p">foi EXCLUÍDO com sucesso.</span><br>
            <?php
            }
            ?>

            <br><br><br>
               
         </div>            
      </div>         

      <div class="row fundo_verde_claro">            
          <div class="col-12">
            <br><br><br><br><br><br><br><br><br><br>
          </div>
      </div>

   </div> <!-- container -->

   <footer>
      <?= Utils::exibir_copyright();?>        
   </footer>

   <!--  -->
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>

   


</body>

</html>
