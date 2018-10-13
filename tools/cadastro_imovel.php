<?php
session_start(); 
if ( !isset($_SESSION['login']) ) {
   session_destroy();
   header("Location:login.php");
}

include_once 'cadastro_hlp_imovel.php';
include_once 'domicilio_hlp.php';
include_once 'cadastro_hlp_tipo.php';
header("Content-Type: text/html; charset=ISO-8859-1",true);


?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
   <title>Imobiliaria</title>

   <meta charset="utf-8">   
   <meta name="keywords" content="imobiliaria,imóvel,imóveis,apartamentos,casas,compra,venda,santos, são vicente,"/>
   <meta name="description" content="Escolha seu imóvel na baixada santista.">   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap styles -->
   <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
   <link href="../dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">
     
     <!-- estilo.css -->  
   <link rel="stylesheet" href="../dist/css/estilo.css" >
   
</head>

<body>

   <header>
      <div class="row div_cabecalho">
         <div class="col-md-1">
         </div>
         <div class="col-md-2">         
            <p style="font-size: 18px">Cadastro de Imóvel</p>
         </div>
         <div class="col-md-2 text-right">            
            <a class="btn btn-outline-success btn_link" href="cadastro_imovel.php?acao=inclusao&comportamento=exibir_formulario&frm_id_imovel=0"><img src="../images/novo.svg"  > Novo</a>
         </div>
         <div class="col-md-1 text-right">            
             <a class="btn btn-outline-success btn_link" href="cadastro_imovel.php?acao=alteracao&comportamento=exibir_listagem"><img src="../images/editar.svg" alt="Alterar" >Alterar</a>            
         </div>         
        <div class="col-md-6 text-right">            
            <a class="btn btn-outline-success btn_link" href="index.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
         </div>
      </div>
   </header>  

   <div class="container">

   <?php
   verificar_acao();
   ?>


   <?php
   function exibir_formulario() {  
      $tipo_imovel = new Cadastro_Hlp_Imovel();
      $tipo_imovel->obter_tipos_imoveis($tipos_imoveis);

      $tipo = $_REQUEST['frm_id_tipo_imovel'];
      $ativo= $_REQUEST['frm_ativo'];

      $checked_lavanderia      = $_REQUEST['frm_lavanderia'     ]=='1' ? 'checked' : '';
      $checked_salao_festa     = $_REQUEST['frm_salao_festa'    ]=='1' ? 'checked' : '';
      $checked_churrasqueira   = $_REQUEST['frm_churrasqueira'  ]=='1' ? 'checked' : '';
      $checked_academia        = $_REQUEST['frm_academia'       ]=='1' ? 'checked' : '';
      $checked_piscina         = $_REQUEST['frm_piscina'        ]=='1' ? 'checked' : '';
      $checked_ar_condicionado = $_REQUEST['frm_ar_condicionado']=='1' ? 'checked' : '';
      $checked_prox_mercado    = $_REQUEST['frm_prox_mercado'   ]=='1' ? 'checked' : '';
      $checked_prox_hospital   = $_REQUEST['frm_prox_hospital'  ]=='1' ? 'checked' : '';
      //$_REQUEST['frm_imovel_cep'] = '02563000';  // teste  teste  teste  teste  teste 

      //print '<pre>';
      print '->'.$_REQUEST['frm_lavanderia'   ].' '.$checked_lavanderia;
      print '->'.$_REQUEST['frm_churrasqueira'   ].' '.$checked_churrasqueira;

      ?>


      <form id="frmCadastroImovel" class="form-horizontal" action="cadastro_imovel.php" method="POST" enctype="multipart/form-data" role="form">

         <div id='div_buscar'></div>

         <input type="hidden" id="comportamento"           name="comportamento"           value = "efetivar">         
         <input type="hidden" id="acao"                    name="acao"                    value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_imovel"           name="frm_id_imovel"           value = "<?=$_REQUEST['frm_id_imovel']?>">
         <input type="hidden" id="frm_id_domicilio_imovel" name="frm_id_domicilio_imovel" value = "<?=$_REQUEST['frm_id_domicilio_imovel']?>">
         
         <div class="row">
            <div class="col-md-12">
               <span class="cor_vermelha"><?=$_REQUEST['frm_modo']?></span>
            </div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_id_tipo_imovel">Tipo</label>
               <select id='frm_id_tipo_imovel' name='frm_id_tipo_imovel' class="form-control form-control-sm" required="required" value="<?=$_REQUEST['frm_id_tipo_imovel']?>">
                  <option value="">Selecione...</option>
                  <?php
                  foreach ( $tipos_imoveis as $item ) {?>
                     <option value="<?=$item->id_tipo_imovel?>" <?= $tipo==$item->id_tipo_imovel ? "selected" : '';?> ><?=$item->tipo_imovel?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>   
            <div class="col-md-8">
               <label for="frm_titulo">Título</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" required  value="<?=$_REQUEST['frm_titulo']?>" />
            </div>
            <div class="col-md-2">
               <label for="frm_titulo">Código do imóvel</label>
               <input type="text" class="form-control form-control-sm" id="frm_codigo" name="frm_codigo" required  value="<?=$_REQUEST['frm_codigo_imovel']?>" readonly />
            </div>
         </div>   

         <div class="row">
            <br>
         </div>
         
         <div class="row">    
            <div class="col-md-12">
               <label for="frm_descricao">Descrição do imóvel</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="5"  ><?=$_REQUEST['frm_descricao']?></textarea>
            </div>
         </div>

         <div class="row">            
            <div class="col-md-12">
               <br>
            </div>
         </div>

         <div class="row border fundo_branco_1 sem_margem">       
            <div class="col-md-12">
               Endereço do imóvel
               <button type="button" class="btn btn_lupa" id='btnBuscarCep'><img src="../images/lupa.svg"></button>
            </div>
            <div class="col-md-2">              
               <label for="frm_imovel_cep">Cep do imóvel</label>               
                <input type="text" class="form-control form-control-sm" id="frm_imovel_cep" name="frm_imovel_cep" value="<?=$_REQUEST['frm_imovel_cep']?>" required="required">
            </div>            
            <div class="col-md-6">
               <label for="frm_imovel_nome_logradouro">Logradouro</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_nome_logradouro" name="frm_imovel_nome_logradouro" value="<?=$_REQUEST['frm_imovel_nome_logradouro']?>" readonly  >
            </div>
            <div class="col-md-4">
               <label for="frm_imovel_nome_bairro">Bairro</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_nome_bairro" name="frm_imovel_nome_bairro" value="<?=$_REQUEST['frm_imovel_nome_bairro']?>" readonly   >
            </div>
            <div class="col-md-3">
               <label for="frm_imovel_nome_municipio">Município</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_nome_municipio" name="frm_imovel_nome_municipio" value="<?=$_REQUEST['frm_imovel_nome_municipio']?>" readonly  >
            </div>
            <div class="col-md-4">
               <label for="frm_imovel_local">Local</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_local" name="frm_imovel_local" value="<?=$_REQUEST['frm_imovel_local']?>" readonly >
            </div>
            <div class="col-md-1">
               <label for="frm_imovel_numero">Número</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_numero" name="frm_imovel_numero" value="<?=$_REQUEST['frm_imovel_numero']?>" required="required" >
            </div>
            <div class="col-md-4">
               <label for="frm_imovel_complemento">Complemento</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_complemento" name="frm_imovel_complemento" value="<?=$_REQUEST['frm_imovel_complemento']?>"  >
               <br>
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_valor_imovel">Valor imóvel (R$)</label>
               <input type="text" class="form-control form-control-sm" id="frm_valor_imovel" name="frm_valor_imovel" value="<?=$_REQUEST['frm_valor_imovel']?>" >                  
            </div>

            <div class="col-md-2">
               <label for="exampleInputName2">Valor Condomínio (R$)</label>
               <input type="text" class="form-control form-control-sm" id="frm_valor_condominio" name="frm_valor_condominio" value="<?=$_REQUEST['frm_valor_condominio']?>" >                  
            </div>
            <div class="col-md-2">
               <label for="frm_iptu">Valor IPTU (R$)</label>
               <input type="text" class="form-control form-control-sm" id="frm_valor_iptu" name="frm_valor_iptu" value="<?=$_REQUEST['frm_valor_iptu']?>">                  
            </div>
            <div class="col-md-2">
               <label for="frm_laudemio">Laudêmio (R$)</label>
               <input type="text" class="form-control form-control-sm" id="frm_valor_laudemio" name="frm_valor_laudemio" value="<?=$_REQUEST['frm_valor_laudemio']?>">
            </div>
            <div class="col-md-1">
               <label for="frm_qtd_quartos">Quartos</label>
               <input type="text" class="form-control form-control-sm" id="frm_qtd_quartos" name="frm_qtd_quartos" value="<?=$_REQUEST['frm_qtd_quartos']?>" >
            </div>               
            <div class="col-md-1">
               <label for="frm_banheiros">Banheiros</label>
               <input type="text" class="form-control form-control-sm" id="frm_qtd_banheiro" name="frm_qtd_banheiro" value="<?=$_REQUEST['frm_qtd_banheiro']?>">
            </div>
            <div class="col-md-1">
               <label for="frm_qtd_vaga">Vagas</label>
               <input type="text" class="form-control form-control-sm" id="frm_qtd_vaga" name="frm_qtd_vaga" value="<?=$_REQUEST['frm_qtd_vaga']?>">                  
            </div>
            <div class="col-md-1">
               <label for="frm_qtd_suite">Suítes</label>
               <input type="text" class="form-control form-control-sm" id="frm_qtd_suite" name="frm_qtd_suite" value="<?=$_REQUEST['frm_qtd_suite']?>">
            </div>
         </div>

         <div class="row">    
            <div class="col-md-1">
               <label for="frm_area">Área útil</label>
               <input type="text" class="form-control form-control-sm" id="frm_area_util" name="frm_area_util" value="<?=$_REQUEST['frm_area_util']?>">
            </div>
            <div class="col-md-1">
               <label for="frm_area">Área total</label>
               <input type="text" class="form-control form-control-sm" id="frm_area_total" name="frm_area_total" value="<?=$_REQUEST['frm_area_total']?>">
            </div>
            <div class="col-md-2">
               <label for="frm_tem_escritura">Tem escritura</label>
               <input type="text" class="form-control form-control-sm" id="frm_tem_escritura" name="frm_tem_escritura" value="<?=$_REQUEST['frm_tem_escritura']?>"  >
            </div>
            <div class="col-md-2">
               <label for="frm_idade_imovel">Idade do Imóvel</label>
               <input type="text" class="form-control form-control-sm" id="frm_idade_imovel" name="frm_idade_imovel" value="<?=$_REQUEST['frm_idade_imovel']?>"  >
            </div>
            <div class="col-md-2">
               <label for="frm_ativo">Ativo</label>               
               <select id='frm_ativo' name='frm_ativo' class="form-control form-control-sm" required="required" value="<?=$_REQUEST['frm_ativo']?>">
                  <option value="S" <?= $ativo=='S' ? "selected" : '';?> >Sim</option>
                  <option value="N" <?= $ativo=='N' ? "selected" : '';?> >Não</option>
               </select>
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row border sem_margem">
            <div class="col-md-12"  >
               <label>- Características:</label>
            </div>   
            <div class="col-auto">
               <input type="checkbox" id="frm_lavanderia"     name="frm_lavanderia" <?=$checked_lavanderia?> /><label for="frm_lavanderia">Lavanderia</label>
            </div>
            <div class="col-auto">
               <input type="checkbox" id="frm_salao_festa"    name="frm_salao_festa" <?=$checked_salao_festa?> /><label for="frm_salao_festa">Salão de festas</label>
            </div>
            <div class="col-auto">
               <input type="checkbox" id="frm_churrasqueira"  name="frm_churrasqueira" <?=$checked_churrasqueira?> /><label for="frm_churrasqueira">Churrasqueira</label>
            </div>
            <div class="col-auto">
               <input type="checkbox" id="frm_academia"       name="frm_academia" <?=$checked_academia?> /><label for="frm_academia">Academia</label>
            </div>
            <div class="col-auto">
               <input type="checkbox" id="frm_piscina"        name="frm_piscina" <?=$checked_piscina?> /><label for="frm_piscina">Piscina</label>
            </div>
            <div class="col-auto">
               <input type="checkbox" id="frm_ar_condicionado" name="frm_ar_condicionado" <?=$checked_ar_condicionado?> /><label for="frm_ar_condicionado">Ar condicionado</label>
            </div>
            <div class="col-auto">
               <input type="checkbox" id="frm_prox_hospital" name="frm_prox_hospital" <?=$checked_prox_hospital?> /><label for="frm_prox_hospital">Próx. a hospitais</label>
            </div>
            <div class="col-auto">
               <input type="checkbox" id="frm_prox_mercado"  name="frm_prox_mercado" <?=$checked_prox_mercado?> /><label for="frm_prox_mercado">Próx. a mercados</label>
            </div>
         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="row">
            <div class="col-md-12"  >
               <label for="frm_proprietario_nome">Nome do proprietário</label>
               <input type="text" class="form-control form-control-sm" id="frm_proprietario_nome" name="frm_proprietario_nome" value="<?=$_REQUEST['frm_proprietario_nome']?>"  >
            </div>
            <div class="col-md-12">
               <label for="frm_proprietario_dados">Dados do Proprietario</label>
               <textarea id='frm_proprietario_dados' name='frm_proprietario_dados' class="form-control form-control-sm" rows="2"  ><?=$_REQUEST['frm_proprietario_dados']?></textarea>
            </div>

         </div>

         <div class="row">
             <div class="col-12 altura_linha_1"></div>
         </div>

         <div class="border border-sucess rounded fundo_branco_2 ">               
            <label for='file-input' class='file_personalizado'>Escolha as Fotos</label>            
            <input id="file-input" type="file"  onchange="upload_fotos()" multiple />
            <div id="div_fotos"></div>              
         </div>

         <div class="text-right">
            <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Salvar">
         </div>
      </form>

   <?php
   } // exibir_formulario
   

   function exibir_formulario_exclusao() {
      $tipo_imovel = new Cadastro_Hlp_Tipo();
      $tipo_imovel->set_id_tipo_imovel( $_REQUEST['frm_id_tipo_imovel'] );
      $tipo_imovel->obter_tipos($tipos);
      $tipo=$tipos[0];

      $ativo       = $_REQUEST['frm_ativo'];
      ?>

      <form id="frmCadastroImovel" class="form-horizontal" action="cadastro_imovel.php" method="POST" enctype="multipart/form-data" role="form">

         <input type="hidden" id="comportamento"           name="comportamento"           value = "efetivar">         
         <input type="hidden" id="acao"                    name="acao"                    value = "<?=$_REQUEST['acao']?>">
         <input type="hidden" id="frm_id_imovel"           name="frm_id_imovel"           value = "<?=$_REQUEST['frm_id_imovel']?>">
         <input type="hidden" id="frm_id_domicilio_imovel" name="frm_id_domicilio_imovel" value = "<?=$_REQUEST['frm_id_domicilio_imovel']?>">
         
         <div class="row">
            <div class="col-md-12">
               <span class="cor_vermelha"><< Exclusão de imóvel >></span>
            </div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_tipo_imovel">Tipo</label>
               <input type="text" class="form-control form-control-sm" id="frm_tipo_imovel" name="frm_tipo_imovel" value="<?=$tipo->tipo_imovel?>" readonly  />
            </div>    
            <div class="col-md-8">
               <label for="frm_titulo">Título</label>
               <input type="text" class="form-control form-control-sm" id="frm_titulo" name="frm_titulo" required  value="<?=$_REQUEST['frm_titulo']?>" readonly />
            </div>

            <div class="col-md-2">
               <label for="frm_titulo">Código do imóvel</label>
               <input type="text" class="form-control form-control-sm" id="frm_codigo" name="frm_codigo" required  value="<?=$_REQUEST['frm_codigo_imovel']?>" readonly />
            </div>
         </div>

         <div class="row">    
            <div class="col-md-12">
               <label for="frm_descricao">Descrição do imóvel</label>
               <textarea id='frm_descricao' name='frm_descricao' class="form-control form-control-sm" rows="6" readonly="readonly" ><?=$_REQUEST['frm_descricao']?></textarea>
            </div>
         </div>

         <div class="row">            
            <div class="col-md-12">
               <br>
            </div>
         </div>

         <div class="row cor_azul">       
            <div class="col-md-12">
               Endereço do imóvel
            </div>
         </div>

         <div class="row border border-sucess">       
            <div class="col-md-2">              
               <label for="frm_cep">Cep do imóvel</label>
                <input type="text" class="form-control form-control-sm" id="frm_cep" name="frm_cep" value="<?=$_REQUEST['frm_imovel_cep']?>" readonly >
            </div>            
            <div class="col-md-6">
               <label for="frm_imovel_nome_logradouro">Logradouro</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_nome_logradouro" name="frm_imovel_nome_logradouro" value="<?=$_REQUEST['frm_imovel_nome_logradouro']?>" readonly  >
            </div>
            <div class="col-md-4">
               <label for="frm_imovel_nome_bairro">Bairro</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_nome_bairro" name="frm_imovel_nome_bairro" value="<?=$_REQUEST['frm_imovel_nome_bairro']?>" readonly  >
            </div>
            <div class="col-md-3">
               <label for="frm_imovel_nome_municipio">Município</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_nome_municipio" name="frm_imovel_nome_municipio" value="<?=$_REQUEST['frm_imovel_nome_municipio']?>" readonly  >
            </div>
            <div class="col-md-4">
               <label for="frm_imovel_local">Local</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_local" name="frm_imovel_local" value="<?=$_REQUEST['frm_imovel_local']?>" readonly >
            </div>
            <div class="col-md-1">
               <label for="frm_imovel_numero">Número</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_numero" name="frm_imovel_numero" value="<?=$_REQUEST['frm_imovel_numero']?>" readonly >
            </div>
            <div class="col-md-4">
               <label for="frm_imovel_complemento">Complemento</label>
               <input type="text" class="form-control form-control-sm" id="frm_imovel_complemento" name="frm_imovel_complemento" value="<?=$_REQUEST['frm_imovel_complemento']?>" readonly >
            </div>
         </div>

         <div class="row">    
            <div class="col-md-12">
               <br>
            </div>
         </div>

         <div class="text-right">
            <input type="submit" name="b1" class="btn btn_excluir" value="Confirma a Exclusão do imóvel: <?=$_REQUEST['frm_codigo_imovel']?>">
         </div>

      </form>

   <?php
   } // exibir_formulario_exclusao

      
   function exibir_listagem() {  
      $municipio = new Endereco_Hlp();
      $municipio->obter_municipios($municipios);
      
      $tipo_imovel = new Cadastro_Hlp_Imovel();
      $tipo_imovel->obter_tipos_imoveis($tipos_imoveis);
            
      $_REQUEST['frm_filtro_tipo_imovel'  ] = isset($_REQUEST['frm_filtro_tipo_imovel'  ]) ? $_REQUEST['frm_filtro_tipo_imovel'  ] : '';
      $_REQUEST['frm_filtro_titulo'       ] = isset($_REQUEST['frm_filtro_titulo'       ]) ? $_REQUEST['frm_filtro_titulo'       ] : '';
      $_REQUEST['frm_filtro_codigo_imovel'] = isset($_REQUEST['frm_filtro_codigo_imovel']) ? $_REQUEST['frm_filtro_codigo_imovel'] : '';
      $_REQUEST['frm_filtro_municipio'    ] = isset($_REQUEST['frm_filtro_municipio'    ]) ? $_REQUEST['frm_filtro_municipio'    ] : '';
      
      $tipo      = isset($_REQUEST['frm_filtro_tipo_imovel']) ? $_REQUEST['frm_filtro_tipo_imovel'] : '';
      $municipio = isset($_REQUEST['frm_filtro_municipio']) ? $_REQUEST['frm_filtro_municipio'] : '';

      ?>
      
      <form id="formulario" class="form-horizontal" action="cadastro_imovel.php" method="POST" enctype="multipart/form-data" role="form">

         <input type="hidden" id="comportamento" name="comportamento" value = "exibir_listagem">
         <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">

               
         <div class="row">
            <div class="col-md-2">
               <label for="frm_filtro_municipio">Município</label>
               <select id='frm_filtro_municipio' name='frm_filtro_municipio' class="form-control form-control-sm" >
                  <option value="">...</option>
                  <?php
                  foreach ( $municipios as $item ) {?>
                     <option value="<?=$item['id_municipio']?>" <?= $municipio==$item['id_municipio'] ? "selected" : '';?> ><?=$item['nome_municipio']?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>
         </div>

         <div class="row">
            <div class="col-md-2">
               <label for="frm_filtro_tipo_imovel">Tipo</label>
               <select id='frm_filtro_tipo_imovel' name='frm_filtro_tipo_imovel' class="form-control form-control-sm" >
                  <option value="">Selecione..</option>
                  <?php
                  foreach ( $tipos_imoveis as $item ) {?>
                     <option value="<?=$item->id_tipo_imovel?>" <?= $tipo==$item->id_tipo_imovel ? "selected" : '';?> ><?=$item->tipo_imovel?></option>
                  <?php
                  }
                  ?>
               </select>
            </div>   
            <div class="col-md-4">
               <label for="frm_titulo">Título</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_titulo" name="frm_filtro_titulo" value="<?=$_REQUEST['frm_filtro_titulo']?>" />
            </div>
            <div class="col-md-2">
               <label for="frm_codigo_imovel">Código imóvel</label>
               <input type="text" class="form-control form-control-sm" id="frm_filtro_codigo_imovel" name="frm_filtro_codigo_imovel" value="<?=$_REQUEST['frm_filtro_codigo_imovel']?>" />
            </div>    
            <div class="col-md-2">
               <br>               
               <input type="submit" id="btnFiltrar" name="btnFiltrar" class="btn btn-success btn_salvar" value="Filtrar">
            </div>
         </div>

         <div class="row">
            <div class="col-md-12"><hr></div>
         </div>

         <div class="row">            
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-2">Tipo</div>            
            <div class="col-md-1">Código</div>
            <div class="col-md-5">Título</div>            
         </div>

         <div class="row">
            <div class="col-md-12"><hr></div>
         </div>

         
         <?php
         if ( isset($_REQUEST['frm_filtro_tipo_imovel']) ) {
            $instancia = new Cadastro_Hlp_Imovel();
            $instancia->set_id_tipo_imovel( $_REQUEST['frm_filtro_tipo_imovel'] );
            $instancia->set_codigo_imovel( $_REQUEST['frm_filtro_codigo_imovel'] );
            $instancia->set_titulo( $_REQUEST['frm_filtro_titulo'] );            
            $instancia->set_id_municipio( $_REQUEST['frm_filtro_municipio'] );
            $instancia->obter_imoveis( $imoveis );
            $i = 0;
            foreach ( $imoveis as $imovel ) { 
               if( $i % 2 == 0 ) {
                  $cor='cor_zebra_1';
                  $i=1;
               } else {
                  $cor='cor_zebra_2';
                  $i = 0;
               }?>
               <div class="row <?= "{$cor}" ?>">
                  <div class="col-md-2">
                     <a class="btn btn-outline-success btn_link2" href="cadastro_imovel.php?acao=alteracao&comportamento=exibir_formulario&frm_id_imovel=<?=$imovel->id_imovel?>"><img src="../images/editar.svg"> Alterar</a>
                  </div>
                  <div class="col-md-2">                  
                     <a class="btn btn-outline-success btn_link2" href="cadastro_imovel.php?acao=exclusao&comportamento=exibir_formulario_exclusao&frm_id_imovel=<?=$imovel->id_imovel?>"><img src="../images/excluir.svg"> Excluir</a>
                  </div>
                  <div class="col-md-2"><?=$imovel->tipo_imovel ?></div>                  
                  <div class="col-md-1"><?=$imovel->codigo_imovel?></div>
                  <div class="col-md-5"><?=$imovel->titulo?></div>                  
               </div>
               
            <?php   
            }
         }         
         ?>        
      </form>
   <?php
   } // exibir_listagem
   ?>

   <?php
   function verificar_acao() {      

      if ( !isset($_REQUEST['acao']) ) {         
         $acao          = '';
         $comportamento = 'exibir_listagem';         
      } else {
         $acao          = $_REQUEST['acao'];
         $comportamento = $_REQUEST['comportamento'];
      }


      if ( $comportamento == 'exibir_formulario' ) {
         if ( $acao=='inclusao' ) {                 
            $_SESSION['dir_tmp'] = 'tmp_'.date('Ymd').'_'.rand();
         } else if ( $acao=='alteracao' ) {         
            $_SESSION['dir_tmp'] = $_REQUEST['frm_id_imovel'];
         }
      }

      //  print '-->'.$_SESSION['dir_tmp'].' '.$comportamento;

      switch ($comportamento) {         
         case 'exibir_formulario':
            igualar_formulario();
            exibir_formulario();
            break;
         
         case 'exibir_formulario_exclusao':
            igualar_formulario();
            exibir_formulario_exclusao();
            break;

         case 'exibir_listagem':
            igualar_formulario();
            exibir_listagem();
            break;

         case 'efetivar':
            efetivar();
            break;

         default:
            die(' vixi...');
            break;
      }

   } // verificar_acao
   
   function igualar_formulario() {

      if ( isset($_REQUEST['frm_id_imovel']) ) {
         $instancia = new Cadastro_Hlp_Imovel();
         $instancia->set_id_imovel( $_REQUEST['frm_id_imovel'] );
         $instancia->obter_imoveis( $imoveis );         
         if ( count($imoveis)>0 ) {
            $imovel = $imoveis[0];
            $domicilio_imovel = new Domicilio_Hlp();
            $domicilio_imovel->obter_domicilio( $domicilio_imovel, $imovel->id_domicilio_imovel );
         }
      }
      
      $_REQUEST['frm_id_tipo_imovel'        ] = !isset($imovel) ? '' : $imovel->id_tipo_imovel;
      $_REQUEST['frm_id_imovel'             ] = !isset($imovel) ? '' : $imovel->id_imovel;
      $_REQUEST['frm_codigo_imovel'         ] = !isset($imovel) ? '' : $imovel->id_imovel;
      $_REQUEST['frm_titulo'                ] = !isset($imovel) ? '' : $imovel->titulo;
      $_REQUEST['frm_descricao'             ] = !isset($imovel) ? '' : $imovel->descricao;
      $_REQUEST['frm_proprietario_nome'     ] = !isset($imovel) ? '' : $imovel->proprietario_nome;
      $_REQUEST['frm_proprietario_dados'    ] = !isset($imovel) ? '' : $imovel->proprietario_dados;
      
      $_REQUEST['frm_id_domicilio_imovel'   ] = !isset($imovel) ? '' : $imovel->id_domicilio_imovel;
      $_REQUEST['frm_imovel_cep'            ] = !isset($imovel) ? '' : $domicilio_imovel->cep;
      $_REQUEST['frm_imovel_nome_logradouro'] = !isset($imovel) ? '' : $domicilio_imovel->nome_logradouro;
      $_REQUEST['frm_imovel_nome_bairro'    ] = !isset($imovel) ? '' : $domicilio_imovel->nome_bairro;
      $_REQUEST['frm_imovel_nome_municipio' ] = !isset($imovel) ? '' : $domicilio_imovel->nome_municipio;
      $_REQUEST['frm_imovel_numero'         ] = !isset($imovel) ? '' : $domicilio_imovel->numero;
      $_REQUEST['frm_imovel_complemento'    ] = !isset($imovel) ? '' : $domicilio_imovel->complemento;
      $_REQUEST['frm_imovel_local'          ] = !isset($imovel) ? '' : $domicilio_imovel->local;

      $_REQUEST['frm_valor_imovel'          ] = !isset($imovel) ? '' : $imovel->valor_imovel;
      $_REQUEST['frm_valor_condominio'      ] = !isset($imovel) ? '' : $imovel->valor_condominio;
      $_REQUEST['frm_valor_iptu'            ] = !isset($imovel) ? '' : $imovel->valor_iptu;
      $_REQUEST['frm_valor_laudemio'        ] = !isset($imovel) ? '' : $imovel->valor_laudemio;
      $_REQUEST['frm_qtd_quartos'           ] = !isset($imovel) ? '' : $imovel->qtd_quartos;
      $_REQUEST['frm_qtd_banheiro'          ] = !isset($imovel) ? '' : $imovel->qtd_banheiro;
      $_REQUEST['frm_qtd_vaga'              ] = !isset($imovel) ? '' : $imovel->qtd_vaga;
      $_REQUEST['frm_qtd_suite'             ] = !isset($imovel) ? '' : $imovel->qtd_suite;
      $_REQUEST['frm_area_util'             ] = !isset($imovel) ? '' : $imovel->area_util;
      $_REQUEST['frm_area_total'            ] = !isset($imovel) ? '' : $imovel->area_total;
      $_REQUEST['frm_tem_escritura'         ] = !isset($imovel) ? '' : $imovel->tem_escritura;
      $_REQUEST['frm_idade_imovel'          ] = !isset($imovel) ? '' : $imovel->idade_imovel;
      $_REQUEST['frm_data_cadastro'         ] = !isset($imovel) ? '' : $imovel->data_cadastro;
      $_REQUEST['frm_ativo'                 ] = !isset($imovel) ? '' : $imovel->ativo;


      // características
//      print_r($imovel);

      $_REQUEST['frm_lavanderia'            ] = !isset($imovel) ? '' : $imovel->lavanderia;
      $_REQUEST['frm_salao_festa'           ] = !isset($imovel) ? '' : $imovel->salao_festa;
      $_REQUEST['frm_churrasqueira'         ] = !isset($imovel) ? '' : $imovel->churrasqueira;
      $_REQUEST['frm_academia'              ] = !isset($imovel) ? '' : $imovel->academia;
      $_REQUEST['frm_piscina'               ] = !isset($imovel) ? '' : $imovel->piscina;
      $_REQUEST['frm_ar_condicionado'       ] = !isset($imovel) ? '' : $imovel->ar_condicionado;
      $_REQUEST['frm_prox_mercado'          ] = !isset($imovel) ? '' : $imovel->prox_mercado;
      $_REQUEST['frm_prox_hospital'         ] = !isset($imovel) ? '' : $imovel->prox_hospital;


      if ( $_REQUEST['acao']=='inclusao' ) {
         $_REQUEST['frm_ativo'] = 'N';
         $_REQUEST['frm_modo'] = '<< Inclusão de Imóvel >>';
      }
      
      if ( $_REQUEST['acao']=='alteracao' ) {
         $_REQUEST['frm_modo'] = '<< Alteração de Imóvel >>';
      }

   } // igualar_formulario
  
   function efetivar() {
      $imovel = new Cadastro_Hlp_Imovel();

      switch ($_REQUEST['acao']) {
         case 'inclusao':
            igualar_objeto($imovel);
            $imovel->incluir();   
            $mens  = "<br>Inclusão realizada com sucesso.<br>";
            $mens .= "Código: {$imovel->get_id_imovel()}";
            print $mens;
            break;
         
         case 'alteracao':
            igualar_objeto($imovel);
            $imovel->set_id_imovel( $_REQUEST['frm_id_imovel'] );      
            $imovel->alterar();
            $mens  = "<br>Alteração realizada com sucesso.<br>";
            $mens .= "Código: {$imovel->get_id_imovel()}";
            print $mens;
            break;
         
         case 'exclusao':
            $imovel->set_id_imovel( $_REQUEST['frm_id_imovel'] );
            $imovel->excluir();
            $mens  = "<br>Exlusão realizada com sucesso.<br>";
            $mens .= "Código: {$imovel->get_id_imovel()}";
            print $mens;
            break;
         
         default:
            # code...
            break;
      }

   } // efetivar
   
   function igualar_objeto( &$imovel ) {      
      $imovel->set_id_tipo_imovel( $_REQUEST['frm_id_tipo_imovel'] );
      $imovel->set_titulo( $_REQUEST['frm_titulo'] );
      $imovel->set_descricao( $_REQUEST['frm_descricao'] );
      $imovel->set_proprietario_nome( $_REQUEST['frm_proprietario_nome'] );
      $imovel->set_proprietario_dados( $_REQUEST['frm_proprietario_dados'] );
      $imovel->set_valor_imovel( $_REQUEST['frm_valor_imovel'] );
      $imovel->set_valor_condominio( $_REQUEST['frm_valor_condominio'] );
      $imovel->set_valor_iptu( $_REQUEST['frm_valor_iptu'] );
      $imovel->set_valor_laudemio( $_REQUEST['frm_valor_laudemio'] );
      $imovel->set_qtd_quartos( $_REQUEST['frm_qtd_quartos'] );
      $imovel->set_qtd_banheiro( $_REQUEST['frm_qtd_banheiro'] );
      $imovel->set_qtd_vaga( $_REQUEST['frm_qtd_vaga'] );
      $imovel->set_qtd_suite( $_REQUEST['frm_qtd_suite'] );
      $imovel->set_area_util( $_REQUEST['frm_area_util'] );
      $imovel->set_area_total( $_REQUEST['frm_area_total'] );
      $imovel->set_tem_escritura( $_REQUEST['frm_tem_escritura'] );
      $imovel->set_idade_imovel( $_REQUEST['frm_idade_imovel'] );      
      $imovel->set_ativo( $_REQUEST['frm_ativo'] );

      $imovel->set_id_domicilio_imovel( $_REQUEST['frm_id_domicilio_imovel'] );

      $imovel->set_imovel_cep( $_REQUEST['frm_imovel_cep'] );
      $imovel->set_imovel_numero( $_REQUEST['frm_imovel_numero'] );
      $imovel->set_imovel_complemento( $_REQUEST['frm_imovel_complemento'] );

      //.. caracteristicas
      $lavanderia    = isset($_REQUEST['frm_lavanderia'])    ? '1' : '0';
      $salao_festa   = isset($_REQUEST['frm_salao_festa'])   ? '1' : '0';
      $churrasqueira = isset($_REQUEST['frm_churrasqueira']) ? '1' : '0';
      $academia      = isset($_REQUEST['frm_academia'])      ? '1' : '0';
      $piscina       = isset($_REQUEST['frm_piscina'])       ? '1' : '0';
      $ar_condicionado = isset($_REQUEST['frm_ar_condicionado']) ? '1' : '0';
      $prox_mercado  = isset($_REQUEST['frm_prox_mercado'])  ? '1' : '0';
      $prox_hospital = isset($_REQUEST['frm_prox_hospital']) ? '1' : '0';

      $imovel->set_lavanderia(    $lavanderia    );
      $imovel->set_salao_festa(   $salao_festa   );
      $imovel->set_churrasqueira( $churrasqueira );
      $imovel->set_academia(      $academia      );
      $imovel->set_piscina(       $piscina       );
      $imovel->set_ar_condicionado( $ar_condicionado );
      $imovel->set_prox_mercado(  $prox_mercado  );
      $imovel->set_prox_hospital( $prox_hospital );

   } // igualar_objeto
   ?>


  

   </div> <!-- container -->

   <footer>
      <div class="row">
         <div class="col-md-12 div_rodape">
            <br>
            <span class="font_cinza_p">Copyright © 2018 www,imobiliaria.com Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>         
   </footer>

   <!--  -->
   <script src="../dist/js/load-image/load-image.all.min.js"></script>
   <script src="../dist/js/jquery-3.3.1.min.js"></script>
   <script src="../dist/bootstrap-4.1/js/bootstrap.js"></script>
   <script src="../dist//jquery-ui/jquery-ui.min.js"></script>
   <script src="../dist/js/upload.js"></script>
   <script src="../dist/js/cadastro_imovel.js"></script>

   


</body>

</html>
