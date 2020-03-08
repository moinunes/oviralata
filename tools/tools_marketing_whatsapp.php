<?php
session_start();
include_once '../cadastro/utils.php';
if ( !$_SESSION['login'] ) {
   header("Location: tools_login.php");
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
   <?php include_once 'tools_cabecalho.php';?>   
   <div class="container">
  
      <div class="row fundo_cinza_1">

         <div class="col-12">
            <span class="destaque_1">Marketing-WhatsApp</span>
            <br><br>
         </div>
         <div class="col-4">
             <a class="link_a" href="tools_marketing_whatsapp.php?acao=alteracao&comportamento=cadastrar" role="button">Cadastrar</a>
         </div>         
         <div class="col-4">
             <a class="link_a" href="tools_marketing_whatsapp.php?acao=alteracao&comportamento=enviar_whatsapp" role="button">Enviar-WhatsApp</a>
         </div>
         <div class="col-4">            
            <a class="btn btn-outline-success btn_link" href="tools.php?acao=vazio&comportamento=vazio"><img src="../images/voltar.svg" >Voltar</a>
         </div>  
      </div>   

      <div class="row">
         <div class="col-md-12">
            <br>
         </div>
      </div>


      <?php
      verificar_acao();

      function verificar_acao() {
         $comportamento = $_REQUEST['comportamento'];
         switch ($comportamento) {         
            case 'cadastrar':
               cadastrar();
               break;
            case 'enviar_whatsapp':
               enviar_whatsapp();
               break;               
            case 'efetivar_cadastrar':
               efetivar_cadastrar();
               break;
            case 'efetivar_enviado':
               efetivar_enviado();
               break;
            default:
               die(' vixi...');
               break;
         }
      } // verificar_acao

      function cadastrar() {
         $titulo = 'Cadastrar Celulares';   
         ?>
         <form id="frmCadastrar" class="form-horizontal" action="tools_marketing_whatsapp.php" method="POST" enctype="multipart/form-data" role="form">
            <div id='div_buscar'></div>
            <input type="hidden" id="comportamento" name="comportamento" value = "efetivar_cadastrar">         
            <input type="hidden" id="acao"          name="acao"          value = "<?=$_REQUEST['acao']?>">
            <div class="row">
                <div class="col-12 altura_linha_1"></div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <span class="destaque_3">Cadastrar Celulares</span>
               </div>
            </div>
            <div class="row">
                <div class="col-12 altura_linha_1"></div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <label for="frm_descricao">Celular-nome</label>
                  <textarea id='frm_texto'  name='frm_texto' class="form-control form-control-sm" rows="5" required  ></textarea>
                  <div id='div_descricao' class="font_vermelha_p"></div>
               </div>
               <div class="col-12">
                  <span class="font_cinza_p">
                     exemplo: (13)996190707 Moisés Nunes, 19996190707 Maria'<br>
                     obs: separados por vigula...
                  </span>
                  
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <input type="submit" name="b1" class="btn btn-success btn_salvar" value="Confirmar">
               </div>
            </div>

            <div class="row">
               <div class="col-12">           
                  <span class="font_cinza_p">
                     <br><br>
                     de nada, tenha um bom dia!<br>
                     Fique a vontade para publicar seus anúncios no site www.oviralata.com.br
                  </span>
               </div>
            </div>

         </form>
      <?php
      } // invalidar_emails
      
      function efetivar_cadastrar() {
         $array_texto = explode( ',', trim($_REQUEST['frm_texto']) );
         foreach( $array_texto as $i => $texto ) {         
            $linha = explode( ' ', trim($texto) );
            $celular = $linha[0];
            $nome    = $linha[1];
            $celular = str_replace( ['-', '(', ')'], '', $celular );
            incluir($nome,$celular);
         }
         print '<span class="destaque_3">Cadastrar</span><br><br>';
         print ' Cadastro efetuado com sucesso!';   
      } // efetivar_invalidar_emails

      function incluir($nome,$celular) {   
         $conecta = new Conecta();
         try {
            $conecta->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tbwhatsapp(nome,celular)
                    VALUES (:nome,
                            :celular
                  )";
            $stmt = $conecta->con->prepare($sql);
            $stmt->bindValue(':nome',    $nome, PDO::PARAM_STR);
            $stmt->bindValue(':celular', $celular, PDO::PARAM_STR);
            $stmt->execute();            
         } catch(PDOException $e) {
            $pos       = strpos($e, 'Duplicate' );
            if($pos>=0) {
               echo 'Error: ' . $e->getMessage()."<br>";
            }
         }
         return null;
      }    

      function obter_registros( &$resultado, $limit = 50  ) {
         $conecta = new Conecta();
         $sql = " SELECT 
                     id_whatsapp,
                     nome,
                     celular
                  FROM 
                     tbwhatsapp
                  WHERE enviado IS NULL
                  ORDER BY id_whatsapp
                  limit {$limit}
                ";
         $stmt = $conecta->con->prepare( $sql );
         $stmt->execute();
         $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);  
      }   

      function obter_totais( &$dados ) {
         $dados = new StdClass();
         $conecta = new Conecta();
         //..
         $sql = " SELECT 
                     count(*) as total_a_enviar
                  FROM 
                     tbwhatsapp
                  WHERE enviado IS NULL
                ";
         $stmt = $conecta->con->prepare( $sql );
         $stmt->execute();
         $resultado = $stmt->fetch(PDO::FETCH_OBJ);
         $dados->total_a_enviar = $resultado->total_a_enviar;
         //..
         $sql = " SELECT 
                     count(*) as total_enviado
                  FROM 
                     tbwhatsapp
                  WHERE enviado IS NOT NULL
                ";
         $stmt = $conecta->con->prepare( $sql );
         $stmt->execute();
         $resultado = $stmt->fetch(PDO::FETCH_OBJ);
         $dados->total_enviado = $resultado->total_enviado;
      }   

      function enviar_whatsapp() {
         obter_registros( $consulta );
         obter_totais( $dados );       
         ?>

         <form id="frmInvalidarEmails" class="form-horizontal" action="tools_marketing_whatsapp.php" method="POST" role="form">
            <input type="hidden" id="comportamento" name="comportamento" value = "efetivar_enviado">
            <input type="hidden" id="acao" name="acao" value = "<?=$_REQUEST['acao']?>">
            
            <div class="row">
               <div class="col-12">         
                  <span class="text">Enviar WhatsApp</span>
               </div>
            </div>
            <div class="row">
               <div class="col-12">         
               </div>
            </div>

            <div class="row">
               <div class="col-12">                     
                  <hr class="hr1">
               </div>
            </div>
            <div class="row">
               <div class="col-2">
                   <span class="font_cinza_g"><?='Enviados: '.$dados->total_enviado?></span>
               </div>
               <div class="col-2">
                   <span class="font_cinza_g"><?='À Enviar: '.$dados->total_a_enviar?> </span>                
               </div>           
            </div>
            <div class="row">
               <div class="col-12">                     
                  <hr class="hr1">
               </div>
            </div>
            <div class="row">
               <div class="col-2">
                  <input type="checkbox" id="checkTodos" name="checkTodos">Selecionar Todos
               </div> 
               <div class="col-2">
                  <input type="submit" name="b1" class="btn btn-success" value="Marcar Enviado">
               </div>            
            </div>
                      
            <div class="row">
               <div class="col-12">                     
                  <hr class="hr1">
               </div>
            </div>
            <?php
            $i = 0;
            foreach ( $consulta as $registro ) {
               $id_whatsapp = $registro->id_whatsapp;
               $nome = $registro->nome;
               $celular = $registro->celular;

               $mens  = "olá%20{$nome} bom dia, Gostaria de lhe apresentar o site: www.oviralata.com.br"."\n\r";
               $mens .=  "É um site de anúncios Gratuíto para: Doação Pet, divulgação de Serviços ou Produtos PET.";
               $mens .= "tenha um bom dia!"."\n\r";
               $mens .= "Fique a vontade para publicar seus anúncios no site www.oviralata.com.br";
               $mens .= "Atenciosamente, Moisés";
            

               ?>
               <div class="row">            
                  <div class="col-12 altura_linha_1">
                  </div>
               </div>

               <div class="row">
                  <div class="col-12" >
                     <input type="checkbox" id="<?='chk_'.$registro->id_whatsapp?>" name="<?='chk_'.$registro->id_whatsapp?>"  >
                     <span class="font_azul_m"><?=$registro->nome.' --> '.$registro->celular?></span>
                     <a class="btn btn_padrao"  target="_blank" href="https://www.forblink.com/index.php?phone=<?="55{$celular}"?>&text=<?="{$mens}"?>">
                        Enviar
                     </a>
                  </div>  
               </div>
            
            <?php
            }?>
         
         </form>

      <?php
      } // enviar_whatsapp

      function obter_dados( &$dados, $id_whatsapp ) {
         $conecta = new Conecta();
         $filtro  = "tbwhatsapp.id_whatsapp = ".$id_whatsapp;
         $sql = " SELECT 
                     id_whatsapp,
                     nome,
                     celular,
                     enviado
                  FROM 
                     tbwhatsapp
                  WHERE
                     $filtro
               ";
         $stmt = $conecta->con->prepare($sql);
         $stmt->execute();
         $dados = $stmt->fetchAll(PDO::FETCH_CLASS);
      }

      function efetivar_enviado() {
         $conecta = new Conecta();
         foreach( $_REQUEST as $campo => $valor ) {
            if (substr($campo,0,4)=='chk_') {
               $id_whatsapp = explode( '_', $campo );
               $id_whatsapp = $id_whatsapp[1];
               obter_dados( $dados, $id_whatsapp );
               $sql = " UPDATE tbwhatsapp
                        SET enviado ='S'
                        WHERE id_whatsapp={$id_whatsapp} ";
               $stmt = $conecta->con->prepare($sql);
               $stmt->execute();
            }
         }
         print ' Marcados como enviados - sucesso!';
      }
      ?>

   </div> <!-- container -->

   <footer class="fixed-bottom">
      <div class="row">
         <div class="col-md-12">
            <nav class="navbar navbar-light cor_verde">
               <a target="_blank" class="btn btn-outline-success btn_link" href="../" role="button">Abrir Site</a>
            </nav>
         </div>
      </div> 
   </footer>

   <!-- 
   <script src="../dist/js/load-image/load-image.all.min.js"></script>

    -->
   <script src="../dist/js/jquery-3.3.1.min.js"></script>


    <script type="text/javascript">
      //.. marcar/desmarcar todos
      var checkTodos = $("#checkTodos");
      checkTodos.click(function () {
        if ( $(this).is(':checked') ){
          $('input:checkbox').prop("checked", true);
        }else{
          $('input:checkbox').prop("checked", false);
        }
      });
   </script>   
   

</body>

</html>
