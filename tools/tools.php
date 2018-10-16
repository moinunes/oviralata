<?php

/**
 *  Classe com funçoes genéricas do Sistema
 */
class Tools {
   
   function __construct() {
      // nada
   }

   public function exibir_data_extenso() {
      setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
      date_default_timezone_set('America/Sao_Paulo');       
      //.. Imprime a data por extenso
      echo strftime('%A, %d de %B/%Y', strtotime('today'));
   } // exibir_data_extenso


} // Tools

//function validar_login() {
//   $resultado = false;
//   if ( $_REQUEST['frm_usuario']=='moinunes' ) {
//      $resultado = true;
//      $_SESSION['login'  ] = true;
//      $_SESSION['usuario'] = 'moinunes';
//   }   
//   return $resultado;
//}
//
//function logout() {   
//   if(isset($_SESSION['login'])){
//       session_destroy();
//       header("Location:login.php");
//   }
//}




?>

