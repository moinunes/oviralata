<?php
if(!isset($_SESSION)) {
   session_start();
}

include_once 'utils.php';
include_once 'cad_usuario_hlp.php';
include_once 'enviar_email_hlp.php';   

if ( $_REQUEST['acao']=='alteracao' ) {
   if ( $_REQUEST['comportamento'] != 'exibir_formulario_validar_email' &&  $_REQUEST['comportamento'] != 'efetivar' ) {
      Utils::validar_login();
   }
}

verificar_acao();
     
  
function exibir_formulario_inclusao() {
   $id_usuario = $_REQUEST['id_usuario'];
   
   if ( $id_usuario !='' ) {
      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($_REQUEST['frm_id_usuario']);
      $usuario->obter_dados_usuario( $dados_usuario );
   }
   
   $_REQUEST['frm_nome_completo'] = !isset($_REQUEST['frm_nome_completo']) ? '' : $_REQUEST['frm_nome_completo'];
   $_REQUEST['frm_email'        ] = !isset($_REQUEST['frm_email'        ]) ? '' : $_REQUEST['frm_email'        ];
   $_REQUEST['frm_senha'        ] = !isset($_REQUEST['frm_senha'        ]) ? '' : $_REQUEST['frm_senha'        ];
   $_REQUEST['frm_senha_r'      ] = !isset($_REQUEST['frm_senha_r'      ]) ? '' : $_REQUEST['frm_senha_r'      ];      
   
   exibir_html_inicial();

   ?>
  
   <form id="frmCadUsuario" name="frmCadUsuario" class="form-horizontal" action="cad_usuario.php" method="post" role="form" onsubmit="Javascript:return validar_submit_inclusao()" >
      <div id='div_buscar'></div>         

      <input type="hidden" id="comportamento" name="comportamento" value = "efetivar">         
      <input type="hidden" id="acao"          name="acao"          value = "inclusao">
      <input type="hidden" id="id_usuario"    name="id_usuario"    value = "<?=$id_usuario?>"> 
      
      <div class="form-group">
         <div class="col-md-6 offset-md-3 text-center">
             <div class="col-12 altura_linha_1"></div>
      </div>
      
      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3 text-center">
            <img src="../images/logo.png" >
         </div>
      </div>

      <div class="form-group fundo_laranja_1">
         <div class="col-md-6 offset-md-3 text-center">
             <span class="font_cinza_g">Cadastre-se com seu E-mail e senha<br></span>
         </div>
      </div>
   
     <div class="form-group">
         <div class="col-md-6 offset-md-3 text-center">
             <div class="text small">
                  Obs: Após clicar em Enviar, você receberá um e-mail para confirmar a sua Conta.
                  Isso é necessário para que outra pessoa <strong>não utilize o seu e-mail.</strong>
             </div>
         </div>
      </div>
   
     
      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_nome_completo">Nome*</label>
            <input type="text" class="form-control form-control-sm" id="frm_nome_completo" name="frm_nome_completo" required maxlength="70" placeholder='seu nome completo' value="<?=$_REQUEST['frm_nome_completo']?>" />
         </div>
      </div>
      
      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_email">E-mail*</label>
            <input type="email" class="form-control form-control-sm" id="frm_email" name="frm_email" required  maxlength="70" placeholder='seu e-mail' value="<?=$_REQUEST['frm_email']?>" />
         </div>
      </div>

      
      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_senha">Senha*</label>               
            <input type="password" class="form-control form-control-sm" id="frm_senha" name="frm_senha" required   placeholder='Senha (mínimo 6 caracteres)'  value="<?=$_REQUEST['frm_senha']?>"  />
         </div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <label for="frm_senha_r">Confirmar senha*</label>               
            <input type="password" class="form-control form-control-sm" id="frm_senha_r" name="frm_senha_r" required  placeholder='confirme a senha'  value="<?=$_REQUEST['frm_senha_r']?>"   />
         </div>
      </div>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3">               
            <div id='div_mens_inclusao' class="font_vermelha_m"></div>              
         </div>
      </div>

      <div class="form-group">
         <div class="col-md-6 offset-md-3 text-center">               
            <input type="submit" name="btnCadastrar" class="btn btn-success" value="Enviar">
         </div>
      </div>
  
      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <br>
            <a class="link_a" href="cad_esqueceu_senha.php?acao=alteracao&comportamento=exibir_formulario&modo=&frm_email=" role="button">Lembrar minha senha</a>
         </div>         
      </div>
      
      <div class="form-group">
         <div class="col-md-6 offset-md-3">
            <a class="link_a" href="../index.php" role="button">Início</a>
         </div>         
      </div>
      
   </form>   

<?php
exibir_html_final();
} // exibir_formulario_inclusao

