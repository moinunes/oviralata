<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$codigo= $_POST['codigo_imovel' ];
$nome  = $_POST['nome' ];
$email = $_POST['email'];
$fone  = $_POST['fone' ]; 
$mens  = $_POST['mens' ];

$mensagem  = "<<< Dados do contato >>>\n";
$mensagem .= "Nome: {$nome}\n";
$mensagem .= "Telefone: {$fone}\n";
$mensagem .= "E-mail: {$email}\n";
$mensagem .= "Mensagem:\n{$mens}\n";

$de      = $email;
$to      = "contato@imoveisbs.com.br";
$subject = "Gostei do imóvel: ".$codigo;
$headers = "De:". $de;

if ( mail( $to, $subject, $mensagem, $headers ) ) { 
   echo "
   <div class='row fundo_laranja_1'>               
      <div class='col-md-12'><hr class='hr2'></div>
      <div class='col-md-12 text-center'>
         <br>
         <div>{$nome}</div>
         <br>
         <div>Seu e-mail foi enviado com sucesso</div>      
         <br>
         <br>
      </div>     
   </div>";

 } else{ //.. falhou
   echo "
   <div class='row fundo_laranja_1'>               
      <div class='col-md-12'><hr class='hr2'></div>
      <div class='col-md-12 text-center'>
         <br>
         <br>
         <div>Falha no envio do E-Mail!</div>      
         <br>
         <br>
      </div>     
   </div>";
}    


?>

  
 