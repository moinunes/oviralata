<?php
include_once 'conecta.php';
include_once 'cad_usuario_hlp.php';

header('Cache-Control: no cache'); //.. corrigi o erro: ERR_CACHE_MISS

/**
*
* Essa classe é generica para o site
* 
*/         

class Utils {
   
   static public function obter_data_hora_atual() {
      date_default_timezone_set('America/Sao_Paulo');
      $data = date('Y-m-d H:i:s', time());
      return $data;
   }

   static public function set_session($id_usuario) {
      if ($id_usuario==0) {
         $_SESSION['login'        ] = false;
         $_SESSION['id_usuario'   ] = '';
         $_SESSION['apelido'      ] = '';
         $_SESSION['email'        ] = '';
         $_SESSION['ddd'          ] = '';
         $_SESSION['telefone'     ] = '';
         $_SESSION['cep'          ] = '';
         $_SESSION['sexo'         ] = '';
         $_SESSION['id_logradouro'] = '';
         $_SESSION['endereco'     ] = '';

      } else {
         $usuario = new Cad_Usuario_Hlp();
         $usuario->set_id_usuario( $id_usuario );
         $usuario->obter_dados_usuario( $dados );
          
         $cep = substr(trim($dados->cep),0,5).'-'.substr(trim($dados->cep),5,3);
         $_SESSION['login'        ] = true;
         $_SESSION['id_usuario'   ] = $dados->id_usuario;
         $_SESSION['apelido'      ] = trim($dados->apelido);
         $_SESSION['email'        ] = trim($dados->email);         
         $_SESSION['ddd_celular'  ] = trim($dados->ddd_celular);
         $_SESSION['ddd_whatzapp' ] = trim($dados->ddd_whatzapp);
         $_SESSION['ddd_fixo'     ] = trim($dados->ddd_fixo);
         $_SESSION['tel_celular'  ] = trim($dados->tel_celular);
         $_SESSION['tel_whatzapp' ] = trim($dados->tel_whatzapp);
         $_SESSION['tel_fixo'     ] = trim($dados->tel_fixo);
         $_SESSION['cep'          ] = $dados->cep;
         $_SESSION['sexo'         ] = $dados->sexo;
         $_SESSION['id_logradouro'] = $dados->id_logradouro;
         $_SESSION['endereco'     ] = trim($dados->bairro).', '.trim($dados->municipio).', '.$dados->uf;

      }     
   }

   static public function Dbga_Abort( $valor) {
      $programa = explode('/', debug_backtrace()[0]['file'] );
      $programa = end($programa);
      $linha = explode('/', debug_backtrace()[0]['line'] );
      $linha = $linha[0];
      print "<pre>";
      print "Parou em: ".$programa.' -->linha:'.$linha ;
      print "<br>";
      print_r($valor);
      die();
   }

   /**
   *
   * Obtém apenas 1 foto grande do anúncio
   *
   */   
   static public function obter_uma_foto_grande( $id_anuncio, $data_cadastro ) {
      $dados       = new StdClass();
      $array_fotos = array();
      $dir_fotos   = str_replace( 'cadastro','fotos/', dirname(__FILE__) );
      $pasta_dc    = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      $fotos       = glob($pasta_dc.$id_anuncio.'_'."*");    
      foreach ( $fotos as $arquivo ) {
         $nome_foto = basename($arquivo);
         $pos       = strpos( $nome_foto, $id_anuncio.'_t_' );
         if ( $pos!==0 ) {
            break;
         }
      }
      return $nome_foto;      
   } // obter_uma_foto_grande

   /**
   *
   * Obtém apenas 1 foto - o thumbnail
   *
   */   
   static public function obter_thumbnail( $id_anuncio, $data_cadastro ) {
      $dados       = new StdClass();
      $array_fotos = array();
      $dir_fotos   = str_replace( 'cadastro','fotos/', dirname(__FILE__) );
      $pasta_dc    = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      $fotos       = glob($pasta_dc.$id_anuncio.'_'."*");    
      foreach ( $fotos as $arquivo ) {
         $nome_foto = basename($arquivo);
         $pos       = strpos( $nome_foto, $id_anuncio.'_t_' );
         if ( $pos===0 ) {
            break;
         }
      }
      return $nome_foto;      
   }