/*
 * chamado a partir da caixa de email do usuário(anunciante) para ativar a conta
 */
function exibir_formulario_validar_email() {
   $codigo_ativacao = $_REQUEST['codigo_ativacao'];
   //..
   $usuario = new Cad_Usuario_Hlp();
   $usuario->set_codigo_ativacao($codigo_ativacao);
   $usuario->obter_dados_usuario( $consulta_usuario );
   //..
   $usuario->ativar_usuario($consulta_usuario->id_usuario);
   //..
   exibir_formulario_alteracao($consulta_usuario->id_usuario);

} //  exibir_formulario_validar_email

function exibir_formulario_alteracao($id_usuario=null) {      
   exibir_html_inicial();
 
   if ( trim($id_usuario)=='' ) {
      $id_usuario = $_SESSION['id_usuario'];  
   }

   $usuario = new Cad_Usuario_Hlp();
   $usuario->set_id_usuario($id_usuario);
   $usuario->set_ativo('S');
   $usuario->obter_dados_usuario( $dados_usuario );

   $_SESSION['id_usuario'] = $dados_usuario->id_usuario;

   $mens = '';
   if ( $dados_usuario->id_logradouro == '' ) {
      include_once 'cad_cabecalho_1.php';
      $mens = " Olá, {$dados_usuario->nome_completo}<br>";
      $mens.= "por favor termine de preencher o seu cadastro.<br><br>";
         
   } else {
      include_once 'cad_cabecalho_1.php';   
   }

   $_REQUEST['frm_id_usuario'      ] = !isset( $dados_usuario ) ? '' : $dados_usuario->id_usuario;
   $_REQUEST['frm_nome_completo'   ] = !isset( $dados_usuario ) ? '' : $dados_usuario->nome_completo;
   $_REQUEST['frm_apelido'         ] = !isset( $dados_usuario ) ? '' : $dados_usuario->apelido;
   $_REQUEST['frm_sexo'            ] = !isset( $dados_usuario ) ? '' : $dados_usuario->sexo;
   $_REQUEST['frm_email'           ] = !isset( $dados_usuario ) ? '' : $dados_usuario->email;
   
   $_REQUEST['frm_ddd_celular'     ] = !isset( $dados_usuario ) ? '' : $dados_usuario->ddd_celular;  
   $_REQUEST['frm_ddd_whatzapp'    ] = !isset( $dados_usuario ) ? '' : $dados_usuario->ddd_whatzapp;  
   $_REQUEST['frm_ddd_fixo'        ] = !isset( $dados_usuario ) ? '' : $dados_usuario->ddd_fixo;  
   
   $_REQUEST['frm_tel_celular'     ] = !isset( $dados_usuario ) ? '' : $dados_usuario->tel_celular;     
   $_REQUEST['frm_tel_whatzapp'    ] = !isset( $dados_usuario ) ? '' : $dados_usuario->tel_whatzapp;      
   $_REQUEST['frm_tel_fixo'        ] = !isset( $dados_usuario ) ? '' : $dados_usuario->tel_fixo;      
   
   $_REQUEST['frm_id_logradouro'   ] = !isset( $dados_usuario ) ? '' : $dados_usuario->id_logradouro;      
   $_REQUEST['frm_ativo'           ] = !isset( $dados_usuario ) ? '' : $dados_usuario->ativo;      
   $_REQUEST['frm_data_cadastro'   ] = !isset( $dados_usuario ) ? '' : $dados_usuario->data_cadastro;
   $_REQUEST['frm_cep'             ] = !isset( $dados_usuario ) ? '' : $dados_usuario->cep;
   $_REQUEST['frm_endereco'        ] = !isset( $dados_usuario ) ? '' : $dados_usuario->endereco;
   $_REQUEST['frm_exibir_tea'      ] = !isset( $dados_usuario ) ? '' : $dados_usuario->exibir_tea;

   $sexo        = $_REQUEST['frm_sexo'];

   $exibir_tea  = $_REQUEST['frm_exibir_tea' ] !='' ? $_REQUEST['frm_exibir_tea' ] : 'A';


   ?>
  
   <form id="frmCadUsuario" name="frmCadUsuario" class="form-horizontal" action="cad_usuario.php" method="post" role="form" onsubmit="return validar_submit_alteracao();" >

      <div id='div_buscar'></div>         

      <input type="hidden" id="comportamento"     name="comportamento"     value = "efetivar">         
      <input type="hidden" id="acao"              name="acao"              value = "<?=$_REQUEST['acao']?>">
      <input type="hidden" id="frm_id_logradouro" name="frm_id_logradouro" value = "<?=$_REQUEST['frm_id_logradouro']?>">
      <input type="hidden" id="frm_id_usuario"    name="frm_id_usuario"    value = "<?=$id_usuario?>">         
      
      <?php    
      if ( $dados_usuario->id_logradouro == '' ) {?>
         <input type="hidden" id="frm_enviar_email_cadastro"    name="frm_enviar_email_cadastro" value = "S">
      <?php
      } else {?>
         <input type="hidden" id="frm_enviar_email_cadastro"    name="frm_enviar_email_cadastro" value = "N">
      <?php
      }?>
      
      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      

      <?php
      if ( $mens ) {?>
      <div class="row">
         <div class="col-md-8">
             <span class="font_verde_g"><?=$mens?></span>
         </div>
      </div>
      <?php
      }?>         

     <div class="row  margem_1">
         <div class="col-12 text-center">
             <span class="font_verde_g"><<< Meu cadastro >>></span>
         </div>
      </div>
   
      
      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row">           
         <div class="col-12">
            <label for="frm_nome_completo">Nome completo*</label>
            <input type="text" class="form-control form-control-sm" id="frm_nome_completo" name="frm_nome_completo" required  value="<?=$_REQUEST['frm_nome_completo']?>" maxlength="70"  />
         </div>
      </div>

      <div class="row fundo_branco">           
         <div class="col-md-12">
            <label for="frm_apelido">Apelido*</label>
            <input type="text" class="form-control form-control-sm" id="frm_apelido" name="frm_apelido"  value="<?=$_REQUEST['frm_apelido']?>" maxlength="20" placeholder='digite seu nome ou apelido' />
         </div>
      </div>

      <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row">           
         <div class="col-md-12">
            <label for="frm_email">E-mail*</label>
            <input type="text" class="form-control form-control-sm" id="frm_email" name="frm_email" value="<?=$_REQUEST['frm_email']?>"  disabled maxlength="70"  />
         </div>
      </div>

       <div class="row">
          <div class="col-12 altura_linha_1"></div>
      </div>

      <div class="row shadow p-1 mb-1 bg-white rounded" id='div_telefones'>
         <div class="col-12">
            <label for="frm_sexo">Sexo*</label><br>
            <input type="radio" id="frm_sexo_m" name="frm_sexo" value="M" <?php if($sexo=='M'){echo 'checked';}?> /><span class="text">&nbsp;Masc.</span>
            <input type="radio" id="frm_sexo_f" name="frm_sexo" value="F" <?php if($sexo=='F'){echo 'checked';}?> /><span class="text">&nbsp;Fem.</span>
         </div>               
      </div>

      
      <div class="row shadow p-1 mb-1 bg-white rounded" id='div_telefones'>
         <div class="col-12">         
            <div class="row">    
               <div class="col-md-2"> 
                  <label for="frm_cep">Cep*</label>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <a class="link_a font_azul_p" href="#" id='btnBuscarCep' role="button">Não sei o cep</a>
                  <input type="text" class="form-control form-control-sm" id="frm_cep" name="frm_cep" value="<?=$_REQUEST['frm_cep']?>" required="required" data-mask="00000-000">
               </div>
            </div>
            <div class="row">    
               <div class="col-12"> 
                  <div id='div_endereco' class="tit_1"><?=$_REQUEST['frm_endereco']?></div>
               </div>
            </div>
         </div>
      </div>

      <div class="row shadow p-1 mb-1 bg-white rounded" id='div_telefones'>
         <div class="col-12">         
            <div class="row">
                <div class="col-12">
                  <span class="text-muted">Telefones*</span>
               </div>
            </div>
            <div class="row">           
               <div class="col-1">
                  <img src="../images/cel.png" alt="oViraLata - Site de anúncios de Doação PET - Mude sua vida adote um pet.">
               </div>
               <div class="col-3">
                  <input type="text" class="form-control form-control-sm" id="frm_ddd_celular" name="frm_ddd_celular" value="<?=$_REQUEST['frm_ddd_celular']?>" data-mask="00" placeholder='ddd' />
               </div> 
               <div class="col-7">
                  <input type="text" class="form-control form-control-sm" id="frm_tel_celular" name="frm_tel_celular" value="<?=$_REQUEST['frm_tel_celular']?>" data-mask="00000-0000" placeholder='celular' />
               </div>         
            </div>
            <div class="row"><div class="col-12 altura_linha_1"></div></div>
            <div class="row">           
               <div class="col-1">
                  <img src="../images/whatsapp.png" alt="oViraLata - Site de anúncios de Doação PET - Mude sua vida adote um pet.">
               </div>
               <div class="col-3">
                  <input type="text" class="form-control form-control-sm" id="frm_ddd_whatzapp" name="frm_ddd_whatzapp" value="<?=$_REQUEST['frm_ddd_whatzapp']?>" data-mask="00" placeholder='ddd' />
               </div>
               <div class="col-7">
                  <input type="text" class="form-control form-control-sm" id="frm_tel_whatzapp" name="frm_tel_whatzapp" value="<?=$_REQUEST['frm_tel_whatzapp']?>" data-mask="00000-0000" placeholder='WhatzApp' />
               </div>         
            </div>         
            <div class="row"><div class="col-12 altura_linha_1"></div></div>  
            <div class="row">           
               <div class="col-1">
                  <img src="../images/fixo.png" alt="oViraLata - Site de anúncios de Doação PET - Mude sua vida adote um pet.">
               </div>
               <div class="col-3">
                  <input type="text" class="form-control form-control-sm" id="frm_ddd_fixo" name="frm_ddd_fixo" value="<?=$_REQUEST['frm_ddd_fixo']?>" data-mask="00" placeholder='ddd' />
               </div>
               <div class="col-7">
                  <input type="text" class="form-control form-control-sm" id="frm_tel_fixo" name="frm_tel_fixo" value="<?=$_REQUEST['frm_tel_fixo']?>" data-mask="0000-0000"  placeholder='fixo' />
               </div>         
            </div>
         </div>         
      </div>

      <div class="row shadow p-1 mb-1 bg-white rounded" id='div_telefones'>
         <div class="col-12 fundo_verde_claro">         
            <span class='text'>O que deseja exibir no anúncio?<br></span>
         </div>
         <div class="col-12">
            <input type="radio" id="frm_exibir_tea" name="frm_exibir_tea" value="T" <?php if($exibir_tea=='T'){echo 'checked';}?> /><span class="tit_0">&nbsp;Telefones&nbsp;&nbsp;&nbsp;</span>
            <input type="radio" id="frm_exibir_tea" name="frm_exibir_tea" value="E" <?php if($exibir_tea=='E'){echo 'checked';}?> /><span class="tit_0">&nbsp;E-mail<br></span>
            <input type="radio" id="frm_exibir_tea" name="frm_exibir_tea" value="A" <?php if($exibir_tea=='A'){echo 'checked';}?> /><span class="tit_1">&nbsp;Telefones e E-mail</span>
         </div>         
      </div>

      <div class="row">
         <div class="col-12 margem_1">               
            <div id='div_mens_alteracao' class="alert alert-danger"></div>              
         </div>
      </div>

      <div class="row margem_1">
         <div class="col-12 text-center">
            <input type="submit" name="btnSalvarAnuncio" class="btn btn_inserir_anuncio" value="Salvar">
         </div>
      </div>

   </form>  

<?php
exibir_html_final();
} // exibir_formulario_alteracao
      

