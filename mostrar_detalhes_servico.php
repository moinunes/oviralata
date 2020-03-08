<?php
if(!isset($_SESSION)) {
   session_start();
}
include_once 'servico_hlp.php';
include 'carrossel_adotar.php';

$anuncios = new Servico_Hlp();
$anuncios->set_id_servico($_REQUEST['frm_id_servico']);
$anuncios->obter_servicos($consulta_anuncios);
$anuncio = $consulta_anuncios[0];

$usuario = new Cad_Usuario_Hlp();
$usuario->set_id_usuario($anuncio->id_usuario);
$usuario->obter_dados_usuario( $usuario );

$dados = Utils::obter_array_fotos_servico( $anuncio->id_servico, $anuncio->data_cadastro );

$id_anuncio     = $anuncio->id_servico;
$titulo         = $anuncio->titulo;
$nome_municipio = $anuncio->municipio.' - '.$anuncio->uf;
$nome_bairro    = $anuncio->bairro;
$descricao      = nl2br($anuncio->descricao);

Utils:: obter_mensagens( $mensagem_1, $mensagem_2 );

   $tipo_fonte  = 'font_verde_g';
   $tipo_fundo  = '';
   $_png = './images/servico.png';

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <?php Utils::meta_tag() ?>

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="./dist/css/estilo.css" >
   <link rel="stylesheet" href="./dist/fonts/fonts.css" >
   <link rel="stylesheet" href="./dist/css/estilo_slick_detalhes.css" >

   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick-theme.css"/> 

   <style>
   </style>
   
</head>