   /**
   *
   * Obtém apenas 1 foto - o thumbnail do servico
   *
   */   
   static public function obter_thumbnail_servico( $id_anuncio, $data_cadastro ) {
      $dados       = new StdClass();
      $array_fotos = array();
      $dir_fotos   = str_replace( 'cadastro','fotos_servico/', dirname(__FILE__) );
      $pasta_dc    = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      $fotos       = glob($pasta_dc.$id_anuncio.'_'."*");    
      foreach ( $fotos as $arquivo ) {
         $nome_foto = basename($arquivo);
         $pos       = strpos( $nome_foto, $id_anuncio.'_t_' );
         if ( $pos===0 ) {
            break;
         }
      }
      return $nome_foto;      
   } // obter_thumbnail_servicos

   /**
   *
   * Obtém array de fotos do anúncio
   *
   */   
   static public function obter_array_fotos( $id_anuncio, $data_cadastro, $thumbnail = null ) {
      $dados       = new StdClass();
      $array_fotos = array();
      $dir_fotos   = str_replace( 'cadastro','fotos/', dirname(__FILE__) );
      $pasta_dc    = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      $fotos       = glob($pasta_dc.$id_anuncio.'_'."*");
      $total_fotos = count($fotos)-1;
      foreach ( $fotos as $arquivo ) {
         $nome_foto = basename($arquivo);
         $pos       = strpos( $nome_foto, $id_anuncio.'_t_' );
         if( $thumbnail !='' ) {
            if ( $pos===0 ) {
               $array_fotos[]=$nome_foto;   
            }         
         } else {
            if ( $pos!==0 ) {
               $array_fotos[]=$nome_foto;
            }
         } 
      }
      $dados->total_fotos = $total_fotos;
      $dados->fotos       = $array_fotos;
      return $dados;      
   } // obter_array_fotos

   /**
   *
   * Obtém array de fotos - Serviços ou Produtos
   *
   */   
   static public function obter_array_fotos_servico( $id_servico, $data_cadastro, $thumbnail = null ) {
      $dados       = new StdClass();
      $array_fotos = array();
      $dir_fotos   = str_replace( 'cadastro','fotos_servico/', dirname(__FILE__) );
      $pasta_dc    = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      $fotos       = glob($pasta_dc.$id_servico.'_'."*");
      $total_fotos = count($fotos)-1;
      foreach ( $fotos as $arquivo ) {
         $nome_foto = basename($arquivo);
         $pos       = strpos( $nome_foto, $id_servico.'_t_' );
         if( $thumbnail !='' ) {
            if ( $pos===0 ) {
               $array_fotos[]=$nome_foto;   
            }         
         } else {
            if ( $pos!==0 ) {
               $array_fotos[]=$nome_foto;
            }
         } 
      }
      $dados->total_fotos = $total_fotos;
      $dados->fotos       = $array_fotos;
      return $dados;      
   } // obter_array_fotos_servico

   /**
   *
   * Obtém os nomes das imagens do anuncio
   *
   */   
   static public function obter_nomes_imagens( $id_anuncio ) {
      $dados   = new StdClass();
      $imagens = array();
      $dir     =  str_replace( 'cadastro','fotos/', dirname(__FILE__) );
      $pasta   = $dir.$id_anuncio.'/';
      $fotos   = array_slice( scandir($pasta), 2 );      
      foreach ( $fotos as $foto ) {
         $imagens[] = $foto;
      }
      return $imagens;
   } // obter_nomes_imagens

   /**
   *
   * Obtém uma frase
   *
   */   
   static public function obter_frase( $i ) {
      $frase = '';
      switch ($i) {
         case '0':
            $frase .= 'Adotar! um ato de amor - Adote um Amiguinho PET!';
            break;
         
         case '1':
            $frase .= 'Eu tenho uma família que me ama!';
            break;
         
         case '2':
            $frase .= 'Pessoal! Aqui no site oViraLata tem vários amiguinhos para adotar!';
            break;
         
         case '3':
            $frase .= '';
            break;
         
         case '4':
            $frase .= 'Eu adotei minha <b>família</b> e tô muito feliz!';
            break;         
         
         case '5':
            $frase .= 'Eu estou muito feliz com minha família, e gostaria que todos os amiguinhos tivessem um lar!';
            break;         
         
         case '6':
            $frase .= 'Adotar um amiguinho PET é um ato de <b>amor e responsabilidade!';
            break;
                  
         default:
            $frase .= 'Amor e respeito ao amiguinhos PET!</b>';
            break;
      }

      return $frase;
   } // obter_nomes_imagens
  