function exibir_formulario_exclusao() {
   include_once 'cad_cabecalho_1.php';
   include_once 'cad_cabecalho_2.php';
       
   exibir_html_inicial();    
   ?>

   <form id="frmCadUsuarioExclusao" name="frmCadUsuarioExclusao" class="form-horizontal" action="cad_anuncio.php" method="POST" enctype="multipart/form-data" role="form">

      <input type="hidden" id="comportamento"  name="comportamento"   value = "efetivar">         
      <input type="hidden" id="acao"           name="acao"            value = "<?=$_REQUEST['acao']?>">
      <input type="hidden" id="frm_id_anuncio" name="frm_id_anuncio"  value = "<?=$_REQUEST['frm_id_anuncio']?>">
      
      <div class="row">
         <div class="col-md-12">               
            <span class="font_cinza_p"><< Exclusão de imóvel >></span>
         </div>
      </div>

      <div class="row">
         <div class="col-md-2">
            <label for="frm_tipo_anuncio">Tipo</label>
            <input type="text" class="form-control form-control-sm" id="frm_tipo_anuncio" name="frm_tipo_anuncio" value="<?=$tipo->tipo_anuncio?>" readonly  />
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

      <div class="row">       
         <div class="col-md-2">              
            <label for="frm_cep">Cep do imóvel</label>
             <input type="text" class="form-control form-control-sm" id="frm_cep" name="frm_cep" value="<?=$_REQUEST['frm_imovel_cep']?>" data-mask="00000-000" >
         </div>            
         <div class="col-md-6">
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
exibir_html_final();
} // exibir_formulario_exclusao

   
function verificar_acao() {      
   $acao          = !isset($_REQUEST['acao'])          ? '' :$_REQUEST['acao'];
   $comportamento = !isset($_REQUEST['comportamento']) ? '' :$_REQUEST['comportamento'];

   switch ($comportamento) {    
      
      case 'exibir_formulario_inclusao':
         exibir_formulario_inclusao();
         break;
      
      case 'exibir_formulario_alteracao':           
         exibir_formulario_alteracao();
         break;
      
      case 'exibir_formulario_exclusao':
         exibir_formulario_exclusao();
         break;

      case 'exibir_formulario_validar_email':
         exibir_formulario_validar_email();
         break;

      case 'efetivar':
         efetivar();
         break;

      default:
         die(' vixi...');
         break;
   }

} // verificar_acao


