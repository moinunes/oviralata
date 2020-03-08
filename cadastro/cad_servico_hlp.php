<?php
include_once 'conecta.php';   
include_once 'endereco_hlp.php';
include_once 'fotos_servico.php';
include_once 'enviar_email_hlp.php';

/**
 *
 * Classe que efetua o cadastro de anuncios
 *
 */

class Cad_Servico_Hlp extends conecta {

   private $id_servico;
   private $id_usuario;
   private $id_tipo_servico;
   private $titulo;
   private $descricao;
   private $data_cadastro;
   private $ativo;
   private $data_atualizacao;
   private $array_publicar = array();
   private $cep;
   private $id_logradouro;
   private $mais_palavras;

   public function get_id_servico() {
      return $this->id_servico;
   }

   public function set_id_servico( $valor ) {
      $this->id_servico = $valor;
   }

   public function get_id_usuario() {
      return $this->id_usuario;
   }

   public function set_id_usuario( $valor ) {
      $this->id_usuario = $valor;
   }

   public function get_id_tipo_servico() {
      return $this->id_tipo_servico;
   }

   public function set_id_tipo_servico( $valor ) {
      $this->id_tipo_servico = $valor;
   }
   
   public function get_titulo() {
      return $this->titulo;
   }

   public function set_titulo( $valor ) {
      $this->titulo = $valor;
   }

   public function get_descricao() {
      return $this->descricao;
   }

   public function set_descricao( $valor ) {
      $this->descricao = $valor;
   }

   public function get_data_cadastro() {
      return $this->data_cadastro;
   }

   public function set_data_cadastro( $valor ) {
      $this->data_cadastro = $valor;
   }

    public function get_data_atualizacao() {
      return $this->data_atualizacao;
   }

   public function set_data_atualizacao( $valor ) {
      $this->data_atualizacao = $valor;
   }

   public function get_ativo() {
      return $this->ativo;
   }

   public function set_ativo( $valor ) {
      $this->ativo = $valor;
   }

   public function get_cep() {
      return $this->cep;
   }

   public function set_cep( $valor ) {
      $this->cep = $valor;
   }

   public function get_id_logradouro() {
      return $this->id_logradouro;
   }

   public function set_id_logradouro( $valor ) {
      $this->id_logradouro = $valor;
   }

   public function get_mais_palavras() {
      return $this->mais_palavras;
   }

   public function set_mais_palavras( $valor ) {
      $this->mais_palavras = $valor;
   }
   
   public function obter_tipo_servico(&$tipos, $id_tipo_servico=null, $ordem='id_tipo_servico' ) {  
      $filtro = $id_tipo_servico!='' ? "WHERE id_tipo_servico=$id_tipo_servico" : '';    
      $sql = " SELECT 
                  id_tipo_servico,
                  tiposervico
               FROM 
                  tbtipo_servico
               {$filtro} 
               ORDER BY {$ordem}   
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tipos = $stmt->fetchAll(PDO::FETCH_CLASS); 
   }

