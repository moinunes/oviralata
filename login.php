<?php
include_once './utils.php';
session_start();

if ( isset($_REQUEST['acao']) && $_REQUEST['acao']=='logout' ) {
   logout();
}

if ( isset($_REQUEST['frm_usuario']) ) {
   if ( validar_login() ) { 
      header("Location: tools.php");
   }
}

function validar_login() {
   $resultado = false;
   $conecta   = new Conecta();
   $usuario   = $_REQUEST['frm_usuario'];
   $senha     = MD5($_REQUEST['frm_senha']);
   $sql = " SELECT       
               usuario
            FROM 
               tbusuario
            WHERE usuario = '{$usuario}' AND senha = '{$senha}'
         "; 
   $stmt = $conecta->con->prepare( $sql );      
   $stmt->execute();
   $usuario = $stmt->fetch(PDO::FETCH_OBJ);
   if ( $usuario != '' ) {
      $resultado = true;
      $_SESSION['login'  ] = true;
      $_SESSION['usuario'] = $usuario->usuario;
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
   <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="./dist/css/estilo.css" >
   
</head>

<body>

   <header>
      <?php include_once 'cabecalho.php';?>      
   </header>  

   <form id="frmLogin" class="form-horizontal" action="login.php" method="POST" role="form">
   
   <div class="container">
   
      <div class="row">            
         <div class="col-12 altura_linha_2"></div>
      </div>

      <div class="row">
         <div class="col-12 col-sm-6 col-md-4 col-lg-8 col-xl-4 border"> 
            
            <div class="row">
               <div class="col-md-12">
                  <label for="frm_usuario">Usuário</label>               
                  <input type="text" class="form-control form-control-sm" id="frm_usuario" name="frm_usuario" value="moinunes">            
               </div>      
            </div>

            <div class="row">
               <div class="col-md-12">
                  <label for="frm_usuario">Senha</label>
                  <input type="password" class="form-control form-control-sm" id="frm_senha" name="frm_senha" value="cpd392781">
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
<script src="./dist/js/jquery-3.3.1.min.js"></script>
   

</body>

</html>