function exibir_formulario_efetivar_alteracao() {
   

      exibir_html_inicial();
      include_once 'cad_cabecalho_1.php';
      $link = '<a href="index.php"><ins>publicar</ins><a/>'
      ?>
      <br>
      
      <div class="row">
         <div class="col-12">
            <span class="text">Olá <?="{$_SESSION['apelido']},"?><br></span>
            <span class="text">O seu cadastro foi preenchido com sucesso!<br><br></span>
            <span class="text">Agora você já pode <?=$link?> seus Anúncios!</span>
            <br><br>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12 altura_linha_2">
            <br><br><br>
         </div>   
      </div>

      <?php
      exibir_html_final();      
      include_once 'rodape_cadastro.php';

      if ( $_REQUEST['frm_enviar_email_cadastro'] == 'S' ) {
         $id_usuario = $_REQUEST['frm_id_usuario'];
         
         $usuario = new Cad_Usuario_Hlp();
         $usuario->set_id_usuario($id_usuario);
         $usuario->obter_dados_usuario( $consulta_usuario );

         $href = "https://oviralata.com.br";
         
         $link  = "<a href='".$href."'>";
         $link .= "Acessar o site oViraLata.";
         $link .= "</a>"; 

         $assunto  = 'Obrigado por se cadastrar no site oViraLata';

         $mensagem = "<br>";
         $mensagem = "<img src='cid:logo' alt='logo' />";
         $mensagem .= "<br>";
         $mensagem .= " Olá, {$consulta_usuario->nome_completo}<br>";
         $mensagem .= " Obrigado por se cadastrar no site oViraLata.";
         $mensagem .= "<br>";
         $mensagem .= " Agora você já pode Publicar seus Anúncios no site!";
         $mensagem .= "<br><br>";
         $mensagem .= $link;
         $mensagem .= " <br><br>";
         $mensagem .= " Atenciosamente,<br>";
         $mensagem .= " oViraLata <br>";

         $email = new Enviar_Email_Hlp();
         $email->email_responder_para = 'contato@oviralata.com.br';
         $email->nome_responder_para  = 'oViraLata';
         $email->email_destinatario   = $consulta_usuario->email;
         $email->nome_destinatario    = $consulta_usuario->apelido;
         $email->assunto              = trim($assunto);
         $email->mensagem             = trim($mensagem);
         $email->enviar_email();

         $sucesso = $email->enviado;
      }

} // exibir_formulario_efetivar_alteracao

