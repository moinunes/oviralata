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

   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick-theme.css"/> 

   <style>
    
    .carousel-inner {
         text-align: center;
         border:1px solid #2E64FE;
         border-radius: 3%;       
         box-shadow: 1px 0px 1px 2px #81DAF5;
           
         min-height:0px !important;;
         max-height:640px !important;
     }
     .carousel-control-prev-icon, .carousel-control-next-icon {
         height:40px;   
         width:100%;
         /*background-color: rgba(0, 0, 0, 0.3)*/
          background-color: rgba(0, 0, 0, 0.3);
         background-size: 50%, 15%;
         border-radius: 30%;
         border: 3px solid #ffffff;
   box-shadow: 1px 0px 1px 2px #2E64FE;;
      }

   </style>
   
</head>

<body>

   <header>      
      <input type="hidden" id="frm_id_imovel" name="frm_id_imovel" value = "">
      <div class="row div_cabecalho_detalhes">
         <div class="col-md-1">
         </div>         
         <div class="col-md-4">         
            <img src="images/logo.png">
         </div>
         <div class="col-md-7"> 
         </div>
      </div>      
   </header>  

   <form id="frmMostrarDetalhes" class="form-horizontal" action="mostrar_detalhes.php" method="POST" role="form">
   
   <div class="container">

      <!-- código e título -->
      <div class="row">
         <div class="col-md-12">
            <span class="font_azul_m border border-primary">Código:<?=$id_imovel ?></span>
            &nbsp;&nbsp;&nbsp;         
            <span class="font_preta_g"><?=$titulo ?></span>
         </div>  
      </div>   
      <div class="row">       
         <div class="col-md-6 text-right">
            <span class="font_preta_m"><?=$nome_municipio .' - '. $nome_bairro ?></span>            
         </div>      
      </div>
      

      <!-- essa linha tem 3 colunas -->
      <div class="row">
         
         <!-- coluna:1 -->
         <div class="col-md-6">
            <div class="row">
               <div class="col-md-12"></div>
            </div>

            <div class="row">
               <!-- monta o carousel -->
               <div class="col-md-12 borda_0">                  
                  <div id="imovel_<?=$id_imovel?>" class="carousel slide" data-ride="carousel" data-interval="false">
                     <div class="carousel-inner" >
                         
                        <?php
                        $i = 1;
                        foreach ( $imagens as $imagem ) {
                           $item_class = ($i == 1) ? 'carousel-item active' : 'carousel-item';
                           $caminho="fotos/{$id_imovel}/{$imagem}";?>
                           <div class="<?=$item_class;?>">   
                             <img class="img-fluid" src="<?=$caminho?>" alt="<?=$imagem;?>" >
                           </div> 
                           <div class="carousel-caption">
                               <span><?=$imovel->tipo_imovel; ?></span><br>                              
                           </div>                         
                        <?php
                        $i++;
                        }
                        ?>
                        <a class="carousel-control-prev" href="#imovel_<?=$id_imovel;?>" role="button" data-slide="prev">
                           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#imovel_<?=$id_imovel;?>" role="button" data-slide="next">
                           <span class="carousel-control-next-icon" aria-hidden="true"></span>                           
                        </a>      
                     </div>
                  </div>                  
               </div>               
               <!-- fim do carousel -->
            </div>   

         </div>

         <!-- coluna:2 -->
         <div class="col-md-3">

            <div class="row">
               <div class="col-md-12">
                  <span class="font_preta_m">PREÇO DE COMPRA<br></span>
                  <span class="font_azul_g">R$ <?=$imovel->valor_imovel; ?><br></span>
                  
                  <span class="font_cinza_m">&nbsp; &nbsp; &nbsp; CONDOMÍNIO:</span>
                  <span class="font_azul_p"><?='R$ '.$imovel->valor_condominio ?><br></span>
                  
                  <span class="font_cinza_m ">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; IPTU:</span>
                  <span class="font_azul_p text-right"><?='R$ '.$imovel->valor_iptu ?><br></span>

                  <span class="font_cinza_m "> &nbsp; &nbsp; &nbsp; &nbsp; LAUDÊMIO:</span>
                  <span class="font_azul_p text-right"><?='R$ '.$imovel->valor_laudemio ?><br></span>
                  <hr>
               </div>
            </div>   
            
            <div class="row">      
               <div class="col-md-12">
                  <span class="font_preta_m">TIPO DE IMÓVEL<br></span>                  
                  <span class="font_azul_g"><?= "{$imovel->tipo_imovel}" ?></span>
                  <hr>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <span class="font_preta_m"><img class="altura_1" src="images/carro.png">&nbsp;<?= "{$imovel->qtd_vaga}"?> vagas</span>
                  <br>
                  <span class="font_preta_m"><img class="altura_1" src="images/cama.png"><?= "{$imovel->qtd_quartos}"?> quartos</span>                  
                  <br>               
                  <span class="font_preta_m"><img class="altura_1" src="images/area.png">&nbsp;<?= "{$imovel->area_util}m²"?> &nbsp; área útil</span>
                  <br>
                  <span class="font_preta_m"><img class="altura_1" src="images/banheiro.png">&nbsp;<?="{$imovel->qtd_banheiro}"?> banheiros</span>
                   <br>
                  <span class="font_preta_m"><img class="altura_1" src="images/idade.png">Idade do imóvel:&nbsp;<?="{$imovel->idade_imovel}"?>&nbsp;anos</span>
               </div>              
            </div>

            
         </div>
      
         <!-- coluna:3  e-mail -->
         <div class="col-md-3">
            <div class="row borda_2">
               <div class="col-md-12">                  
                  <span class="font_azul_m">Fale com o anunciante</span>
                  <br>
               </div>            
               <div class="col-md-12"><hr class="hr2"></div>
               <div class="col-md-12">                  
                  Telefones:<br>
                  <span class="font_cinza_m">(013) 2372-9551<br></span>
                  <span class="font_cinza_m">(013) 9999-9551 WhatsApp</span>
               </div>
               <div class="col-md-12"><hr class="hr2"></div>
               <div class="col-md-12">
                  <label for="frm_titulo">Nome</label>
                  <input type="text" class="form-control form-control-sm" id="frm_nome" name="frm_nome" required  value="" />
               </div>
               <div class="col-md-12">
                  <label for="frm_titulo">E-mail</label>
                  <input type="email" class="form-control form-control-sm" id="frm_email" name="frm_email" required  value="" />
               </div>
               <div class="col-md-12">
                  <label for="frm_titulo">Telefone</label>
                  <input type="text" class="form-control form-control-sm" id="frm_nome" name="frm_nome" required  value="" />
               </div>
               <div class="col-md-12">                  
                  <a class="btn btn-outline-success btn_email" href="cadastro_imovel.php?acao=alteracao&comportamento=exibir_listagem"><img src="./images/mail.svg"> Enviar e-mail</a>
               </div>
            </div>
         </div>

      </div>

      



      <div class="row">
         <div class="col-md-12">              
            
         </div>            
      </div>
      
      <!-- descrição do imóvel -->      
      <div class="row">         
         <div class="col-md-12 borda_branca_1">            
            <span class="font_cinza_g"><?=$descricao ?></span>
         </div>  
      </div>   

      <div class="row">
         <div class="col-md-12">              
            <br>            
         </div>            
      </div>
      
      
   </div> <!-- /container -->      

