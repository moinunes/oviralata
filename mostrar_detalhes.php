

<?php
include_once 'tools/endereco_hlp.php';
include_once 'imoveis_hlp.php';


$id_municipio = isset($_REQUEST['frm_filtro_municipio']) ? trim($_REQUEST['frm_filtro_municipio']) : '';


//print_r($municipio);
$municipio = new Endereco_Hlp();
$municipio->obter_municipios($municipios);

$imoveis = new Imoveis_Hlp();
$imoveis->set_id_imovel($_REQUEST['id_imovel']);
$imoveis->obter_imoveis($consulta_imoveis);
$imovel = $consulta_imoveis[0];

$id_imovel      = $imovel->id_imovel;
$titulo         = utf8_encode($imovel->titulo);
$nome_municipio = utf8_encode($imovel->nome_municipio);
$nome_bairro    = utf8_encode($imovel->nome_bairro);
$descricao      = utf8_encode(substr($imovel->descricao,0,185));
$imoveis->obter_nomes_imagens( $imagens, $id_imovel );


?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Imobiliaria</title>

   <meta charset="utf-8" />
   <meta name="keywords" content="imobiliaria,imóvel,imóveis,apartamentos,casas,compra,venda,santos, são vicente,"/>
   <meta name="description" content="Escolha seu imóvel na baixada santista.">   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="./dist/css/estilo.css" >
   <link rel="stylesheet" href="./dist/css/estilo_slick_detalhes.css" >

   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick-theme.css"/> 

   <style>
   </style>
   
</head>

