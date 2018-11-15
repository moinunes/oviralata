<?php
include_once 'utils.php';
?>



<div class="row fundo_verde_claro">            
   <div class="col-12 altura_linha_1"></div>
</div>

<div class="row  fundo_branco_1">
   <div class="col-1">
   </div>
   <div class="col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 text-center">
      <img src="./images/logo.png" >
   </div>
   <div class="col-7 col-sm-6 col-md-4 col-lg-3 col-xl-3 text-right">     
      <span class="font_azul_p"><?php Utils::exibir_data_extenso();?></span>
   </div>   

   <div class="col-5 col-sm-6 col-md-4 col-lg-3 col-xl-3 text-center">            
      <?php 
      if(isset($_SESSION['usuario'])){?>
         <span class="font_cinza_p text-righ"><?=$_SESSION['usuario']?></span>
      <?php 
      }?>
   </div>

</div>

<div class="row fundo_verde_claro">            
   <div class="col-12 altura_linha_1"></div>
</div>
