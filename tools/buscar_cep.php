<?php
include_once 'endereco_hlp.php';

$acao                = isset($_POST["acao"])                ? $_POST["acao"]                : '';
$filtro_cep          = isset($_POST["filtro_cep"])          ? $_POST["filtro_cep"]          : '';
$filtro_logradouro   = isset($_POST["filtro_logradouro"])   ? $_POST["filtro_logradouro"]   : '';
$filtro_id_municipio = isset($_POST["filtro_id_municipio"]) ? $_POST["filtro_id_municipio"] : '';

$instancia = new Endereco_Hlp();
$instancia->set_filtro_cep( $filtro_cep );
$instancia->set_filtro_nome_logradouro( $filtro_logradouro );
$instancia->set_filtro_id_municipio( $filtro_id_municipio );
$instancia->obter_enderecos($enderecos);

$municipio = new Endereco_Hlp();
$municipio->obter_municipios($municipios);


?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Imobiliaria</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
         <div class="col-md-3">
            <label for="frm_filtro_id_municipio">Município</label>
            <select id='frm_filtro_id_municipio' name='frm_filtro_id_municipio' class="form-control form-control-sm" >
             <?php
                $selected = 'selected';                
                foreach ($municipios as $item ) {?>
                  <option value="<?=$item['id_municipio']?>"><?=$item['nome_municipio']?></option>
                <?php
                }?>
            </select>
         </div>

         <div class="col-md-3">
            <label for="frm_filtro_cep">Cep</label>
             <input type="text" class="form-control form-control-sm" id="frm_filtro_cep" name="frm_filtro_cep" value="<?=$filtro_cep?>">
         </div>            
         <div class="col-md-4">
            <label for="frm_filtro_logradouro">Logradouro</label>
            <input type="text" class="form-control form-control-sm" id="frm_filtro_logradouro" name="frm_filtro_logradouro" value="<?=$filtro_logradouro?>" >
         </div>
         <div class="col-2">
            <br>
            <button type="button" class="btn btn_padrao" id='btnFiltrarPesquisa'>Filtrar</button>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <hr class="hr1">
         </div>
      </div>

      <div class="row">
         <div class="col-md-2"><span class="font_cinza_m">Cep</span></div>
         <div class="col-md-4"><span class="font_cinza_m">Logradouro</span></div>
         <div class="col-md-2"><span class="font_cinza_m">Bairro</span></div>         
         <div class="col-md-4"><span class="font_cinza_m">Complemento</span></div> 
      </div>

      <div class="row">
         <div class="col-md-12">
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
               $cep           = $item['cep'];
               $chave         = $cep.','.$id_logradouro;
               $link  = "<a  class='btn btn-outline-success btn_link' href='javascript:PreencherEndereco(".$chave. ")'>";
               $link .= "{$cep}</a>";
               print $link;
               ?>
            </div>           
            
            <div class="col-md-4">
               <?php
               $nome_logradouro = $item['nome_logradouro'];               
               $link  = "<a  class='btn font_cinza_m' href='javascript:PreencherEndereco(".$chave.")'>";
               $link .= "{$nome_logradouro}</a>";
               print $link;
               ?>
            </div>           
            
            <div class="col-md-2">
               <?php
               $nome_bairro = $item['nome_bairro'];               
               $link  = "<a  class='btn font_cinza_m' href='javascript:PreencherEndereco(".$chave.")'>";
               $link .= "{$nome_bairro}</a>";
               print $link;
               ?>
            </div>

            <div class="col-md-4"><span class="font_cinza_m"><?=$item['complemento']?></span></div>
         </div>
      <?php
      }?>
     
      </form>

   </div> <!-- container  -->


   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist/jquery-ui/jquery-ui.min.js"></script>   
   <script src="../dist/js/cadastro_imovel.js"></script>


</body>

</html>