   /**
   *
   * Valida o login de usuário
   *
   */ 
   static public function validar_login() {
      if ( isset($_SESSION['login']) && $_SESSION['login'] ) {
         return true;
      } else {
         $self = explode( '/', $_SERVER['PHP_SELF']);
         $_SESSION['acao'         ] = $_REQUEST['acao'];
         $_SESSION['comportamento'] = $_REQUEST['comportamento'];
         $_SESSION['programa'     ] = end($self);
         header("Location: cad_login.php?acao=".$_REQUEST['acao']);
      }
   } // validar_login

   static public function esta_logado() {
      $resultado = false;
      $conecta   = new Conecta();
      $email     = $_REQUEST['frm_email'];
      $senha     = MD5($_REQUEST['frm_senha']);
      $sql = " SELECT       
                  email,
                  apelido
               FROM 
                  tbusuario
               WHERE email = '{$email}' AND senha = '{$senha}'
            "; 
      $stmt = $conecta->con->prepare( $sql );      
      $stmt->execute();
      $usuario = $stmt->fetch(PDO::FETCH_OBJ);
      if ( $usuario != '' ) {
         $resultado = true;
         $_SESSION['login'  ] = true;
         $_SESSION['apelido'] = trim($usuario->apelido);
         $_SESSION['email'  ] = trim($usuario->email);

      }
      return $resultado;
   }

   /**
   *
   * Configura o paginador
   *
   */ 
   static public function configura_paginador( $total_registros, $pagina_atual ) {
      $exibir        = 20;
      $do            = new StdClass();
      $pagina_atual  = ( $pagina_atual != '' ) ? $pagina_atual : 1;
      $qtd_paginas   = ceil(($total_registros/$exibir));
      $inicio_exibir = ($exibir * $pagina_atual) - $exibir;
      
      $do->pagina_atual  = $pagina_atual;
      $do->qtd_paginas   = $qtd_paginas;      
      $do->exibir        = $exibir;
      $do->inicio_exibir = $inicio_exibir;      
      return $do;
   } // configura_paginador

   /**
   *
   * Monta o paginador
   *
   */ 
   static public function paginador( $qtd_paginas, $pagina_atual ) {?>
      <div id="paginacao" class="text-center">   
         <?php
         $link='';
         $links_left  = $pagina_atual-3;
         $links_right = $pagina_atual+3;         
         $pagina_anterior = (($pagina_atual - 1) <= 0) ? "Anterior" : '<a href="javascript:submeter_form('.($pagina_atual - 1).')">Anterior</a>';         
         $pagina_proximo = (($pagina_atual + 1) > $qtd_paginas) ? "Próxima" : '<a href="javascript:submeter_form('.($pagina_atual+1).')">Próxima</a>';
         ?>
         <span id="anterior"><?=$pagina_anterior?></span>
         <?php
         for( $i = 1; $i <= $qtd_paginas; $i++ ) {
            if ( $i == $pagina_atual ) {
               echo '<span class="btn btn_paginador2">'.$i.'</span>';
            } else {
                if ($i>$links_left && $i<$pagina_atual){
                  echo '<a class="btn btn_paginador1" href="javascript:submeter_form('.$i.')">'.$i.'</a>';
               }
               if ($i>$pagina_atual && $i<$links_right){
                  echo '<a class="btn btn_paginador1" href="javascript:submeter_form('.$i.')">'.$i.'</a>';
               }   
            }
         }?>         
         <span id="proxima"><?=$pagina_proximo?></span>      
      </div>
   <?php
   } // paginador


  static public function exibir_data_extenso() {
      setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
      date_default_timezone_set('America/Sao_Paulo');      
      if ( $_SERVER['SERVER_NAME'] =='localhost' ) {
         echo  strftime('%A, %d de %B/%Y', strtotime('today'));
      } else {
         echo utf8_encode( strftime('%A, %d, de %B/%Y',strtotime('today')) );
      }
   } // exibir_data_extenso


   /**
   *
   * Valida o login administrativo (tools)
   *
   */ 
   static public function validar_login_tools() {
      if ( isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['apelido']=='admin' ) {
         return true;
      } else {
         header("Location: tools_login.php");
      }
   } // validar_login

