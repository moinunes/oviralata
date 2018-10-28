<?php

   include_once './tools/endereco_hlp.php';
   include_once './tools/cadastro_hlp_tipo.php';   
   include_once 'imoveis_hlp.php';
   include_once './tools/utils.php';


   $id_tipo_imovel  = isset($_REQUEST['frm_filtro_tipo_imovel']) ? trim($_REQUEST['frm_filtro_tipo_imovel']) : '';
   $id_municipio    = isset($_REQUEST['frm_filtro_municipio'])   ? trim($_REQUEST['frm_filtro_municipio'])   : '';
   $nomes_bairros   = isset($_REQUEST['frm_nomes_bairros'])      ? trim($_REQUEST['frm_nomes_bairros'])      : '';
   $comportamento   = isset($_REQUEST['comportamento'])          ? trim($_REQUEST['comportamento'])          : '';
   $pagina          = isset($_REQUEST['frm_pagina'])             ? trim($_REQUEST['frm_pagina'])             : '';

   $filtro_preco     = isset($_REQUEST['frm_filtro_preco'])      ? trim($_REQUEST['frm_filtro_preco'])       : '';
   $filtro_quarto    = isset($_REQUEST['frm_filtro_quarto'])     ? trim($_REQUEST['frm_filtro_quarto'])      : '';
   $filtro_vaga      = isset($_REQUEST['frm_filtro_vaga'])       ? trim($_REQUEST['frm_filtro_vaga'])        : '';
   $filtro_area_util = isset($_REQUEST['frm_filtro_area_util'])  ? trim($_REQUEST['frm_filtro_area_util'])   : '';
   $filtro_banheiro  = isset($_REQUEST['frm_filtro_banheiro'])   ? trim($_REQUEST['frm_filtro_banheiro'])    : '';
   $filtro_codigo    = isset($_REQUEST['frm_filtro_codigo'])     ? trim($_REQUEST['frm_filtro_codigo'])      : '';

   $tipo_imovel = new Cadastro_Hlp_Tipo();
   $tipo_imovel->obter_tipos( $tipos_de );

   $municipio = new Endereco_Hlp();
   $municipio->obter_municipios($municipios);

   $bairro = new Endereco_Hlp();
   $bairro->obter_bairros($bairros,$id_municipio);

   $imoveis = new Imoveis_Hlp();
   $imoveis->set_pagina_atual($pagina);
   $imoveis->set_id_municipio($id_municipio);
   $imoveis->set_id_tipo_imovel($id_tipo_imovel);
   $imoveis->set_valor_imovel($filtro_preco);
   $imoveis->set_codigo_imovel($filtro_codigo);
   $imoveis->set_qtd_quartos($filtro_quarto);
   $imoveis->set_qtd_vaga($filtro_vaga);
   $imoveis->set_area_util($filtro_area_util);
   $imoveis->set_qtd_banheiro($filtro_banheiro);
   $imoveis->set_nomes_bairros($nomes_bairros);
   $imoveis->obter_imoveis($consulta_imoveis);

   switch ( $comportamento ) {
      case 'mostrar_detalhes':
         header("location: mostrar_detalhes.php?id_imovel={$_REQUEST['frm_id_imovel']}");
         break;
      
      default:
         # code...
         break;
   }

?>



<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Imobiliaria</title>


   <meta http-equiv="content-type" content="text/html;charset=utf-8" />


   <meta name="keywords" content="imobiliaria,imóvel,imóveis,apartamentos,casas,compra,venda,santos, são vicente,"/>
   <meta name="description" content="Escolha seu imóvel na baixada santista.">   
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

   <!--  .css -->
   <link rel="stylesheet" href="./dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="./dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">     
   <link rel="stylesheet" href="./dist/css/estilo.css" >
   <link rel="stylesheet" href="./dist/css/estilo_slick.css" >
   <link rel="stylesheet" href="./dist/fSelect/fSelect.css" >
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="./dist/slick/slick/slick-theme.css"/>  

   <!--  .js -->
   <script src="./dist/js/jquery-3.3.1.min.js"></script>
   <script src="./dist/jquery-ui/jquery-ui.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
   <script src="./dist/bootstrap-4.1/js/bootstrap.min.js"></script>
   <script src="./dist/fSelect/fSelect.js"></script>
   <script src="./dist/jquery_mask/dist/jquery.mask.min.js"></script>
   <script type="text/javascript" src="./dist/slick/slick/slick.min.js"></script>

   <?php montar_js($consulta_imoveis); ?>
   