   /**
   *
   * Obtém os anúncios SERVIÇOS
   *
   */   
   public function obter_servicos( &$consulta ) {
      $filtro = "1=1 ";
      if ( $this->get_id_servico() ) {
         $filtro = " tbservico.id_servico = ".$this->get_id_servico();
      }
      if ( $this->get_id_usuario() != '' ) {
         $filtro .= " AND tbservico.id_usuario = ".$this->get_id_usuario();
      }
      if ( $this->get_ativo() != '' ) {
         $filtro .= " AND tbservico.ativo = '".$this->get_ativo()."'";
      }
      $ordem = ' ORDER BY tbservico.id_servico DESC ';
   
      $sql = " SELECT 
                  tbservico.id_servico,
                  tbservico.titulo,
                  tbservico.descricao,
                  tbservico.id_tipo_servico,
                  tbservico.data_cadastro,
                  tbservico.ativo,
                  tbservico.data_atualizacao,
                  tbtipo_servico.tiposervico,
                  tbusuario.id_usuario,
                  tbusuario.apelido,
                  tbusuario.email,
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,
                  tbusuario.apelido,
                  tbusuario.id_logradouro,
                  tblogradouro.cep,
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco
               FROM 
                  tbservico
                     JOIN tbtipo_servico ON (tbtipo_servico.id_tipo_servico=tbservico.id_tipo_servico)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro)
               WHERE
                  $filtro
               $ordem 
            ";
            //Utils::Dbga_Abort($sql);
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $consulta = $stmt->fetchAll(PDO::FETCH_CLASS);
   } // obter_anuncios

    public function adicionar_array_publicar($campo) {
      $campo = explode( '_', $campo );
      $id_servico = $campo[1];
      $this->array_publicar[]=$id_servico;
   }

   /**
   *
   * publicar o anúncio
   *
   */
   function publicar() {      
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         foreach ($this->array_publicar as $id_servico ) {
            $sql = " UPDATE tbservico 
                     SET ativo = :ativo
                     WHERE id_servico = :id_servico";
            $stmt = $this->con->prepare($sql);
            $stmt->execute( array( ':id_servico' => $id_servico,
                                   ':ativo'      => 'S'
                                  ));
            $this->enviar_email_publicar($id_servico, 'alteracao');
         }

      } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }   
      
      return null;
   } // publicar

   /**
   *
   * Obtém os dados do serviço do usuário logado
   *
   */   
   public function obter_dados_servico( &$dados ) {
      if ( $this->get_id_usuario() ) {
         $filtro = " tbservico.id_usuario = ".$this->get_id_usuario();
      }
      if ( $this->get_id_servico() ) {
         $filtro = " tbservico.id_servico = ".$this->get_id_servico();
      }
      $sql = " SELECT 
                  tbservico.id_servico,
                  tbservico.titulo,
                  tbservico.descricao,
                  tbservico.data_cadastro,
                  tbusuario.id_logradouro,
                  tbusuario.apelido,
                  tbusuario.email,
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco
               FROM 
                  tbservico
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro)
               WHERE
                  $filtro 
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $dados = $stmt->fetch(PDO::FETCH_OBJ);
   }

   /**
   *
   * Inclui o serviço
   *
   */
   function incluir() { 
      $palavras = $this->obter_palavras();

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $campos = " titulo,
                     descricao,
                     id_tipo_servico,
                     ativo,
                     id_usuario,
                     palavras,
                     data_cadastro,
                     data_atualizacao
                  ";
         $sql = "INSERT INTO tbservico({$campos})
                 VALUES (:titulo,
                         :descricao,
                         :id_tipo_servico,
                         :ativo,
                         :id_usuario,
                         :palavras,
                         :data_cadastro,
                         :data_atualizacao
                  )";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':titulo',           $this->get_titulo(),          PDO::PARAM_STR);
         $stmt->bindValue(':descricao',        $this->get_descricao(),       PDO::PARAM_STR);
         $stmt->bindValue(':id_tipo_servico',  $this->get_id_tipo_servico(), PDO::PARAM_INT);
         $stmt->bindValue(':ativo',            'S',                          PDO::PARAM_STR);
         $stmt->bindValue(':id_usuario',       $this->get_id_usuario(),      PDO::PARAM_INT); 
         $stmt->bindValue(':palavras',         $palavras,                    PDO::PARAM_STR);  
         $stmt->bindValue(':data_cadastro',    $this->get_data_cadastro(),   PDO::PARAM_STR);
         $stmt->bindValue(':data_atualizacao', $this->get_data_cadastro(),   PDO::PARAM_STR);      
         $stmt->execute();
         $id_servico = $this->con->lastInsertId();
         $this->set_id_servico($id_servico);
         $this->tem_erro = '';

         //.. renomear a pasta de fotos de tmp_xxxxx para id_aanuncio
         $fotos = new Fotos_Servico();
         $fotos->tratar_fotos_apos_inclusao( $id_servico, $this->get_data_cadastro() );
      
         $this->enviar_email_publicar($id_servico, 'inclusao');

      } catch(PDOException $e) {         
         echo 'Error: ' . $e->getMessage();
         $this->tem_erro = $e->getMessage();

      }
      return null;
   } // incluir

   /**
   *
   * Alterar o anúncio
   *
   */
   function alterar() {      
      $id_servico = explode( '_', $this->get_id_servico(), 2 );
      $id_servico = $id_servico[1];
      
      $palavras = $this->obter_palavras();

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = " UPDATE tbservico 
                  SET titulo          = :titulo,
                      descricao       = :descricao,
                      id_tipo_servico = :id_tipo_servico,
                      palavras        = :palavras,
                      ativo           = :ativo,
                      data_atualizacao= :data_atualizacao
                WHERE id_servico = :id_servico";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_servico'       => $id_servico,
                                ':titulo'           => $this->get_titulo(),
                                ':descricao'        => $this->get_descricao(),
                                ':id_tipo_servico'  => $this->get_id_tipo_servico(),
                                ':palavras'         => $palavras,
                                ':ativo'            => $this->get_ativo(),
                                ':data_atualizacao' => Utils::obter_data_hora_atual()
                              ));
          
         $fotos = new Fotos_Servico();
         $fotos->tratar_fotos_apos_alteracao( $this->get_id_servico(), $this->get_data_cadastro() );
         $this->tem_erro = '';

         $this->enviar_email_publicar( $id_servico, 'alteracao' );
 
      } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
          $this->tem_erro = $e->getMessage();           
      }   
      
      return null;
   } // alterar

   /**
   *
   * Renovar anúncio ( altera a data_atualizacao )
   *
   */
   function renovar_anuncio() {      
      $id_servico = $this->get_id_servico();
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbservico 
                     SET data_atualizacao = :data_atualizacao
                  WHERE id_servico = :id_servico";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_servico'       => $id_servico,
                                ':data_atualizacao' => Utils::obter_data_hora_atual()
                              ));          
         $this->tem_erro = '';
         $this->enviar_email_renovar( $id_servico);

      } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
          $this->tem_erro = $e->getMessage();       
      }   
      
      return null;
   } // renovar_anuncio

     function enviar_email_renovar( $id_servico ) {
      $this->obter_dados_do_anuncio( $dados, $id_servico );

      Utils::obter_links( $link_site, $link_blog, $link_grupo_face_oviralata, $link_pagina_face );
      
      $href = "https://www.facebook.com/paginaoviralata/"; 
      $link_pagina_face  = "<a target='_blank' href='".$href."'>";
      $link_pagina_face .= "curtir nossa página no Facebook: oViraLata";
      $link_pagina_face .= "</a>";

      $mensagem = "<br>";
      $mensagem = "<img src='cid:logo' alt='logo' /><br>";
      $mensagem .= "Portal de anúncios PET<br>";
      $mensagem .= "Amor e respeito aos Animais!<br>";
      
      $mensagem .= "<br>";
      $mensagem.= "Olá ".$dados->apelido.",<br>";
      
      $mensagem.= "O Seu anúncio foi RENOVADO no site oViraLata!<br>";
      $mensagem.= "título: ".$dados->titulo."<br>";      
      $mensagem.= "Fique a vontade para renovar seus anúncios sempre que desejar!<br>";
      
      $mensagem .= "<br><br>";
      $mensagem .= $link_site."<br>";
      $mensagem .= $link_blog."<br>";
      $mensagem .= $link_grupo_face_oviralata."<br>";
      $mensagem .= $link_pagina_face."<br>";
      $mensagem .= " <br>";

      $mensagem .= " <br><br>";
      $mensagem .= " Atenciosamente, <br>";
      $mensagem .= " oViraLata<br>";
      
      $email = new Enviar_Email_Hlp();
      $email->email_responder_para = 'contato@oviralata.com.br';
      $email->nome_responder_para  = 'oViraLata';
      $email->email_destinatario   = $dados->email;
      $email->nome_destinatario    = $dados->apelido;
      $email->assunto              = 'O Seu anúncio:Serviço foi RENOVADO no site oViraLata!';
      $email->mensagem             = $mensagem;

      $email->enviar_email();
      
      $vetor = array( 'resultado' => $email->enviado );
      
   } // enviar_email_publicar

   /**
   *
   * Obtém os dados do anúncio
   *
   */   
   public function obter_dados_do_anuncio( &$dados, $id_servico ) {
      $filtro = " tbservico.id_servico = ".$id_servico;
      $sql = " SELECT 
                  tbservico.id_servico,
                  tbservico.titulo,
                  tbusuario.apelido,                  
                  tbusuario.email
               FROM 
                  tbservico
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
               WHERE
                  $filtro
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $dados = $stmt->fetch(PDO::FETCH_OBJ);
   } // obter_dados_do_anuncio

   function obter_palavras() {
      $str_tipo = '';
      Utils::Obter_tipo_servico( $tipo, $this->get_id_tipo_servico() );
      $endereco = explode( ',', $_SESSION['endereco'] );
      $endereco_completo = trim($endereco[0]).','.trim($endereco[1]).','.trim($endereco[2]).'_';

      $palavras = $endereco_completo.','.$this->get_titulo().','.$tipo->tiposervico;      
      return $palavras;
   }
   
   /**
    *
    * Excluir o anuncio
    *
    */
   function excluir() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $this->excluir_fotos();
         
         $sql = " DELETE FROM tbservico                 
                  WHERE id_servico={$this->get_id_servico()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }   
      
      return null;
   }

   /**
   * Exclui as fotos do anuncio
   * obs: 
   */   
   public function excluir_fotos() {
      $id_servico = $this->get_id_servico();
      $dir_fotos  = str_replace( 'cadastro','fotos_servico/', dirname(__FILE__) );
      $pasta      = $dir_fotos.date("d_m_Y", strtotime($this->data_cadastro)).'/';
      $fotos      = glob($pasta.$id_servico."_*"); 
      foreach ( $fotos as $foto ) {
         unlink($foto);         
      }
   }

   /**
   *
   * Obtém os dados do servico
   *
   */   
   public function obter_dados_do_servico( &$dados, $id_servico ) {
      $filtro = " tbservico.id_servico = ".$id_servico;
      $sql = " SELECT 
                  tbservico.id_servico,
                  tbservico.titulo,
                  tbusuario.apelido,
                  tbusuario.email
               FROM 
                  tbservico
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
               WHERE
                  $filtro
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $dados = $stmt->fetch(PDO::FETCH_OBJ);
   }

   function enviar_email_publicar( $id_servico, $acao ) {
      $this->obter_dados_do_servico( $dados, $id_servico );

      Utils::obter_links( $link_site, $link_blog, $link_grupo_face_oviralata, $link_pagina_face );
      
      $href = "https://www.facebook.com/paginaoviralata/"; 
      $link_pagina_face  = "<a target='_blank' href='".$href."'>";
      $link_pagina_face .= "curtir nossa página no Facebook: oViraLata";
      $link_pagina_face .= "</a>";

      $mensagem = "<br>";
      $mensagem = "<img src='cid:logo' alt='logo' /><br>";
      $mensagem .= "Portal de anúncios PET<br>";
      $mensagem .= "Amor e respeito aos Animais!<br>";
      
      $mensagem .= "<br>";
      $mensagem.= "Olá ".$dados->apelido.",<br>";
      if ($acao=='inclusao') {
         $mensagem.= "O Seu anúncio:Serviço foi publicado no site oViraLata!<br>";
         $mensagem.= "título: ".$dados->titulo."<br>";
      
      } else {
         $mensagem.= "O Seu anúncio:Serviço foi ALTERADO no site oViraLata!<br>";
         $mensagem.= "título: ".$dados->titulo."<br>";      
         $mensagem.= "Agradescemos por utilizar o site oViraLata!<br>";
      }
      
      $mensagem .= "<br><br>";
      $mensagem .= $link_site."<br>";
      $mensagem .= $link_blog."<br>";
      $mensagem .= $link_grupo_face_oviralata."<br>";
      $mensagem .= $link_pagina_face."<br>";
      $mensagem .= " <br>";

      $mensagem .= " <br><br>";
      $mensagem .= " Atenciosamente, <br>";
      $mensagem .= " oViraLata<br>";
      
      $email = new Enviar_Email_Hlp();
      $email->email_responder_para = 'contato@oviralata.com.br';
      $email->nome_responder_para  = 'oViraLata';
      $email->email_destinatario   = $dados->email;
      $email->nome_destinatario    = $dados->apelido;
      if ($acao=='inclusao') {
         $email->assunto = 'O Seu anúncio:Serviço foi publicado no site oViraLata!';
      } else {
         $email->assunto  = 'O Seu anúncio:Serviço foi Alterado no site oViraLata!';      
      }
      $email->mensagem             = $mensagem;

      $email->enviar_email();
      
      $vetor = array( 'resultado' => $email->enviado );
      
   } // enviar_email_publicar


} // Cad_Servico_Hlp


if ( isset($_REQUEST['acao']) && trim($_REQUEST['acao']) != '' ) {
   validar_acao( $_REQUEST['acao'] );
}

function validar_acao( $acao ) {
   $instancia = new Cad_Servico_Hlp();
   switch ( $acao ) {
      case 'obter_categorias':
         $instancia->obter_categorias();
         break;

      default:
         break;
   }
} // verifica_acao