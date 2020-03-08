<?php
$id_usuario = isset($_SESSION['id_usuario']) ?  $_SESSION['id_usuario'] : '';
?>

<!-- todos dispositivos -->

<div class="row fundo_cinza_2">   
   <div class="col-auto">
      <a class="link_a" href="cad_servico.php?acao=exibir&comportamento=exibir_listagem" role="button">Meus anúncios</a>
   </div>
   <div class="col-auto">
      <a class="link_a" href="cad_servico.php?acao=inclusao&comportamento=exibir_formulario" role="button">Inserir Anúncio</a>
   </div>
</div>        
