<?php
include_once 'endereco_hlp.php';
  
$acao                = isset($_POST["acao"])              ? $_POST["acao"]              : '';
$filtro_cep          = isset($_POST["filtro_cep"])        ? $_POST["filtro_cep"]        : '';
$filtro_uf           = isset($_POST["filtro_uf"])         ? $_POST["filtro_uf"]         : '';
$filtro_logradouro   = isset($_POST["filtro_logradouro"]) ? $_POST["filtro_logradouro"] : '';
$filtro_municipio    = isset($_POST["filtro_municipio"])  ? $_POST["filtro_municipio"]  : '';

$instancia = new Endereco_Hlp();
$instancia->set_filtro_cep( $filtro_cep );
$instancia->set_filtro_logradouro( $filtro_logradouro );
$instancia->set_filtro_uf( $filtro_uf );
$instancia->set_filtro_municipio( $filtro_municipio );

$instancia->obter_enderecos($enderecos);

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

   <div class="container">

      <form id="frmBuscarCep" class="form-horizontal" method="POST" role="form">

      <div class="row">
         <div class="col-md-1">
            <label for="frm_filtro_uf">UF</label>
            <input type="text" class="form-control form-control-sm" id="frm_filtro_uf" name="frm_filtro_uf" value="<?=$filtro_uf?>" required maxlength='2'   >
         </div>
         <div class="col-md-3">
            <label for="frm_filtro_municipio">Município</label>
            <input type="text" class="form-control form-control-sm" id="frm_filtro_municipio" name="frm_filtro_municipio" value="<?=$filtro_municipio?>" required >
         </div>

         <?php
         if(isset($exibir_cep)){?>
         <div class="col-md-3">
            <label for="frm_filtro_cep">Cep</label>
             <input type="text" class="form-control form-control-sm" id="frm_filtro_cep" name="frm_filtro_cep" value="<?=$filtro_cep?>">
         </div>
         <?php
         }
         ?>            

         <div class="col-md-4">
            <label for="frm_filtro_logradouro">Logradouro</label>
            <input type="text" class="form-control form-control-sm" id="frm_filtro_logradouro" name="frm_filtro_logradouro" value="<?=$filtro_logradouro?>" required >
         </div>
         <div class="col-2">
            <br>
            <button type="button" class="btn btn_padrao" id='btnFiltrarPesquisa' name='btnFiltrarPesquisa'>Filtrar</button>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <hr class="hr1">
         </div>
      </div>

      <div class="row">
         <div class="col-2"><span class="font_cinza_m">Cep</span></div>
         <div class="col-10"><span class="font_cinza_m">Endereço</span></div>
      </div>

      <div class="row">
         <div class="col-12">
            <hr class="hr1">
         </div>
      </div>

      <?php
      $i = 0;
      foreach ($enderecos as $item ) {
         if( $i % 2 == 0 ) {
            $cor='cor_zebra_1';
            $i=1;
         } else {
            $cor='cor_zebra_2';
            $i = 0;
         }?>
         <div class="row <?= "{$cor}" ?>">
            <div class="col-md-2">
               <?php
               $id_logradouro = $item['id_logradouro'];
               $cep           = $item['cep'          ];
               $logradouro    = $item['logradouro'   ];
               $uf            = $item['uf'           ];
               $chave         = $cep.','.$id_logradouro;
               $link  = "<a  class='btn btn-outline-success btn_link' href='javascript:PreencherEndereco(".$chave. ")'>";
               $link .= "{$cep}</a>";
               print $link;
               ?>
            </div>           
            
            <div class="col-md-12">
               <?php
               $str1 = $item['logradouro'];
               $str2 = $item['bairro'].' - '.$item['municipio'].' - '.$item['complemento'].' - '.$item['uf'];               
               $link  = "<a  class='btn font_cinza_m' href='javascript:PreencherEndereco(".$chave.")'>";
               $link .= $str1;
               $link .= "</a>";
               print $link.'<br>'.$str2;
               ?>
            </div>
         </div>
      <?php
      }?>
     
      </form>

   </div> <!-- container  -->


   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>   
   <script src="../dist/js/cad_usuario.js"></script>


</body>

</html>

