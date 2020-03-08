<?php
include_once '../cadastro/utils.php';
session_start();

if ( isset($_REQUEST['acao']) && $_REQUEST['acao']=='logout' ) {
   logout();
}


if ( $acao == 'logar' ) {
   if ( validar_login() ) {
      header("Location: tools.php");
   }
}

/*
* só entra com admin ( a senha está contida no email )
*
*
*/
function validar_login() {
   $resultado = false;
   $conecta   = new Conecta();
   $usuario   = $_REQUEST['frm_usuario'];
   $senha     = MD5($_REQUEST['frm_senha']);   
   $sql = " SELECT     
               id_usuario,  
               apelido,
               sexo,
               email
            FROM 
               tbusuario
            WHERE apelido = '{$usuario}' AND senha = '{$senha}' AND email='{$senha}'
         ";
   $stmt = $conecta->con->prepare( $sql );      
   $stmt->execute();
   $usuario = $stmt->fetch(PDO::FETCH_OBJ);
   if ( $usuario != '' ) {
      $resultado = true;
      $_SESSION['login'     ] = true;
      $_SESSION['id_usuario'] = $usuario->id_usuario;
      $_SESSION['sexo'      ] = $usuario->sexo;
      $_SESSION['apelido'   ] = $usuario->apelido;
   }   
   return $resultado;
}

function logout() {   
   if(isset($_SESSION['login'])){
       session_destroy();
       header("Location:login.php");
   }
}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <?php Utils::meta_tag() ?>

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body>

   <header>
      <?php include_once 'tools_cabecalho.php';?>      
   </header>  

   <form id="frmLogin" class="form-horizontal" action="tools_login.php" method="POST" role="form">
      <input type="hidden" id="comportamento" name="comportamento" value = "logar">         
      <input type="hidden" id="acao"          name="acao"          value = "logar">

   <div class="container">
   
      <div class="row">            
         <div class="col-12 altura_linha_2"></div>
      </div>

      <div class="row">
         <div class="col-12 col-sm-6 col-md-4 col-lg-8 col-xl-4 border"> 
            
            <div class="row">
               <div class="col-md-12">
                  <label for="frm_usuario">Usuário</label>               
                  <input type="text" class="form-control form-control-sm" id="frm_usuario" name="frm_usuario" value="">            
               </div>      
            </div>

            <div class="row">
               <div class="col-md-12">
                  <label for="frm_senha">Senha</label>
                  <input type="password" class="form-control form-control-sm" id="frm_senha" name="frm_senha" value="">
               </div>
            </div>

            <div class="row">
               <div class="col-md-12">
                  <div class="text-right">
                     <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Entrar">
                  </div>
               </div>
            </div>

         </div>
      </div>

   </div> <!-- /container -->

</form>

<!--  -->
<script src="../dist/js/jquery-3.3.1.min.js"></script>
   

</body>

</html>