   /**
   *
   * tratar data do anuncio
   *
   */   
   static public function data_anuncio( $_data ) {
      date_default_timezone_set('America/Sao_Paulo');
      $_hora = substr($_data,11,5);
      $_nova_data = date( "d/m/Y", strtotime($_data));
      $hoje  = time();
      $ontem     = $hoje - (24*3600);
      $hoje      = date('d/m/Y', $hoje);      
      $ontem     = date('d/m/Y', $ontem);
      if( $_nova_data==$hoje ) {
         $resultado='Hoje'.' '.$_hora;
      } else if( $_nova_data==$ontem ) {
         $resultado='Ontem-' . $_hora;
      } else {
         $resultado = substr($_data,8,2).'/'.substr($_data,5,2).'/'.substr($_data,0,4);
      }   
      return $resultado;      
   } // data_anuncio

   /**
   *
   * inclui as meta tags
   *
   */   
   static public function meta_tag() {?>
      <title>Adotar! Um ato de Amor. Mude sua vida, adote um amiguinho PET. Adoção e Doação de cães, gatos, etc... oViraLata.</title>
      <meta charset="utf-8">   
      <meta name="keywords"    content="adoçao de animais doação-cachorro-gato-oViraLata-Pet Doação de Pets-cão-gato-roedor-ração-doação de cão e gato, amor e respeito aos animais"/>
      <meta name="description" content="oViraLata é um site de anúncios de Adoção e Doação PET. No site você pode adotar ou publicar anúncios de doação: de cães, gatos, etc. O oViraLata também disponibiza espaço para publicação de anúncios de Pets desaparecidos. Adote um amiguinho PET. Doação de Cães e Gatos em todo Brasil">   
      <meta name="viewport"    content="width=device-width, initial-scale=1, maximum-scale=1">

   <?php
   } 
  