<body class="fundo_branco_1">
  
   <div class="container">

       <?php include_once 'cabecalho.php';?>

      <div class="row border-top">
         <div class="col-12 altura_linha_1"><br></div>
      </div>   

      <div class="row fundo_branco_1">            
         <div class="col-12 text-center">
            <a href="servico.php"><img src="<?=$_png?>"></a>  
         </div>   
      </div>
      
      <div class="row">
         <div class="col-12 altura_linha_1">
            <br>
         </div>
      </div>   

      <div class="row">         
         
         <!-- destaque Desktop -  ***lado esquerdo*** -->   
         <div class="col-lg-3 col-xl-3 d-none d-lg-block">

             <div class="row shadow p-1 mb-1 rounded">
               <div class="col-12 text-center fundo_laranja_0">
                  <?php  Utils::exibir_anuncio_aleatorio( 'doacao', 'Amiguinhos para Adoção,<br> veja mais aqui!', '#fafafa'); ?>
               </div>
            </div>

            <div class="row">         
               <div class="col-12 text-center">
                  <span class="tit_1">
                     <br>
                     Uma casa com um PET é como um jardim com flores!
                  </span>
                  <br><br>
               </div>  
            </div>

            <div class="row">         
               <div class="col-12 text">
                  <?php Utils::exibir_tipos_anuncio('desktop', 'Publicar:' ) ?>
               </div>  
            </div>

         </div>
         

         <!-- coluna do meio -->  
          <!-- monta o slick carousel -->
         <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6" >
            <div class="row border <?=$tipo_fundo?> shadow p-1 mb-1 rounded">              
               <div class="col-12">
                  <div class="row">              
                     <div class="col-12 text-center">
                        <span class="titulo_1"><?=$anuncio->titulo ?><br></span>
                     </div>  
                  </div>
                  <div id="div_slide" class="row" style="display:none">
                     <div class="col-12 text-center">
                        <div class="anuncio_<?=$anuncio->id_servico?> slide" >                        
                           <?php                          
                           $i = 1;
                           $pasta_dc = 'fotos_servico/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
                           foreach ( $dados->fotos as $imagem ) {
                              $caminho=$pasta_dc.$imagem;
                              ?>                     
                              <div>   
                                  <img src="<?=$caminho?>" class='img-fluid rounded border border-warning' alt="adote um pet, cachorro, gato ou outro animal de estimação" >
                              </div>
                           <?php
                           }
                           ?>
                        </div>
                     </div>               
                  </div>
                  <div class="row">              
                     <div class="col-12 text-center">
                        <span class="titulo_1"><?=$anuncio->titulo ?><br></span>
                     </div>  
                  </div>

                  <div class="row"> <!-- Esconde em telas menores que lg -->
                     <div class="col-12">            
                        <span class="font_cinza_m"><?=$descricao ?></span>
                     </div>
                     <div class="col-12 altura_linha_2"></div>
                  </div>  

                  <div class="row">                     
                     <div class="col-12 text">
                        <span class="destaque_2">Localidade</span>                 
                     </div>
                     <div class="col-12">
                        <span class="font_courier_p">Data..:&nbsp;</span>
                        <span class="text-muted"><?= Utils::data_anuncio($anuncio->data_atualizacao)?></span><br>
                     </div>
                     
                     <div class="col-12">
                        <span class="font_courier_p">Cidade:&nbsp;</span>
                        <span class="text"><?=$nome_municipio?></span>            
                     </div>      
                     <div class="col-12">
                        <span class="font_courier_p">Bairro:&nbsp;</span>
                        <span class="text"><?=$nome_bairro ?></span>            
                     </div>                    
                  </div>
                  
                  <div class="row">
                     <div class="col-12 altura_linha_2"></div>
                     <div class="col-12">
                        <span class="destaque_2 sem_margem">Dados do Anunciante:</span> 
                     </div>  
                  </div>
                  <div class="row">
                     <div class="col-12">
                        <span class="font_courier_p">Nome..:</span> 
                        <span class="text"><?= "{$anuncio->apelido}"?></span>           
                        <br>
                     </div>  
                  </div>
                  <?php
                  if ( $usuario->exibir_tea=='E' || $usuario->exibir_tea=='A' ) {?>
                     <div class="row">                  
                        <div class="col-12">
                           <span class="font_courier_p">E-mail:</span>
                           <span class="text"><?="{$anuncio->email}"?></span>
                        </div>
                     </div>
                  <?php
                  }
                  ?>
                  <?php
                  if ( $usuario->exibir_tea=='T' || $usuario->exibir_tea=='A' ) {
                     
                     $display_celular  =  $anuncio->tel_celular  == '' ? 'display:none;' : '';
                     $display_whatzapp =  $anuncio->tel_whatzapp == '' ? 'display:none;' : '';
                     $display_fixo     =  $anuncio->tel_fixo     == '' ? 'display:none;' : '';
                   
                     ?>
                     <div class="row">
                        <div class="col-12 altura_linha_1"></div>
                        <div class="col-12">
                           <div class="row" style="<?=$display_celular?>" >
                              <div class="col-2">
                                <img src="./images/cel.png" alt="o vira lata - adote um pet, cachorro, gato ou outro animal de estimação">
                              </div>
                              <div class="col-10">
                                 <span class="text">(<?=$anuncio->ddd_celular?>) <?=$anuncio->tel_celular?></span>
                              </div>         
                           </div>
                           <div class="row" style="<?=$display_whatzapp?>" >   
                              <div class="col-2">
                                 <img src="./images/whatsapp.png" alt="<?=$anuncio->tel_whatzapp?>">
                              </div>
                              <div class="col-10">
                                 <span class="text">(<?=$anuncio->ddd_whatzapp?>) <?=$anuncio->tel_whatzapp?></span>
                              </div>         
                           </div>           
                           <div class="row" style="<?=$display_fixo?>" >
                              <div class="col-2">
                                 <img src="./images/fixo.png" alt="respeito e amor aos animais">
                              </div>
                              <div class="col-10">
                                 <span class="text">(<?=$anuncio->ddd_fixo?>) <?=$anuncio->tel_fixo?></span>
                              </div>         
                           </div>
                        </div>
                        
                        <?php
                        /*
                        if ( $anuncio->tel_whatzapp!='' ) {?>
                           <div class="col-12 text-right">
                              <span>          
                              <a class="btn btn_whatzapp"  target="_blank" href="https://www.forblink.com/index.php?phone=<?="55{$anuncio->ddd_whatzapp}{$anuncio->tel_whatzapp}"?>&text=Olá&nbsp;<?="{$anuncio->apelido}"?>">
                                 <img src="./images/whatsapp.png">Contato pelo WhatsApp.
                              </a>
                              <span>
                           </div>
                        <?php
                        }*/?>
                        <div class="col-12 altura_linha_2"></div>
                        <div class="col-12 text-center">
                           <span class="tit_0">Entre em contato com o anunciante<br> por e-mail, celular ou WhatsApp.</span>
                        </div>
                        

                     </div>                                   
                  <?php
                  }
                  ?>            
                  
                  <div class="row fundo_branco">
                     <div class="col-12">                  
                        <!-- *** rodapé-->    
                     </div>
                  </div>
         
               </div>
            </div>

         </div>      

         <!-- *** lado Direito -->   
         <!-- adscence -->
         <div class="col-lg-3 col-xl-3 d-none d-lg-block">

            <div class="row shadow p-1 mb-1 rounded margem_pequena fundo_laranja_0">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 text-center">
                  <span class="text-center"><?=$mensagem_1?><span>
               </div>
               <div class="col-12 altura_linha_1"></div>
            </div>
            
            <div class="row text-center margem_pequena">
               <div class="col-12 altura_linha_2"></div>
               <div class="col-12 tit_0">Publicidade</div>     
               <div class="col-12">
                  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- grafico_vertical_2 -->
                  <ins class="adsbygoogle"
                       style="display:block"
                       data-ad-client="ca-pub-2582645504069233"
                       data-ad-slot="1529569902"
                       data-ad-format="auto"
                       data-full-width-responsive="true"></ins>
                  <script>
                       (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
               </div>
            </div>
         </div>      

      </div>

      <script src="./dist/js/jquery-3.3.1.min.js"></script>
      <script src="./dist/bootstrap-4.1/js/popper.min.js"></script>
      <script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="./dist/slick/slick/slick.min.js"></script>

      <div class="row text-center">
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 tit_0">Publicidade</div>
         <div class="col-12 text-center"> 
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-format="fluid"
                 data-ad-layout-key="-fb+5w+4e-db+86"
                 data-ad-client="ca-pub-2582645504069233"
                 data-ad-slot="8484848734"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
         </div>
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>
      </div>


      <?php montar_js($consulta_anuncios); ?>

      <div class="row fundo_branco_1">
         <div class="col-12 altura_linha_2"></div>
         <div class="col-12 altura_linha_2"></div>   
      </div>

       <div class="row fundo_branco_1">
         <div class="col-md-12 text-center">
            <a class="btn btn_voltar" href="javascript:window.history.back()" role="button"><img src="images/voltar.svg"> Voltar</a>
            <br><br>
         </div>
         <div class="col-12 altura_linha_2"></div>
      </div>


   </div> <!-- /container -->      


<?php
function montar_js($consulta_anuncios) {
   echo "<script type='text/javascript'>
            $(document).ready(function() { \n";
   foreach ( $consulta_anuncios as $anuncio ) {
      $id_servico = $anuncio->id_servico;
      echo "$('.anuncio_".$id_servico."').slick({               
               infinite: true,
               speed: 500,
               adaptiveHeight: true,    
               fade: true,               
            });\n";
   }
   echo " })";
   echo "</script>";
}
?>

<script type="text/javascript">   

   $('form[name="form_email"]').submit(function () {
       enviar_email();
       return false;
   });

   function enviar_email() {   
      _apelido       = $("#frm_apelido").val()     
      _email_destino = $("#frm_email_destino").val();
      _nome          = $("#frm_nome").val();
      _email         = $("#frm_email").val();
      _ddd           = $("#frm_ddd").val();
      _tel           = $("#frm_tel").val(); 
      _mens          = $("#frm_mens").val(); 
      _url           = window.location.origin+'/cadastro/enviar_email_hlp.php';
      $.ajax({ 
         url: _url,
         type: "POST",
         async: true,
         data: { 
            acao:'mostrar_detalhes',
            apelido:_apelido,  
            email_destino:_email_destino,
            nome:_nome,
            email:_email,
            ddd:_ddd,
            tel:_tel,
            mens:_mens
         }
      })
      .done(function(data){
         var obj = JSON.parse(data);
         if ( obj.resultado == 'sucesso' ) {
            _result  = '<span class="font_azul_p">';
            _result += '<hr>';
            _result += '&nbsp;&nbsp;Olá '+_nome+','; 
            _result += '<br>';
            _result += '&nbsp;&nbsp;Seu email foi enviado com sucesso!';   
            _result += ' <br><hr>';
            _result += '</span>';   
            
            $("#div_email").html( _result );         
         }         
      });

   }

 
   function mostrar_detalhes(id) {
      window.location.href="mostrar_detalhes_servico.php?frm_id_servico="+id;
   }

   $( document ).ready(function() {
      $('#div_slide').show();
   });


</script>   


</body>

</html>