function exibir_formulario_efetivar_inclusao() { 
   $id_usuario = $_REQUEST['id_usuario'];

   $usuario = new Cad_Usuario_Hlp();
   $usuario->set_id_usuario($id_usuario);
   $usuario->set_ativo('N');
   $usuario->obter_dados_usuario( $usuario );

   $href = "https://oviralata.com.br/cadastro/cad_usuario.php?acao=alteracao&comportamento=exibir_formulario_validar_email&codigo_ativacao=".$usuario->codigo_ativacao;
   
   $link  = "<a href='".$href."'>";
   $link .= "Validar a conta e concluir o cadastro.";
   $link .= "</a>"; 

   $assunto  = 'Por favor valide sua conta no site oViraLata';

   $mensagem = "<br>";
   $mensagem = "<img src='cid:logo' alt='logo' /><br>";
   $mensagem .= "Portal de anúncios PET<br>";
   $mensagem .= "Amor e respeito aos Animais!";
   $mensagem .= "<br><br>";
   $mensagem .= " Olá, {$usuario->nome_completo}<br>";
   $mensagem .= " Por favor, acesse o link abaixo para validar a sua conta.";
   $mensagem .= " <br><br>";
   $mensagem .= $link;
   $mensagem .= " <br><br>";
   $mensagem .= " Atenciosamente,<br>";
   $mensagem .= " oViraLata <br>";

   $email = new Enviar_Email_Hlp();
   $email->email_responder_para = 'contato@oviralata.com.br';
   $email->nome_responder_para  = 'oViraLata';
   $email->email_destinatario   = $usuario->email;
   $email->nome_destinatario    = $usuario->apelido;
   $email->assunto              = trim($assunto);
   $email->mensagem             = trim($mensagem);
   $email->enviar_email();

   $sucesso = $email->enviado;

   $mens  = "</br>";
   $mens .= " Olá, {$usuario->nome_completo}<br>";
   $mens .= " Seu cadastro foi realizado com sucesso! <br>";
   $mens .="  Dentro de minutos você receberá um e-mail com instruções para confirmação.<br>";

   $mens .= " É só verificar o seu e-mail ";
   $mens .= " e clicar no link de confirmação. <br>";
   
   exibir_html_inicial();
   ?>

 <form id="frmCadUsuarioOk" name="frmCadUsuarioOk" class="form-horizontal" action="" method="POST" enctype="multipart/form-data" role="form">

   <div class="form-group">
      <div class="col-md-6 offset-md-3 text-center">
         <br>
         <a href='../index.php'><img src="../images/logo.png" ></a>
         <span class="font_verde_g"> oViraLata!<br></span>
      </div>
   </div>
   <div class="row">            
      <div class="col-12 altura_linha_1"></div>
   </div>

   <div class="form-group fundo_laranja_1">
      <div class="col-md-6 offset-md-3">
         <span class="font_cinza_m"><?=$mens;?></span>
         <span class="font_cinza_p">
            <br>Obs: Se você não encontrou o e-mail na caixa de entrada, verifique a pasta spam ou lixo eletrônico.
         </span>         
         <br><br>               
      </div>            
   </div>         

  <div class="form-group">
      <div class="col-md-6 offset-md-3 text-center">
         <a class="link_a" href="../index.php" role="button">Início</a>
      </div>         
   </div>

   
   <div class="row text-center">
      <div class="col-12 altura_linha_2"></div>
      <div class="col-12 altura_linha_2"></div>
   </div> 
   <!-- depois do rodapé -->
   <div class="row">
      <div class="col-12 text-center" style="border-color: #f3f9f0;" >
       <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-2582645504069233",
    enable_page_level_ads: true
  });