</form>


   <!-- patrocínio -->
   <div class="row">
      <div class="col-md-4 border border-success">              
         <br><br><br>
         patrocínio
      </div>            
      <div class="col-md-4 border border-success">              
         <br><br><br>
         patrocínio
      </div>            
      <div class="col-md-4 border border-success">              
         <br><br><br>
         patrocínio
      </div>            
   </div>

   <br>
   <footer>      
      <input type="hidden" id="frm_id_imovel" name="frm_id_imovel" value = "">
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>         
         <div class="col-md-4">         
            <span class="font_cinza_p">Copyright © 2018 www,imobiliaria.com Todos os direitos reservados. </span>
         </div>
         <div class="col-md-7"> 
         </div>
      </div>      
   </footer>

<?php
function montar_js($consulta_imoveis) {
   echo "<script>";
   echo "$(document).ready(function() {  ";
   foreach ( $consulta_imoveis as $imovel ) {
      $id_imovel = $imovel->id_imovel;
      echo "$('#imovel_".$id_imovel."').carousel({
               interval:false
            })";
   }
   echo " })";
   echo "</script>";
}
?>        



<!--  -->
<script src="./dist/js/jquery-3.3.1.min.js"></script>
<script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./dist/slick/slick/slick.min.js"></script>


<script type="text/javascript">
   
   
   
</script>   

</body>

</html>
