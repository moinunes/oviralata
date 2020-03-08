<?php
if(!isset($_SESSION)) {
   session_start();
}
?>

<div class="row fundo_verde_claro">
   <div class="col-12 altura_linha_1"></div>
</div>


<div class="row fundo_verde_claro">            
   <div class="col-4">
      <div class="dropdown">
         <button class="btn btn_menu dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Menu
         </button>
         <div class="dropdown-menu fundo_azul_escuro" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item link_menu_1" href="cadastro/cad_usuario.php?acao=alteracao&comportamento=exibir_formulario_alteracao">Meu Cadastro</a>
            <a class="dropdown-item link_menu_1" href="cadastro/index.php">Anunciar - grátis</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item link_menu_2" href="index.php">Início</a>
            <a class="dropdown-item link_menu_2" href="adotar.php">Adotar um PET</a>
            <a class="dropdown-item link_menu_2" href="perdido.php">Pet Desaparecido</a>
            <a class="dropdown-item link_menu_2" href="servico.php">Serviços e Produtos Pet</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item link_menu_2" href="/blog">B L O G</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item link_menu_2" href="contato.php">Fale Conosco</a>
            <!-- <a class="dropdown-item" href="blog">Blog</a> -->
         </div>
      </div>
   </div>

   <div class="col-4 d-none d-lg-block"> <!-- desktop -->
      <a href="index.php"><img src="./images/logo.png"></a>
      <span class="font_verde_g text-righ"></span>
   </div>
   <div class="col-4 d-lg-none"> <!-- mobile -->
      <a href="index.php"><img src="./images/logo.png"></a>
   </div>

   <div class="col-4">
       <a class="btn btn_anunciar" href="cadastro/index.php">Anunciar</a>
   </div>
      
</div>

<div class="row fundo_verde_claro">            
   <div class="col-12 altura_linha_1"></div>
</div>

<?php

if ( isset($_SESSION['login']) && $_SESSION['login'] ) {
   $mens  = $_SESSION['sexo']=='F' ? " Bem-vinda" : " Bem-vindo";
   ?>
   <div class="row fundo_laranja_0">            
      <div class="col-12 text-right">
         <span class="font_cinza_p text-righ">Olá,</span>
         </span><span class="font_azul_p"><?=$_SESSION['apelido']?>.</span>
         <span class="font_preta_p"><?=$mens?></span>
            <a href="cadastro/cad_login.php?acao=logout"><img src="./images/sair.png"></a>   
         </span>
      </div>   
   </div>
<?php
} else {?>
   <div class="row fundo_azul_claro">            
      <div class="col-12 text-right">
         <span class="font_azul_m text-righ"><ins><a href="cadastro/index.php">Entrar</a><ins></span>
      </div>   
   </div>
<?php
}?>
