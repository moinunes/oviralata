<?php
session_start();

include_once '../cadastro/utils.php';

if ( !isset( $_SESSION['login'] ) ) {
   header("Location: tools_login.php");
 
} else { //.. aqui está logado
   //.. se não tiver logado como 'admin', zera a session e volta para o login aministrativo 
   if ( $_SESSION['apelido'] != 'admin' ) {
      Utils::set_session(0);
      header("Location: tools_login.php"); 

   } else {    
      header("Location: tools.php");  
   }
}
