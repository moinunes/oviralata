<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$from    = "ze@gmail.com";
$to      = "moinunes@gmail.com";
$subject = "Verificando o correio do PHP";
$message = "O correio do PHP funciona bem";

$headers = "De:". $from;
mail( $to, $subject, $message, $headers);

echo '
<div class="row fundo_laranja_1">               
   <div class="col-md-12"><hr class="hr2"></div>

   <div class="col-md-12 text-center">
      <br>
      <br>
      <div>Email enviado com sucesso</div>      
      <br>
      <br>
   </div>
  
</div>
';

?>