</head>

    

<body class="fundo_cinza_1">

   <header id="header">

    <style type="text/css">
   
    </style>
    
      <div class="container-fluid div_cabecalho">
      <form id="frmIndex" class="form-horizontal" action="index.php" method="POST" role="form">

         <input type="hidden" id="comportamento" name="comportamento" value = "">
         <input type="hidden" id="frm_id_imovel" name="frm_id_imovel" value = "">
         <input type="hidden" id="frm_pagina" name="frm_pagina" value = "">
         <input type="hidden" id="frm_nomes_bairros" name="frm_nomes_bairros" value ="<?= $nomes_bairros;?>" size="300">
         
         <?php include_once 'cabecalho.php';?>
         
         <div class="row fundo_verde_claro">
            
            <div class="col-md-1">
            </div>
            
            <div class="col-12 col-sm-3 col-md-auto col-lg-3 col-xl-2">
               <label for="frm_filtro_tipo_imovel">Tipo imóvel</label>
               <select class="select_padrao" id='frm_filtro_tipo_imovel' name='frm_filtro_tipo_imovel'  onchange="submeter_form()"  >
                  <option value="">Mostrar todos</option>                  
                  <?php
                  foreach ( $tipos_de as $item ) {?>
                     <option value="<?=$item->id_tipo_imovel?>" <?= $id_tipo_imovel==trim($item->id_tipo_imovel) ? "selected" : '';?> ><?=$item->tipo_imovel?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>                 

            <div class="col-12 col-sm-3 col-md-auto col-lg-3 col-xl-2">
               <label for="frm_filtro_municipio">Município</label>
               <select class="select_padrao" id='frm_filtro_municipio' name='frm_filtro_municipio' onchange="limpar_filtro_bairros();submeter_form()" >
                  <option value="">Mostrar todos</option>
                  <?php
                  foreach ( $municipios as $item ) {?>
                     <option value="<?=$item['id_municipio']?>" <?= $id_municipio==trim($item['id_municipio']) ? "selected" : '';?> ><?=$item['nome_municipio']?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>
           
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-6">

               <div id="div_bairros">
               <?php
               if ($id_municipio) {?>
                  <label for="frm_filtro_bairro">Bairros</label>
                  <select class="form-control form-control-sm" id="frm_filtro_bairro" name="frm_filtro_bairro" multiple="multiple"  style="display:none">
                     <?php
                     foreach ( $bairros as $item ) {
                        $nome_bairro = $item['nome_bairro'];
                        $pos = strpos( $nomes_bairros, $nome_bairro );
                        $selected = ($pos === false) ? '' : "selected";?>
                        <option value="<?=$item['id_bairro']?>" <?= $selected?> > <?= $nome_bairro;?></option>
                     <?php
                     }
                     ?>
                  </select>
               <?php
               }
               ?>
               </div>
            </div>

            <div class="col-md-1">                
            </div>

         </div>

   
         <div class="row fundo_verde_claro">                  
           
            <div class="col-md-1">
            </div>
            
            <div class="col">
               <div class="form-group form-group-inline sm" title="Preço MÁXIMO do imóvel">                  
                  <span>
                     <img class="sem_margem d-inline" src="images/preco.png" border="0" width="18" />                      
                      <label for="frm_filtro_preco">Preço até</label><br>
                   </span>
                  <input type="text" class='form-control-sm mascara_dinheiro' id='frm_filtro_preco' name='frm_filtro_preco' size='12' style="height: 24px;"  placeholder="ilimitado" value="<?=$filtro_preco;?>" />
                </div>
            </div>

            <div class="col" >
               <?php
               $selected0=$filtro_quarto==0 ? "selected" : '';
               $selected1=$filtro_quarto==1 ? "selected" : '';
               $selected2=$filtro_quarto==2 ? "selected" : '';
               $selected3=$filtro_quarto==3 ? "selected" : '';
               $selected4=$filtro_quarto==4 ? "selected" : '';
               ?>
               <div class="form-group form-group-inline sm" title="Quantidade mínima de QUARTOS">                 
                  <img src="images/c2.png" border="0" width="20"   />
                  <label for="frm_filtro_quarto">Quartos</label><br>
                  <select class="select_padrao2" id="frm_filtro_quarto" name="frm_filtro_quarto">
                     <option value="0" <?=$selected0?> >0 ou +</option>
                     <option value="1" <?=$selected1?> >1 ou +</option>
                     <option value="2" <?=$selected2?> >2 ou +</option>
                     <option value="3" <?=$selected3?> >3 ou +</option>                 
                     <option value="4" <?=$selected4?> >4 ou +</option>                 
                  </select>
               </div>
            </div>

            <div class="col" >
               <?php
               $selected0=$filtro_vaga==0 ? "selected" : '';
               $selected1=$filtro_vaga==1 ? "selected" : '';
               $selected2=$filtro_vaga==2 ? "selected" : '';
               $selected3=$filtro_vaga==3 ? "selected" : '';
               $selected4=$filtro_vaga==4 ? "selected" : '';
               ?>
               <div class="form-group form-group-inline sm" title="Quantidade mínima de VAGAS">
                  <img src="images/carro.png" border="0" width="20"  />                 
                  <label for="frm_filtro_vaga">Vagas</label><br>
                  <select class="select_padrao2" id="frm_filtro_vaga" name="frm_filtro_vaga">
                     <option value="0" <?=$selected0?> >0 ou +</option>
                     <option value="1" <?=$selected1?> >1 ou +</option>
                     <option value="2" <?=$selected2?> >2 ou +</option>
                     <option value="3" <?=$selected3?> >3 ou +</option>                 
                     <option value="4" <?=$selected4?> >4 ou +</option>                 
                  </select>
               </div>
            </div>

            <div class="col" >
               <?php
               $selected1=$filtro_banheiro==1 ? "selected" : '';
               $selected2=$filtro_banheiro==2 ? "selected" : '';
               $selected3=$filtro_banheiro==3 ? "selected" : '';
               $selected4=$filtro_banheiro==4 ? "selected" : '';
               ?>
               <div class="form-group form-group-inline sm" title="Quantidade mínima de BANHEIROS">
                  <img src="images/banheiro.png" border="0" width="20" />
                  <label for="frm_filtro_banheiro">Banheiros</label><br>
                  <select class="select_padrao2" id="frm_filtro_banheiro" name="frm_filtro_banheiro">
                     <option value="1" <?=$selected1?> >1 ou +</option>
                     <option value="2" <?=$selected2?> >2 ou +</option>
                     <option value="3" <?=$selected3?> >3 ou +</option>                 
                     <option value="4" <?=$selected4?> >4 ou +</option>                 
                  </select>
               </div>
            </div>

            <div class="col" >
               <?php
               $selected0  =$filtro_area_util==0   ? "selected" : '';
               $selected10 =$filtro_area_util==10  ? "selected" : '';
               $selected20 =$filtro_area_util==20  ? "selected" : '';
               $selected30 =$filtro_area_util==30  ? "selected" : '';
               $selected40 =$filtro_area_util==40  ? "selected" : '';
               $selected50 =$filtro_area_util==50  ? "selected" : '';
               $selected60 =$filtro_area_util==60  ? "selected" : '';
               $selected70 =$filtro_area_util==70  ? "selected" : '';
               $selected80 =$filtro_area_util==80  ? "selected" : '';
               $selected90 =$filtro_area_util==90  ? "selected" : '';
               $selected100=$filtro_area_util==100 ? "selected" : '';
               ?>
               <div class="form-group form-group-inline sm" title="Área do imóvel">                 
                  <img src="images/area_u.png" border="0" width="20"  />                  
                  <label for="frm_filtro_area_util">Área útil</label><br>
                  <select class="select_padrao2" id="frm_filtro_area_util" name="frm_filtro_area_util">
                     <option value="0"   <?=$selected0  ?> >todas</option>
                     <option value="10"  <?=$selected10 ?> >10m² ou +</option>
                     <option value="20"  <?=$selected20 ?> >20m² ou +</option>
                     <option value="30"  <?=$selected30 ?> >30m² ou +</option>
                     <option value="40"  <?=$selected40 ?> >40m² ou +</option>
                     <option value="50"  <?=$selected50 ?> >50m² ou +</option>
                     <option value="60"  <?=$selected60 ?> >60m² ou +</option>
                     <option value="70"  <?=$selected70 ?> >70m² ou +</option>
                     <option value="80"  <?=$selected80 ?> >80m² ou +</option>
                     <option value="90"  <?=$selected90 ?> >90m² ou +</option>
                     <option value="100" <?=$selected100?> >100m² ou +</option>
                  </select>
               </div>
            </div>
                     
            <div class="col-1 d-none d-lg-block destaque_4">
               <label for="frm_filtro_codigo">Código</label><br>
               <input  type="text" class='form-control-sm' id='frm_filtro_codigo' name='frm_filtro_codigo' size='6' style="height: 24px;" value="<?=$filtro_codigo;?>" />
            </div>

            
                                 
            <div class="col text-right">
               <label for="btn_buscar"></label><br>
               <button type="button" class="btn btn_buscar" id='btnBuscar' onclick="submeter_form()">Filtrar</button>
            </div> 

            <div class="col-1">
            </div>                   
            
         </div>
               
         <div class="row fundo_cinza_1">
            <?php
               if ($id_municipio) {
                  $nomes_bairros = $nomes_bairros!='' ? substr($nomes_bairros,0,strlen($nomes_bairros)-1 ) : 'Mostras Todos';
               ?>               
               <div class="col-sm text-center">
                  <span class="d-inline font_azul_p">Bairros selecionados:</span>
                  <div class="d-inline font_verde_m" id='div_mostrar_bairros'><?=$nomes_bairros?></div>
               </div>
            <?php
            }
            ?>  
         </div>      

      </form>
      </div> <!-- container-fluid -->
   </header>  

   <!-- anuncios -->
   <form id="frmIndex" class="form-horizontal" action="index.php" method="POST" role="form">      

   <div class="container" id='div_container'>
       
     
      <div class="row">
         <div class="col-12 altura_linha_1"></div>
      </div>

      <!-- nessa linha - vai coluna 1 da esquerda 
                             coluna 2 da direita imprime os anuncios -->         
      <div class="row">         
         
        <div class="col-lg-3 col-xl-3 d-none d-lg-block">
            <div class="row div_esquerda"> <!-- destaque - aqui publicidade  ***lado esquerdo*** -->                            
               <div class="col-12">               
                 <span class="font_azul_p"><?php Utils::exibir_data_extenso();?></span>
               </div>
            </div>
         </div>


         <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9" >
            
            <div class="row fundo_cinza_1">
               <div class="col-12">
                  <span class="font_azul_p"><?=$imoveis->total_registros ?> imóveis encontrados</span>
               </div>
            </div>

            <?php              
            $i=0;
            foreach ( $consulta_imoveis as $imovel ) {
               $id_imovel      = $imovel->id_imovel;
               $titulo         = $imovel->titulo;
               $nome_municipio = trim($imovel->nome_municipio);
               $descricao      = substr($imovel->descricao,0,120).'.<u>...mais...</u>';
               $imoveis->obter_nomes_imagens( $imagens, $id_imovel );
               ?>              

               <!-- linha: 1-->         
               <div class="row fundo_branco_1">
                  <div class="col-md-auto">
                     <a href="javascript:mostrar_detalhes(<?=$id_imovel?>)"  >
                        <span class="destaque_1">Código:<?=$id_imovel ?></span>
                     </a>  
                  </div>  
                  <div class="col-md-auto">
                     <a href="javascript:mostrar_detalhes(<?=$id_imovel?>)"  >
                        <span class="titulo">- <?=$titulo ?></span>
                     </a>  
                  </div>  
               </div>

               <!-- linha: 2  (fotos+anuncios) -->         
               <div class="row fundo_branco_2" > 
                  
                  <!-- coluna:1  ( fotos do imóvel ) -->
                  <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" style="background-image: url('images/sem_foto.png');background-repeat: no-repeat;" >
                                           
                     <div class="imovel_<?=$id_imovel?> slide" id="div_imovel_<?=$id_imovel?>" style="display:none">
                        <?php                        
                        foreach ( $imagens as $imagem ) {         
                           $caminho="fotos/{$id_imovel}/{$imagem}";?>
                           <div>
                              <a href="javascript:mostrar_detalhes(<?=$id_imovel?>)"  >
                                 <img src="<?=$caminho?>" >
                              </a>                              
                           </div>
                        <?php
                        }
                        ?>
                     </div>                     
                  </div>   

                  <!-- coluna:2 (dados do anúncio) -->
                  
                  <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                     <a href="javascript:mostrar_detalhes(<?=$id_imovel?>)"  >
                     <div class="row">   
                        <div class="col-md-12 text-center">
                           <span class="destaque_3"><?= $imovel->tipo_imovel ?></span>
                        </div>
                     </div>   
                     <div class="row">
                        <div class="col-md-12 text-center">
                           <span class="font_preta_m sem_margem"><?=$nome_municipio .' - '. $imovel->nome_bairro ?></span>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">                     
                           <hr class="hr1">
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-6">
                           <div class="row">
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                  <span class="font_cinza_m"><img width="18px" src="images/carro.png">&nbsp;<?= "{$imovel->qtd_vaga}"?>&nbsp;<?=($imovel->qtd_vaga>1) ? 'vagas':'vaga'?></span>
                              </div>
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                  <span class="font_cinza_m"><img src="images/cama.png">&nbsp;<?= "{$imovel->qtd_quartos}"?>&nbsp;<?=($imovel->qtd_quartos>1) ? 'quartos':'quarto'?></span>
                              </div>                  
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                  <span class="font_cinza_m"><img width="18px" src="images/banheiro.png">&nbsp;<?="{$imovel->qtd_banheiro}"?>&nbsp;<?=($imovel->qtd_banheiro>1) ? 'banheiros':'banheiro'?></span>
                              </div>                  
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                  <span class="font_cinza_m"><img width="18px" src="images/bide.png">&nbsp;<?="{$imovel->qtd_suite}"?>&nbsp;<?=($imovel->qtd_suite>1) ? 'suítes':'suíte'?></span>
                              </div>                  
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                  <span class="font_cinza_m"><img width="18px" src="images/area_u.png"><?= "{$imovel->area_util}m² útil"?></span>
                              </div>              
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                  <span class="font_cinza_m"><img width="18px" src="images/area_t.png"><?= "{$imovel->area_total}m² total"?></span>
                              </div>              
                           </div>
                        </div>
                        <div class="col-lg-5 col-xl-6 d-none d-lg-block">
                           <div class="row sem_margem">
                              <div class="col-12">
                                 <span class="font_cinza_p"><blockquote><?=$descricao ?></blockquote></span>
                              </div>
                           </div>   
                        </div>

                     </div>
                     
                     <div class="row">
                        <div class="col-md-12">                     
                           <hr class="hr1">
                        </div>
                     </div>

                     <div class="row">
                        <div class="col text-left">                     
                           <span class="font_cinza_m p-0 m-0"></span>
                           <span class="destaque_2">R$ <?=number_format($imovel->valor_imovel, 2, ',', '.'); ?></span>&nbsp;&nbsp;
                        </div>   
                     </div>   

                     <div class="row text-center">
                        <div class="col-auto">                     
                           <span class="font_cinza_p sem_margem">IPTU:</span>
                           <span class="font_preta_p sem_margem"><?='R$ '.$imovel->valor_iptu ?></span>                    
                        </div>
                        <div class="col-auto">
                           <span class="font_cinza_p sem_margem">Condomínio</span>
                           <span class="font_preta_p sem_margem"><?='R$ '.$imovel->valor_condominio ?></span><br>
                        </div>                        
                     </div>                     
                     </a>
                  </div>                

               </div>
               
               

               <!-- linha: 3-->  
               <div class="row">
                  <div class="col-md-12 altura_linha_2">
                  </div>   
               </div>

               <!-- anuncios - publicidade  -->
               <?php
               if ($i==3) {?>
                  
                  <div class="row">
                     <div class="col-12 text-center">
                        <img class="img-fluid max-width:5%" src="<?="images/logo.png"?>" alt="<?=$imagem;?>">               
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-12 altura_linha_1">                     
                     </div>   
                  </div>

               <?php
               }
               $i++;   
            }
            ?>  

         </div>
         

      </div>
      <!-- fim dos registros(anuncios) -->


      <div class="row">         
         <div class="col-12">
            <?php Utils::paginador( $imoveis->qtd_paginas, $imoveis->get_pagina_atual() )?> 
         </div>
      </div>
      
   </div> <!-- /container -->

   <footer>
      <div class="row text-center">                  
      </div>
      <div class="row">
         <div class="col-md-12 div_rodape">
            <span class="font_cinza_p">Copyright © 2018 www.imoveisbs.com.br</span>
            <br>
            <span class="font_cinza_p">Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>         
   </footer>

   
</form>


<?php
function montar_js($consulta_imoveis) {
   echo "<script type='text/javascript'> \n";
      echo "window.onload = function(){ \n";   
         //.. lê os registros dos imóveis  
         foreach ( $consulta_imoveis as $imovel ) {
            $id_imovel = $imovel->id_imovel;
            echo "$('.imovel_".$id_imovel."').slick({
                     infinite: true,
                     speed: 500,
                     adaptiveHeight: true,    
                     fade: true,               
                  });\n";

            //.. exibe as imagens
            $id_imovel = $imovel->id_imovel;
            echo "$('#div_imovel_".$id_imovel."').show();\n";
         }

         //.. configura o frm_filtro_bairro
         echo "
               $('#frm_filtro_bairro').fSelect({
                  placeholder: 'Mostrar Todos',
                  numDisplayed:6,
                  overflowText: '{n} selecionados',
                  noResultsText: 'Bairro não encontrado',
                  searchText: 'digite o nome do bairro.',
                  showSearch: true,
               }) ;\n";
         
      echo "}";
    
   echo "</script>";
} // montar_js