</script>   
      </div>
   </div>

   <div class="form-group">
      <div class="col-md-6 offset-md-3">
         <br>
      </div>         
   </div>

   
</form>
<?php 
include_once 'rodape_cadastro.php';
   
} // exibir_formulario_efetivar_inclusao
      
function efetivar() {
   $usuario = new Cad_Usuario_Hlp();

   switch ($_REQUEST['acao']) {
      case 'inclusao':
         igualar_objeto($usuario);
         $usuario->incluir();
         exibir_formulario_efetivar_inclusao();
         break;
      
      case 'alteracao':
         igualar_objeto($usuario);
         $usuario->alterar();
         exibir_formulario_efetivar_alteracao();
         break;
      
      case 'exclusao':
         $usuario->set_id_anuncio( $_REQUEST['frm_id_anuncio'] );
         $usuario->excluir();
         $mens ='<br>';
         $mens .= "O Imóvel de Código: {$anuncio->get_id_anuncio()} foi Excluído com sucesso.";
         print $mens;
         break;
      
      default:
         # code...
         break;            
   }
} // efetivar
   
function exibir_html_inicial() {?>
   <!DOCTYPE HTML>
      <html lang="pt-br">
      <head>
         <?php Utils::meta_tag() ?>

         <!-- Bootstrap styles -->
         <link rel="stylesheet" href="../dist/bootstrap-4.1/css/bootstrap.min.css">
         <link href="../dist/jquery-ui/jquery-ui.min.css" rel="stylesheet">
           
           <!-- estilo.css -->  
         <link rel="stylesheet" href="../dist/css/estilo.css" >
         <link rel="stylesheet" href="../dist/fonts/fonts.css" >
         
      </head>

      <body class="fundo_branco_1">

      <div class="container">
<?php 
} // html_inicial

