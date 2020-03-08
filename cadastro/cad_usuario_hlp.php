<?php
include_once 'conecta.php';
include_once 'utils.php';
include_once 'enviar_email_hlp.php';

/**
*
* Classe que auxilia na manutenção do cadastro de usuários
*
*/

class Cad_Usuario_Hlp extends conecta {

   private $id_usuario;
   private $nome_completo;
   private $apelido;
   private $senha; 
   private $senha_r; 
   private $sexo;   
   private $ddd_celular;
   private $ddd_whatzapp;    
   private $ddd_fixo;
   private $tel_celular;
   private $tel_whatzapp;
   private $tel_fixo; 
   private $email;
   private $id_logradouro;
   private $data_cadastro;
   private $codigo_ativacao;
   private $ativo;
   private $id_facebook;
   private $contato_whatzapp;
   private $exibir_tea;

   public function get_id_usuario() {
      return $this->id_usuario;
   }

   public function set_id_usuario( $valor ) {
      $this->id_usuario = $valor;
   }

   public function get_nome_completo() {
      return $this->nome_completo;
   }

   public function set_nome_completo( $valor ) {
      $this->nome_completo = $valor;
   }

   public function get_apelido() {
      return $this->apelido;
   }

   public function set_apelido( $valor ) {
      $this->apelido = $valor;
   }

   public function get_senha() {
      return $this->senha;
   }

   public function set_senha( $valor ) {
      $senha = md5($valor);
      $this->senha = $senha;
   }

   public function get_senha_r() {
      return $this->senha_r;
   }

   public function set_senha_r( $valor ) {
      $senha_r ='xpto'. $valor;
      $senha_r = hash( 'sha256', $senha_r, true );
      $this->senha_r = $senha_r;
   }

   public function get_sexo() {
      return $this->sexo;
   }

   public function set_sexo( $valor ) {
      $this->sexo = $valor;
   }
   
   public function get_ddd_celular() {
      return $this->ddd_celular;
   }

   public function set_ddd_celular( $valor ) {
      $this->ddd_celular = $valor;
   }

   public function get_ddd_whatzapp() {
      return $this->ddd_whatzapp;
   }

   public function set_ddd_whatzapp( $valor ) {
      $this->ddd_whatzapp = $valor;
   }

   public function get_ddd_fixo() {
      return $this->ddd_fixo;
   }

   public function set_ddd_fixo( $valor ) {
      $this->ddd_fixo = $valor;
   }

   public function get_tel_celular() {
      return $this->tel_celular;
   }

   public function set_tel_celular( $valor ) {
      $this->tel_celular = $valor;
   }

   public function get_tel_whatzapp() {
      return $this->tel_whatzapp;
   }

   public function set_tel_whatzapp( $valor ) {
      $this->tel_whatzapp = $valor;
   }

   public function get_tel_fixo() {
      return $this->tel_fixo;
   }

   public function set_tel_fixo( $valor ) {
      $this->tel_fixo = $valor;
   }   

   public function get_email() {
      return $this->email;
   }

   public function set_email( $valor ) {
      $this->email = $valor;
   }

   public function get_id_logradouro() {
      return $this->id_logradouro;
   }

   public function set_id_logradouro( $valor ) {
      $this->id_logradouro = $valor;
   }

   public function get_codigo_ativacao() {
      return $this->codigo_ativacao;
   }

   public function set_codigo_ativacao( $valor ) {
      $this->codigo_ativacao = $valor;
   }

   public function get_ativo() {
      return $this->ativo;
   }

   public function set_ativo( $valor ) {
      $this->ativo = $valor;
   }

   public function get_id_facebook() {
      return $this->id_facebook;
   }

   public function set_id_facebook( $valor ) {
      $this->id_facebook = $valor;
   }

   public function get_contato_whatzapp() {
      return $this->contato_whatzapp;
   }

   public function set_contato_whatzapp( $valor ) {
      $this->contato_whatzapp = $valor;
   }

   public function get_exibir_tea() {
      return $this->exibir_tea;
   }

   public function set_exibir_tea( $valor ) {
      $this->exibir_tea = $valor;
   }

