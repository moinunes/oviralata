<?php
$id_usuario = isset($_SESSION['id_usuario']) ?  $_SESSION['id_usuario'] : '';
?>

<!-- todos dispositivos -->
<div class="row fundo_branco_1">
   <div class="col-12 altura_linha_2"></div>
   <div class="col-auto">
      <a class="link_a font_azul_m" href="cad_anuncio.php?acao=exibir&comportamento=exibir_listagem" role="button">Meus anúncios</a>
   </div>
   <div class="col-auto">
      <a class="link_a font_azul_m" href="cad_anuncio.php?acao=inclusao&comportamento=exibir_formulario" role="button">Inserir Anúncio</a>
   </div>
   <div class="col-12 altura_linha_1"></div>
   <div class="col-12 altura_linha_2"></div>
</div>         