   /**
   *
   * Obtém os anúncios Pet PERDIDO
   * 
   * $limite=0 -> retorna todos registros
   */   
   static public function obter_pet_perdido( &$resultado, $limite=0 ) {
          $conecta = new Conecta();
      $filtro  = "1=1 AND tbanuncio.ativo='S' AND tbtipo_anuncio.codigo='petperdido' ";
      $ordem   = ' ORDER BY RAND() ';
      $limit   = $limite==0 ? '' : "LIMIT {$limite}";
      $sql = " SELECT 
                  tbanuncio.id_anuncio,                  
                  tbanuncio.titulo,
                  tbanuncio.descricao,
                  tbanuncio.data_cadastro,
                  tbanuncio.data_atualizacao,
                  tbanuncio.id_usuario,
                  tblogradouro.municipio,
                  tblogradouro.bairro,
                  tblogradouro.uf,
                  tbtipo_anuncio.tipo_anuncio,
                  tbraca.raca,
                  tbusuario.email,                  
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,
                  tbusuario.apelido,
                  tbusuario.exibir_tea,
                  tbcategoria.categoria
               FROM
                  tbanuncio
                     JOIN tbtipo_anuncio ON (tbtipo_anuncio.id_tipo_anuncio=tbanuncio.id_tipo_anuncio)
                     LEFT JOIN tbraca ON (tbraca.id_raca=tbanuncio.id_raca)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbanuncio.id_usuario)
                     JOIN tbcategoria ON (tbcategoria.id_categoria=tbanuncio.id_categoria)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbanuncio.id_logradouro) 
                WHERE $filtro
               $ordem    
               $limit;
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      if($limite==1){
         $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      } else {      
         $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);   
      }            
   }
  
   static public function obter_tipo_servico( &$resultado, $id_tipo_servico=null , $limite=0 ) {
      $conecta = new Conecta();
      $filtro  = "1=1";
      $ordem   = ' ORDER BY tiposervico ';
      $limit   = $limite==0 ? '' : "LIMIT {$limite}";
      if ( $id_tipo_servico !='' ) {
         $filtro .= " AND tbtipo_servico.id_tipo_servico = ".$id_tipo_servico;
      }
      $sql = " SELECT 
                  tbtipo_servico.id_tipo_servico,
                  tbtipo_servico.tiposervico
               FROM 
                  tbtipo_servico
               WHERE $filtro
               $ordem    
               $limit;
             ";
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      if($limite==1 || $id_tipo_servico !='' ) {
         $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      } else {      
         $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);   
      }            
   }

   /**
   * Obtém os anúncios - Anúncios DOAÇÃO
   * 
   * $limite=0 -> retorna todos registros
   *
   */   
   static public function obter_anuncios( &$resultado, $limite=1 ) {
      $conecta = new Conecta();
      $filtro  = "1=1 AND tbanuncio.ativo='S' ";
      $ordem   = ' ORDER BY RAND() ';
      $limit   = $limite==0 ? '' : "LIMIT {$limite}";
      $sql = " SELECT 
                  tbanuncio.id_anuncio,                  
                  tbanuncio.titulo,
                  tbanuncio.descricao,
                  tbanuncio.data_cadastro,
                  tbanuncio.data_atualizacao,
                  tbanuncio.id_usuario,
                  tblogradouro.municipio,
                  tblogradouro.bairro,
                  tblogradouro.uf,
                  tbtipo_anuncio.tipo_anuncio,
                  tbraca.raca,
                  tbusuario.email,                  
                  tbusuario.exibir_tea,
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,                  
                  tbusuario.apelido,
                  tbcategoria.categoria
               FROM
                  tbanuncio
                     JOIN tbtipo_anuncio ON (tbtipo_anuncio.id_tipo_anuncio=tbanuncio.id_tipo_anuncio)
                     LEFT JOIN tbraca ON (tbraca.id_raca=tbanuncio.id_raca)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbanuncio.id_usuario)
                     JOIN tbcategoria ON (tbcategoria.id_categoria=tbanuncio.id_categoria)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbanuncio.id_logradouro) 
                WHERE $filtro
               $ordem    
               $limit;
             ";
             //Utils::Dbga_Abort($sql);
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      if($limite==1){
         $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      } else {      
         $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);   
      }
   } // obter_anuncios

   static public function exibir_tipos_anuncio( $dispositivo='mobile', $titulo='Tipos de anúncios:' ) {
      $fonte_azul = 'font_azul_m';
      $fonte_preta= 'font_preta_m';
      $fonte_divulgue= 'fonts_azul_m';
      ?>      
      <div class="row margem_1">
         <div class="col-12 altura_linha_1"></div>
         <a href="cadastro/index.php">
            <div class="col-12 altura_linha_1"></div>    
            <div class="col-12">   
               <span class="font-weight-bold"><?=$titulo?><br></span>
               </span>
               <span class="<?=$fonte_divulgue?>">1- Doação PET<br></span>
               <span class="<?=$fonte_divulgue?>">2- Pet Desaparecido<br></span>               
               <span class="<?=$fonte_divulgue?>">3- Divulgue seus Serviços PET<br></span>
               <span class="<?=$fonte_divulgue?>">4- Divulgue seus Produtos PET<br></span>
            </div>
            <div class="col-12 altura_linha_2"></div>
            <div class="col-12">
               <a class="link_d" href="cadastro/index.php">Publicar Anúncio!</a>
            </div>
            <div class="col-12 altura_linha_1"></div>         
         </a>         
      </div>
   <?php
   } // exibir_texto

   static public function exibir_copyright() {?>      
     <div class="row">
         <div class="col-12 border">
            <br>
            <span class="font_cinza_p">Copyright © 2019 www.oviralata.com.br<br>Todos os direitos reservados. </span>
            <br><br>
         </div>            
      </div>     
   <?php
   } // exibir_copyright

   static public function obter_links(&$link_site, &$link_blog, &$link_grupo_face_oviralata, &$link_pagina_face ) {
      $href_site = "https://www.oviralata.com.br";         
      $link_site  = "<a target='_blank' href='".$href_site."'>";
      $link_site .= "Visitar oViraLata.";
      $link_site .= "</a>";

      $href_blog = "https://www.oviralata.com.br/blog";         
      $link_blog  = "<a target='_blank' href='".$href_blog."'>";
      $link_blog .= "Visitar o BLOG.";
      $link_blog .= "</a>";

      $href = "https://www.facebook.com/groups/oViraLata"; 
      $link_grupo_face_oviralata  = "<a target='_blank' href='".$href."'>";
      $link_grupo_face_oviralata .= "participe do grupo Facebook: oViraLata";
      $link_grupo_face_oviralata .= "</a>"; 

      $href = "https://www.facebook.com/paginaoviralata/"; 
      $link_pagina_face  = "<a target='_blank' href='".$href."'>";
      $link_pagina_face .= "curta nossa página no Facebook!";
      $link_pagina_face .= "</a>";
   } // obter_links

   /**
   *
   * Obtém os nomes das imagens do anuncio
   *
   */   
   static public function exibir_anuncio_aleatorio($tipo_anuncio, $titulo=null, $cor_fundo='#ffffff') {
      $thumbnail = '';
      switch ($tipo_anuncio) {
         case 'doacao':
            $link = 'adotar.php';
            Utils::obter_anuncios($anuncio,1);
            $id_anuncio = $anuncio->id_anuncio;
            $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
            $pasta_dc = 'fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
            if ( $dados->total_fotos>0 ) {
               $thumbnail = $pasta_dc.$dados->fotos[0];
            } else {
               $thumbnail = 'images/sem_foto1.png';
            }
            break;
         
         case 'perdido':
            $link = 'perdido.php';
            Utils::obter_pet_perdido($anuncio,1);
            if ( $anuncio != '') {
               $id_anuncio = $anuncio->id_anuncio;
               $dados = Utils::obter_array_fotos( $anuncio->id_anuncio, $anuncio->data_cadastro, 'T' );
               $pasta_dc = 'fotos/'.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
               if ( $dados->total_fotos>0 ) {
                  $thumbnail = $pasta_dc.$dados->fotos[0];
               } else {
                  $thumbnail = 'images/sem_foto1.png';
               }
            }
            break;
         
         default:
            die('vixi..');
            break;
      }?>
      <div class="row" style="background-color: <?=$cor_fundo?>">
         <div class="col-12 text-center">
            <a class="font_azul_m" href="<?=$link?>" role="button"><?=$titulo?><br>
               <img src="<?=$thumbnail ?>" class='img-fluid border rounded' >
            </a>
         </div>
      </div>
   <?php
   }

   static public function montar_carousel_servico( $id_carousel, $fotos, $data_cadastro ) {
      $active='active';?>
      <div id="<?=$id_carousel?>" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner text-center">
            <?php
            foreach ( $fotos as $nome_foto ) {
               $pasta_dc = 'fotos_servico/';
               $pasta_dc = $pasta_dc.date("d_m_Y", strtotime($data_cadastro)).'/';
               $thumbnail = $pasta_dc.$nome_foto;
               ?>
               <div class="carousel-item <?=$active?>">
                  <img src="<?=$thumbnail?>" class='img-fluid rounded' alt="serviços pet - produtos pet - passeador de cães e gatos - banho e tosa - pet shop - Adestrador">
                  <br>            
               </div>
               <?php
               $active='';
            }?>
         </div>
         <div>
            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#<?=$id_carousel?>" data-slide="prev">
               <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#<?=$id_carousel?>" data-slide="next">
               <span class="carousel-control-next-icon"></span>
            </a> 
         </div>
      </div>
   <?php   
   } 

   static public function obter_mensagens( &$mensagem_1, &$mensagem_2 ) {
      $segundo = date('s');
      switch ($segundo) {
         case ($segundo<10):
            $mensagem_1 = 'Se interessou por um Pet? Fale com o Tutor do Pet por e-mail, celular ou WhatsApp!';
            $mensagem_2 = 'Amor e Respeito aos animais!';   
            break;
         
         case ($segundo<20):
            $mensagem_1 = "Seu Pet desapareceu?<br>Publique um anúncio aqui no site com fotos e informações para contato!";
            $mensagem_2 = 'Diga NÃO!<br>aos maus tratos.';   
            break;
   
         case ($segundo<30):
            $mensagem_1 = "Diga Não! aos maus tratos!";
            $mensagem_2 = 'Mude sua vida, adote um amiguinho PET!';   
            break;

         case ($segundo<40):
            $mensagem_1 = "Mais Amor e Alegria?<br>Adote um Vira-Lata!";
            $mensagem_2 = 'Vamos ensinar as crianças a amar e respeitar os animais!';   
            break;

         case ($segundo<50):
            $mensagem_1 = "Mais Amor e Alegria?<br>Adote um Vira-Lata (SRD)";
            $mensagem_2 = 'Mude sua vida, adote um amiguinho PET!';   
            break;  

         case ($segundo<55):
            $mensagem_1 = 'Divulgue seus SERVIÇOS ou PRODUTOS!';
            $mensagem_2 = 'Anuncie grátis aqui no site!';  
            break;      

         default:
            $mensagem_1 = 'O site oViraLata é pra você que deseja Adotar ou Doar um PET!';
            $mensagem_2 = 'Eu Respeito e DEFENDO os animais!';
            break;
      }



   } // obter_mensagens

}