<body>


   
   <div class="container-fluid">
         <div class="row div_cabecalho fundo_azul_claro">
            <div class="col-1">
            </div>
            <div class="col-auto"> 
               <span><img src="images/logo.png" class="largura1 align-middle"></span>
            </div>
            <div class="col-auto"> 
               x
            </div>
         </div>
   
   
   </div>      

   
   <div class="container">

      <div class="row border-top">
         <div class="col-12 altura_linha_1"><br></div>
      </div>

      <div class="row fundo_branco_1">
         
         <!-- coluna:1 fotos-->
         <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

            <!-- código e título -->
            <div class="row">
               <div class="col-12 text-center">
                  <span class="font_azul_m border border-primary">Código:<?=$id_imovel ?></span>                  
               </div>  
            </div>   

            <!-- código e título -->
            <div class="row">
               <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center">
                  <span class="destaque_0"><?= "{$imovel->tipo_imovel}" ?></span>                 
               </div>  
               <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center">
                  <span class="destaque_2">R$ <?=$imovel->valor_imovel; ?></span>
               </div>  
            </div>   

                     

            <div class="row">     <!-- monta o slick carousel -->
               <div class="col-12">                  
                  <div class="imovel_<?=$id_imovel?> slide" >                        
                     <?php
                     $i = 1;
                     foreach ( $imagens as $imagem ) {                           
                        $caminho="fotos/{$id_imovel}/{$imagem}";?>
                        <div>   
                          <img src="<?=$caminho?>" >
                        </div>
                     <?php
                     $i++;
                     }
                     ?>                  
                  </div>                  
               </div>               
            </div>   

            <div class="row">
               <div class="col-1">
               </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                  <span class="font_preta_g"><?=$titulo ?></span>
               </div>  
            </div>   
            <div class="row d-none d-lg-block"> <!-- Esconde em telas menores que lg -->
               <div class="col-12">
                  <hr class="hr1">
               </div>   
            </div>      
            <div class="row d-none d-lg-block"> <!-- Esconde em telas menores que lg -->
               <div class="col-md-12">            
                  <span class="font_cinza_m"><?=$descricao ?></span>
               </div>  
            </div>   

         </div>

         <!-- coluna:2  dados do anuncio -->
         <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
            <div class="row">
               <div class="col-12 d-lg-none"> <!-- Esconde em telas maiores que lg -->
                  <hr class="hr1">
               </div>      
               <div class="col-12 text-center">
                  <span class="font_preta_p"><?=$nome_municipio?></span>            
               </div>      
               <div class="col-12 text-center">
                  <span class="font_preta_p"><?=$nome_bairro ?></span>            
               </div>      
               <div class="col-12">
                  <hr class="hr1">
               </div>
            </div>

            <div class="row">
               <div class="col-12">
                  <span class="font_preta_p"><img class="altura_1" src="images/carro.png">&nbsp;<?= "{$imovel->qtd_vaga}"?>&nbsp;<?=($imovel->qtd_vaga>1) ? 'vagas':'vaga'?></span>
               </div>
               <div class="col-12">
                  <span class="font_preta_p"><img class="altura_1" src="images/cama.png"><?= "{$imovel->qtd_quartos}"?>&nbsp;<?=($imovel->qtd_quartos>1) ? 'quartos':'quarto'?></span>
               </div>
               <div class="col-12">
                  <span class="font_preta_p"><img class="altura_1" src="images/area.png">&nbsp;<?="{$imovel->area_util}m²"?>&nbsp;área</span>
               </div>
               <div class="col-12">
                  <span class="font_preta_p"><img class="altura_1" src="images/banheiro.png">&nbsp;<?="{$imovel->qtd_banheiro}"?>&nbsp;<?=($imovel->qtd_banheiro>1) ? 'banheiros':'banheiro'?></span>
               </div>
               <div class="col-12">
                  <span class="font_preta_p"><img class="altura_1" src="images/bide.png">&nbsp;<?="{$imovel->qtd_suite}"?>&nbsp;<?=($imovel->qtd_suite>1) ? 'suítes':'suíte'?></span>
               </div>

               <div class="col-12">    
                  <span class="font_preta_p"><img class="altura_1" src="images/calendario.png">Idade do imóvel:&nbsp;<?="{$imovel->idade_imovel}"?>&nbsp;anos</span>
               </div>              
            </div>

            <div class="row">
               <div class="col-12 altura_linha_1">                  
               </div>                  
            </div>


            <div class="row">
               <div class="col-12">
                  <hr class="hr1">
               </div>      
               <div class="col-6 text-right">
                  <span class="font_cinza_m text-right">Preço:</span>
               </div>   
               <div class="col-6">
                  <span class="font_azul_p"><?='R$ '.$imovel->valor_imovel ?></span>
               </div>                  
            </div>

            <div class="row">
               <div class="col-6 text-right">
                  <span class="font_cinza_m text-right">Condomínio:</span>
               </div>
               <div class="col-6">
                  <span class="font_azul_p"><?='R$ '.$imovel->valor_condominio ?></span>                  
               </div>   
            </div>   

            <div class="row">
               <div class="col-6 text-right">
                  <span class="font_cinza_m text-right">IPTU:</span>
               </div>   
               <div class="col-6">   
                  <span class="font_azul_p"><?='R$ '.$imovel->valor_iptu ?></span>
               </div>
            </div>
            <div class="row">   
               <div class="col-6 text-right">   
                  <span class="font_cinza_m ">Laudênio:</span>
               </div>   
               <div class="col-6">      
                  <span class="font_azul_p text-right"><?='R$ '.$imovel->valor_laudemio ?></span>
               </div>
            </div>   
            <div class="row">   
               <div class="col-12">
                  <hr class="hr1">
               </div>   
            </div>      
            
            <div class="row">
               <div class="col-12">
                  <span class="font_cinza_g text-right"></span>
               </div>   
               <div class="col-12">
                  <span class="font_cinza_g text-right">Características:</span>
               </div>   
               <?php
               if($imovel->lavanderia=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Lavanderia</span>
                  </div>
               <?php
               }               
               if($imovel->salao_festa=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Salão de Festas</span>
                  </div>
               <?php
               }               
               if($imovel->churrasqueira=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Churrasqueira</span>
                  </div>
               <?php
               }               
               if($imovel->academia=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Academia</span>
                  </div>
               <?php
               }               
               if($imovel->piscina=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Piscina</span>
                  </div>
               <?php
               }
               if($imovel->ar_condicionado=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Ar Condicionado</span>
                  </div>
               <?php
               }               
               if($imovel->prox_mercado=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Próximo a mercados</span>
                  </div>
               <?php
               }               
               if($imovel->prox_hospital=='1'){?>
                  <div class="col-12">
                     <span class="font_cinza_m">&#9830; Próximo a hospitais</span>
                  </div>
               <?php
               }
               ?>               
            </div>      

            <div class="row">
                   <div class="col-12 altura_linha_1"></div>
            </div>

            
         </div>
      
         <!-- coluna:3  e-mail -->
         <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 fundo_azul_claro">
            <form method="post" id="form_email" name="form_email" >
                  
               <div class="row fundo_laranja_1">
                  <div class="col-md-12 text-center">                  
                     <span class="font_azul_m">Gostei do imóvel</span>
                     <br>
                  </div>            
                  <div class="col-md-12"><hr class="hr2"></div>
                  <div class="col-md-12">                  
                     Telefones:<br>
                     <span class="font_cinza_m">(013) 9 9708-1968</span>
                     <span><img src="images/whatsapp.png"></span>                     
                  </div>
               </div>
               <div id="div_email">
               <div class="row fundo_laranja_1">
                  <div class="col-md-12"><hr class="hr2"></div>
                  <div class="col-md-12">
                     <label for="frm_nome">Nome</label>
                     <input type="text" class="form-control form-control-sm" id="frm_nome" name="frm_nome" required  value="Moises Nunes" />
                  </div>
                  <div class="col-md-12">
                     <label for="frm_email">E-mail</label>
                     <input type="email" class="form-control form-control-sm" id="frm_email" name="frm_email" required  value="moinunes@gmail.com" />
                  </div>
                  <div class="col-md-12">
                     <label for="frm_fone">Telefone</label>
                     <input type="text" class="form-control form-control-sm" id="frm_fone" name="frm_fone" required  value="9999-8888" />
                  </div>
                  <div class="col-md-12 text-center">
                     <button type="submit" class="btn btn-outline-success btn_email"><img src="./images/mail.svg"> Enviar</button>                    
                  </div>
               </div>
               </div>
            </form>
         </div>
         

      </div>

      <div class="row fundo_branco_1">
         <div class="col-12 altura_linha_2"></div>
      </div>

      
      <!--  -->
      <script src="./dist/js/jquery-3.3.1.min.js"></script>
      <script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="./dist/slick/slick/slick.min.js"></script>

      
      
       <?php montar_js($consulta_imoveis); ?>

       <!-- patrocínio -->
      <div class="row fundo_branco_1">
         <div class="col-md-3 border border">              
            <br><br><br>         
         </div>            
         <div class="col-md-3 border border">              
            <br><br><br>         
         </div>            
         <div class="col-md-3 border border">              
            <br><br><br>         
         </div>            
         <div class="col-md-3 border border">              
            <br><br><br>         
         </div>            

      </div>

   </div> <!-- /container -->      

   
   <br>
   <footer class="fundo_azul_claro">      
      <input type="hidden" id="frm_id_imovel" name="frm_id_imovel" value = "">
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>         
         <div class="col-12">         
            <span class="font_cinza_p">Copyright © 2018 www,imobiliaria.com Todos os direitos reservados. </span>
         </div>
         <div class="col-md-7"> 
            <span class="font_cinza_p">Coretora: Magda CRECI: 123456</span>
         </div>
         <div class="col-md-7"> 
            <span class="font_cinza_p">.</span>
         </div>
      </div>      
   </footer>

<?php


function montar_js($consulta_imoveis) {
   echo "<script type='text/javascript'>
            $(document).ready(function() { \n";

   foreach ( $consulta_imoveis as $imovel ) {
      $id_imovel = $imovel->id_imovel;
      echo "$('.imovel_".$id_imovel."').slick({               
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
   $.ajax({ 
      url: 'enviar_email.php',
      type: "POST",
      async: true,
      dataType: "html",
      data: { 
         acao: 'enviar_email',
         nome: $("#frm_nome").val(),
         email: $("#frm_email").val(),
         telefone: $("#frm_fone").val(),         
      },
      success: function(resultado){   
         $("#div_email").html( resultado );         
      },
      failure: function( errMsg ) { alert(errMsg); } 
   });
} //.. enviar_email




</script>   


</body>

</html>