function exibir_html_final() {?>
   </div> <!-- container -->

   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <br>
            <br>
            <br><br>
         </div>            
      </div>
   
      <!-- rodapé  -->
      <?php 
      include_once 'rodape_cadastro.php';?>

   </div> <!-- container -->

   
   </body>
   </html>
<?php 
} // exibir_html_final

function igualar_objeto( &$usuario ) {
   if ( $_REQUEST['acao'] == 'inclusao' ) {
      $usuario->set_nome_completo( $_REQUEST['frm_nome_completo'] );  
      $usuario->set_email( $_REQUEST['frm_email'] );  
      $usuario->set_senha( $_REQUEST['frm_senha'] ); 
      $usuario->set_senha_r( $_REQUEST['frm_senha_r'] );  
    
   } else if ( $_REQUEST['acao'] == 'alteracao' ) {
      $usuario->set_id_usuario( $_REQUEST['frm_id_usuario'] );      
      $usuario->set_nome_completo( $_REQUEST['frm_nome_completo'] );  
      $usuario->set_apelido( $_REQUEST['frm_apelido'] );  
      $usuario->set_sexo( $_REQUEST['frm_sexo'] );  
      
      $usuario->set_ddd_celular( $_REQUEST['frm_ddd_celular'] );   
      $usuario->set_ddd_whatzapp( $_REQUEST['frm_ddd_whatzapp'] );   
      $usuario->set_ddd_fixo( $_REQUEST['frm_ddd_fixo'] );   
      
      $usuario->set_tel_celular( $_REQUEST['frm_tel_celular'] );   
      $usuario->set_tel_whatzapp( $_REQUEST['frm_tel_whatzapp'] );   
      $usuario->set_tel_fixo( $_REQUEST['frm_tel_fixo'] );   
      
      $usuario->set_exibir_tea( $_REQUEST['frm_exibir_tea'] ); 
      $usuario->set_id_logradouro( $_REQUEST['frm_id_logradouro'] );     
      
   } else if ( $_REQUEST['acao'] == 'inclusao' ) {
   }

} // igualar_objeto
?>

 <script type="text/javascript">

   function validar_submit_inclusao() {
      var retorno = false;
      $("#div_mens_inclusao").html("");
      if ( validar_email() ) {
         var retorno = true;
      }
      if ( retorno==true ) {
         retorno = validar_senhas();         
      }         
      return retorno;
   }

   function validar_email() {
      var retorno = true;
      _email = $('#frm_email').val();
      $.ajax({ 
         url: 'cad_usuario_hlp.php',
         type: "POST",
         async: false,
         dataType: "html",
         data: { 
            acao: 'obter_usuario',         
            email: _email
         },
         success: function(resultado){  
            var res = JSON.parse(resultado);
            if ( res.status=='ok' ) { //.. email já cadastrado
               retorno = false;
               $("#div_mens_inclusao").addClass("font_vermelha_m");
               $('#div_mens_inclusao').append( 'Seu E-mail já está cadastrado!<br>clique no link abaixo: Lembrar minha senha' );
            } else {               
               retorno = true; //.. email não cadastrado
            }              
         },
         failure: function( errMsg ) { alert(errMsg); } 
      });      
      return retorno;   
   } // validar_email

   function validar_senhas() {
      var retorno = true;
      $("#div_mens_inclusao").addClass("font_vermelha_m");
      _senha   = $("#frm_senha").val();
      _senha_r = $("#frm_senha_r").val();
      if (_senha != _senha_r ) {
         $('#div_mens_inclusao').append( 'As duas senhas devem ser iguais!'+'<br>' );         
         retorno = false;
      }
      if ( _senha.length<4 ) {
         $('#div_mens_inclusao').append( 'A senha deve ter no mínimo 6 caracteres!' );         
         retorno = false;
      }
      return retorno;
   } // validar_senhas

</script>