?>


<script type="text/javascript">

   $('.mascara_dinheiro').mask('#.##0,00', {reverse: true, maxlength: false});

   function limpar_filtro_bairros() {
      $('#frm_nomes_bairros').val('');
   }


   function submeter_form( pagina = '1') {
      $('#comportamento').val( 'submeter_form' );
      $('#frm_pagina').val( pagina );
      document.forms['frmIndex'].submit();
   }

   function mostrar_detalhes(id) {
      $('#comportamento').val( 'mostrar_detalhes' );
      $('#frm_id_imovel').val( id );
      document.forms['frmIndex'].submit();
   }   

   $( "#frm_filtro_valor_imovel_de" ).blur(function() {
      this.value = parseFloat(this.value).toFixed(2);
   });

   $( document ).ready(function() {      

      //-- alimenta: frm_nomes_bairros e div_bairros     
      $( "#frm_filtro_bairro" ).change( function() {
         var _str = "";         
         var _mostrar_bairros ='';         
         $( "#frm_filtro_bairro option:selected" ).each(function() {
            _str += $(this).text().trim()+", ";
            //_mostrar_bairros += $(this).text().trim()+", ";
         });
         $('#frm_nomes_bairros').val(_str );
         var _tamanho = (_str.length)-2;
         nomes = _str.substr( 0,_tamanho);
         $("#div_mostrar_bairros").text( nomes );      
      });   

   });


</script>   

</body>

</html>