   /**
   *
   * Obtém dados do usuário
   *
   */   
   public function obter_dados_usuario( &$consulta ) {
      $filtro = "1=1 ";

      if ( $this->get_ativo() != '' ) {
         $filtro .= " AND tbusuario.ativo = '{$this->get_ativo()}'";
      }
       if ( $this->get_id_usuario() != '' ) {
         $filtro .= " AND tbusuario.id_usuario = ".$this->get_id_usuario();
      }
      if ( $this->get_email() != '' ) {
         $filtro .= " AND tbusuario.email = '{$this->get_email()}'";
      }
      if ( $this->get_senha() != '' ) {
         $filtro .= " AND tbusuario.senha = '{$this->get_senha()}'";
      }
      if ( $this->get_codigo_ativacao() != '' ) {
         $filtro .= " AND tbusuario.codigo_ativacao = '{$this->get_codigo_ativacao()}'";
      }
      if ( $this->get_id_facebook() != '' ) {
         $filtro .= " AND tbusuario.id_facebook = '{$this->get_id_facebook()}'";
      }

      $ordem = ' ORDER BY tbusuario.id_usuario DESC ';
   
      $sql = " SELECT 
                  tbusuario.id_usuario,
                  tbusuario.nome_completo,
                  tbusuario.apelido,
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,
                  tbusuario.email,
                  tbusuario.id_facebook,
                  tbusuario.data_cadastro,
                  tbusuario.id_logradouro,
                  tbusuario.sexo,
                  tbusuario.ativo,
                  tbusuario.codigo_ativacao,
                  tbusuario.contato_whatzapp,
                  tbusuario.exibir_tea,
                  tbusuario.bloqueado,
                  tblogradouro.cep,
                  tblogradouro.bairro,
                  tblogradouro.municipio,
                  tblogradouro.uf,
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco   
               FROM 
                  tbusuario
                     LEFT JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro)                        
               WHERE
                  $filtro
               $ordem 
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $consulta = $stmt->fetch(PDO::FETCH_OBJ);
   } // obter_dados_usuario

   /**
   *
   * Inclui o usuário
   *
   */
   function incluir() { 
      $codigo_ativacao = md5( uniqid(rand(),true));
        
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $campos = " nome_completo,
                     email,
                     senha,     
                     codigo_ativacao,
                     ativo
                  ";
         $sql = "INSERT INTO tbusuario({$campos})
                 VALUES (:nome_completo,
                         :email,
                         :senha,
                         :codigo_ativacao,
                         :ativo
                  )";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':nome_completo',   $this->get_nome_completo(), PDO::PARAM_STR);
         $stmt->bindValue(':email',           $this->get_email(),         PDO::PARAM_STR);
         $stmt->bindValue(':senha',           $this->get_senha(),         PDO::PARAM_STR);
         $stmt->bindValue(':codigo_ativacao', $codigo_ativacao,           PDO::PARAM_STR);
         $stmt->bindValue(':ativo',           'N',                        PDO::PARAM_STR);
         $stmt->execute();
         $id_usuario = $this->con->lastInsertId();
         $this->set_id_usuario($id_usuario);

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }
      return null;
   } // incluir

   /**
   *
   * Inclui o usuário vindo do Facebook
   *
   */
   function incluir_usuario_facebook() {         
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $campos = " nome_completo,
                     email,
                     id_facebook,
                     ativo
                  ";
         $sql = "INSERT INTO tbusuario({$campos})
                 VALUES (:nome_completo,
                         :email,
                         :id_facebook,
                         :ativo
                  )";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':nome_completo',   $this->get_nome_completo(), PDO::PARAM_STR);
         $stmt->bindValue(':email',           $this->get_email(),         PDO::PARAM_STR);
         $stmt->bindValue(':id_facebook',     $this->get_id_facebook(),   PDO::PARAM_STR);
         $stmt->bindValue(':ativo',           'S',                        PDO::PARAM_STR);
         $stmt->execute();
         $id_usuario = $this->con->lastInsertId();
         $this->set_id_usuario($id_usuario);

         $this->enviar_email_facebook( $id_usuario );

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }
      return null;
   } // incluir_usuario_facebook


   /**
   *
   * envia email para usuário após se cadastrar pelo link Facebook
   *
   */   
   public function enviar_email_facebook( $id_usuario ) {
      $usuario = new Cad_Usuario_Hlp();
      $usuario->set_id_usuario($id_usuario);
      $usuario->obter_dados_usuario( $consulta_usuario );

      Utils::obter_links( $link_site, $link_blog, $link_grupo_face_oviralata, $link_pagina_face );
      
      $mensagem = "<br>";
      $mensagem = "<img src='cid:logo' alt='logo' /><br>";
      $mensagem .= "Portal de anúncios PET<br>";
      $mensagem .= "Amor e respeito aos Animais!<br>";

      $mensagem .= "<br>";
      $mensagem .= " Olá, {$consulta_usuario->nome_completo}<br>";
      $mensagem .= " Obrigado por se cadastrar no site oViraLata.";
      $mensagem .= "<br>";
      $mensagem .= " Agradecemos pelo seu interesse em nosso conteúdo e serviços.";
      $mensagem .= "<br><br>";
      
      $mensagem .= "<br><br>";
      $mensagem .= $link_site."<br>";
      $mensagem .= $link_blog."<br>";
      $mensagem .= $link_grupo_face_oviralata."<br>";
      $mensagem .= $link_pagina_face."<br>";
      $mensagem .= " <br>";

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
         
   /**
   *
   * Ativar o usuário
   *
   */
   public function ativar_usuario($id_usuario) { 
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbusuario
                  SET ativo ='S'
                  WHERE id_usuario={$id_usuario} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();
         
      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
      }
      return null;  
   } // ativar_usuario


   /**
   *
   * Alterar dados do usuário
   *
   */
   function alterar() {  
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbusuario 
                  SET nome_completo    = :nome_completo,
                      apelido          = :apelido,
                      sexo             = :sexo,                      
                      ddd_celular      = :ddd_celular,
                      ddd_whatzapp     = :ddd_whatzapp,
                      ddd_fixo         = :ddd_fixo,
                      tel_celular      = :tel_celular,
                      tel_whatzapp     = :tel_whatzapp,
                      tel_fixo         = :tel_fixo,                      
                      exibir_tea       = :exibir_tea,
                      contato_whatzapp = :contato_whatzapp,
                      id_logradouro    = :id_logradouro
                WHERE id_usuario = :id_usuario";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_usuario'       => $this->get_id_usuario(),
                                ':nome_completo'    => $this->get_nome_completo(),
                                ':apelido'          => $this->get_apelido(),
                                ':sexo'             => $this->get_sexo(),               
                                ':ddd_celular'      => $this->get_ddd_celular(),
                                ':ddd_whatzapp'     => $this->get_ddd_whatzapp(),
                                ':ddd_fixo'         => $this->get_ddd_fixo(),
                                ':tel_celular'      => $this->get_tel_celular(),
                                ':tel_whatzapp'     => $this->get_tel_whatzapp(),
                                ':tel_fixo'         => $this->get_tel_fixo(),
                                ':exibir_tea'  => $this->get_exibir_tea(),
                                ':contato_whatzapp' => $this->get_contato_whatzapp(),
                                ':id_logradouro'    => $this->get_id_logradouro()
                              ));
         
        Utils::set_session( $this->get_id_usuario() );

      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
      }   
      
      return null;
   } // alterar

   function obter_codigo_ativacao( &$codigo_ativacao, $id_usuario ) {
      $filtro = " id_usuario = '{$id_usuario}'";
      $sql = " SELECT
                  id_usuario,
                  codigo_ativacao
               FROM 
                  tbusuario
                WHERE
                  $filtro
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $usuario = $stmt->fetch(PDO::FETCH_OBJ);
      if ( $usuario->codigo_ativacao != '' ) {
         $codigo_ativacao = $usuario->codigo_ativacao;
      } else {
         $this->gravar_codigo_ativacao( $id_usuario );
         $codigo_ativacao = $this->get_codigo_ativacao();
      }
   }

   /**
   *
   * Grava código de ativação
   *
   */  
   function gravar_codigo_ativacao( $id_usuario ) {
      $codigo_ativacao = md5( uniqid(rand(),true));
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbusuario 
                  SET codigo_ativacao = :codigo_ativacao
                  WHERE id_usuario = :id_usuario";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_usuario'      => $id_usuario,
                                ':codigo_ativacao' => $codigo_ativacao 
                               ));
         $this->set_codigo_ativacao( $codigo_ativacao);      
      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
      }   
      return null;             
   }


   /**
   * Obtém dados do usuario
   *
   */   
   public function obter_usuario() {
      $filtro = "1=1 ";
      $email  = $_REQUEST['email'];      
      if ( $email != '' ) {
         $filtro .= " AND tbusuario.email = '{$email}'";
      }
      $sql = " SELECT
                  id_usuario,
                  nome_completo,
                  email
               FROM 
                  tbusuario
               WHERE tbusuario.email='{$email}'
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      if ( $res!='' ) {
         $resultado['status'        ] = 'ok'; 
         $resultado['id_usuario'    ]= $res->id_usuario;
         $resultado['nome_completo' ]= utf8_encode($res->nome_completo);
         $resultado['email'         ]= utf8_encode($res->email);
         echo json_encode($resultado);
      } else {
         $resultado['status'] = 'not found';
         echo json_encode($resultado);
      }
   } // Obtém dados do usuario

   /**
   *
   * Redefine a nova senaha
   *
   */  
   function redefinir_senha() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbusuario 
                  SET senha = :senha,
                      ativo = :ativo
                  WHERE id_usuario = :id_usuario";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_usuario'=> $this->get_id_usuario(),
                                ':senha'     => $this->get_senha(),
                                ':ativo'     => 'S'
                               ));
      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
      }   
      return null;             
   }

   /*
   *
   * atualiza usuario - quando loga  com facebook
   *
   */  
   function atualizar_usuario_facebook( $id_usuario, $id_facebook ) {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbusuario 
                  SET id_facebook= :id_facebook,
                      ativo = :ativo
                  WHERE id_usuario = :id_usuario";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_usuario'  => $id_usuario,
                                ':id_facebook' => $id_facebook,
                                ':ativo'       => 'S'
                               ));
      } catch(PDOException $e) {
         Utils::Dbga_Abort($e);
         echo 'Error: ' . $e->getMessage();
      }   
      return null;             
   }

} // Cad_Usuario_Hlp

$acao = isset($_REQUEST['acao']) ? trim($_REQUEST['acao']) : '';
if ( $acao != '' ) {
      $instancia = new Cad_Usuario_Hlp();
      switch ( $acao ) {
         case 'obter_usuario':
            $instancia->obter_usuario();
            break;

         default:
            break;
      }

}