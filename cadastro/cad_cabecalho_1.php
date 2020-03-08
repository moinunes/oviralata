<?php


$id_usuario = $_SESSION['id_usuario'];
$apelido = isset($_SESSION['apelido']) ?  $_SESSION['apelido'] : '';
$programa = explode('/', debug_backtrace()[0]['file'] );
$programa = trim(end($programa));

?>

<div class="row fundo_verde_claro">            
   <div class="col-12 altura_linha_2"></div>
</div>   

<!-- desktop -->
<div class="row fundo_verde_claro">  
   
   <div class="col-3 d-none d-lg-block">
      <img src="../images/logo.png" >
   </div>

   <div class="col-md-2 d-none d-lg-block"> 
      <?php
      if($apelido!='') {?>
         <span class="font_cinza_p text-righ">Olá,&nbsp;</span><span class="font_azul_p"><?=$_SESSION['apelido']?></span>
      <?php
      }?>
   </div>
   
   <?php
   if ( $programa == 'index.php' ) {?>
      <div class="col-md-2 d-none d-lg-block">
          <a class="btn btn_padrao" href="../index.php" role="button">Voltar</a>
      </div> 
   <?php
   } else {?>
      <div class="col-md-2 d-none d-lg-block">
          <a class="btn btn_padrao" href="index.php" role="button">Voltar</a>
      </div> 
   <?php
   }?>
  
   <div class="col-12 altura_linha_2 fundo_verde_claro"></div>
   
</div>

<!-- mobile -->
<div class="row d-lg-none fundo_verde_claro"> 
   <div class="col-4">
      <img src="../images/logo.png" >
   </div>
   <div class="col-4">
      <?php
      if($apelido!='') {?>
         <span class="font_cinza_p text-righ">Olá,&nbsp;</span><span class="font_azul_p"><?=$_SESSION['apelido']?></span>
      <?php
      }?>
   </div>
   
   <div class="col-4">
      <div class="row">
         <div class="col-12 altura_linha_1"></div>
      </div>
      
      <?php
      if ( $programa == 'index.php' ) {?>
         <div class="row">
            <div class="col-12">
               <a class="btn btn_padrao" href="../index.php" role="button">Voltar</a>
            </div>
         </div>
      <?php
      } else {?>   
         <div class="row">
            <div class="col-12">
               <a class="btn btn_padrao" href="index.php" role="button">Voltar</a>
            </div>
         </div>
      <?php
      }?>

   </div>   
</div>

<div class="row fundo_verde_claro">
    <div class="col-12 altura_linha_1"></div>
</div>

<?php
$usuario = new Cad_Usuario_Hlp();
$usuario->set_id_usuario($id_usuario);
$usuario->obter_dados_usuario( $dados_usuario );

if ( $dados_usuario->bloqueado=='S') {?>
    <div class="row">
      <div class="col-12">
         <span class='font_cinza_p'>Cadastro Bloqueado!<br></span>         
         <span><a href='../index.php'>Voltar</a><br><br></span>
       </div>
   </div>
   <?php
   die('...');
}

if ( $dados_usuario->ativo=='N') {?>
    <div class="row">
      <div class="col-12">
         <span class='font_cinza_p'>Seu cadastro foi realizado com sucesso!<br></span>
         <span class='font_cinza_p'>Mas você precisa verificar sua caixa de e-mail e confirmar o cadastro!<br></span>
         <span class='font_cinza_p'>Isso é necessário para que outra pessoa não utilize o seu e-mail!<br><br></span>

         <span><a href='./cad_esqueceu_senha.php?acao=alteracao&comportamento=exibir_formulario&modo=&frm_email='>ou então, Clique Aqui e redefina sua senha!</a><br><br></span>
       </div>
   </div>
   <?php
   die('...');
}

