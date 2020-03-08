<?php
include_once '../cadastro/utils.php';
$apelido = isset($_SESSION['apelido']) && $_SESSION['apelido'] !='' ? $_SESSION['apelido'] : ''; 
?>

<div class="row fundo_verde_claro">            
   <div class="col-12 altura_linha_1"></div>
</div>

<div class="row fundo_branco_1">
   <div class="col-1">
   </div>
   <div class="col-3 text-center">
      <a href='index.php'><img src="../images/logo.png"></a>
   </div>

   <div class="col-3 text-right">     
      <span class="font_verde_m">TOOLS</span>
   </div>   

   <div class="col-3 text-center">
      <span class="font_cinza_p text-righ">Usuário: <?=$apelido?></span>
   </div>

</div>

<div class="row fundo_verde_claro">            
   <div class="col-12 altura_linha_1"></div>
</div>


 