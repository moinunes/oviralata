<?php
include_once '../cadastro/conecta.php';


/**
 *
 * Classe que efetua o cadastro - Usuário
 *
 */

class Tools_Cad_Usuario_Hlp extends conecta {

   public $id_usuario;
   public $nome_completo;
   public $apelido;
   public $senha;
   public $sexo;
   private $ddd_celular;
   private $ddd_whatzapp;    
   private $ddd_fixo;
   private $tel_celular;
   private $tel_whatzapp;
   private $tel_fixo; 
   public $email;
   public $id_logradouro;
   public $ativo;
   public $codigo_ativacao;
   public $id_facebook;
   public $contato_whatzapp;
   public $data_cadastro;
   public $endereco;
   public $order;
   public $exibir;
   public $tipo_cadastro;

   /**
   *
   * Obtém os dados dos usuários
   *
   */   
   public function obter_dados_usuario( &$dados ) {
      $filtro = "1=1 ";
      if ( $this->id_usuario ) {
         $filtro .= " AND tbusuario.id_usuario = ".$this->id_usuario;
      }
      if ( $this->nome_completo ) {
         $filtro .= " AND tbusuario.nome_completo like '%{$this->nome_completo}%' ";
      }
      if ( $this->apelido ) {
         $filtro .= " AND tbusuario.apelido like '%{$this->apelido}%' ";
      }
      if ( $this->email ) {
         $filtro .= " AND tbusuario.email like '%{$this->email}%' ";
      }
      if ( $this->ativo ) {
         $filtro .= " AND tbusuario.ativo = '{$this->ativo}' ";
      }

      if ( $this->exibir == 'C' ) {
         $filtro .= " AND tbusuario.id_logradouro IS NOT NULL ";
      } elseif ( $this->exibir == 'I' ) {
          $filtro .= " AND tbusuario.id_logradouro IS NULL ";
      }

      if ( $this->tipo_cadastro == 'F' ) {
         $filtro .= " AND tbusuario.id_facebook IS NOT NULL ";
      } elseif ( $this->tipo_cadastro == 'E' ) {
         $filtro .= " AND tbusuario.id_facebook IS NULL ";
      }

      $order = $this->order == '' ? '' : "ORDER BY {$this->order} DESC";

      $sql = " SELECT 
                  tbusuario.id_usuario,
                  tbusuario.nome_completo,
                  tbusuario.apelido,
                  tbusuario.senha,
                  tbusuario.sexo,
                   tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,
                  tbusuario.email,
                  tbusuario.id_logradouro,
                  tbusuario.ativo,
                  tbusuario.bloqueado,
                  tbusuario.codigo_ativacao,
                  tbusuario.id_facebook,
                  tbusuario.contato_whatzapp,
                  tbusuario.data_cadastro,                  
                  tblogradouro.cep,                  
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco
               FROM 
                  tbusuario
                     LEFT JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro)
               WHERE
                  $filtro
               $order   
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $dados = $stmt->fetchAll(PDO::FETCH_CLASS);      
   } // obter_dados_usuario
   

   /**
   *
   * Alterar dados do usuário
   *
   */
   function alterar() {      
      
      $bloqueado = trim($this->bloqueado)=='' ? null : $this->bloqueado;

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = " UPDATE tbusuario 
                  SET ativo     = :ativo,
                      bloqueado = :bloqueado
                WHERE id_usuario = :id_usuario";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_usuario' => $this->id_usuario,
                                ':ativo'      => $this->ativo,
                                ':bloqueado'  => $bloqueado

                              ));
         
         $this->tem_erro = '';
 
      } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
          $this->tem_erro = $e->getMessage();    

      }   
      
      return null;
   } // alterar


} // Tools_Cad_Usuario_Hlp


if ( isset($_REQUEST['acao']) && trim($_REQUEST['acao']) != '' ) {
   verifica_acao( $_REQUEST['acao'] );
}

function verifica_acao( $acao ) {
   $instancia = new Tools_Cad_Usuario_Hlp();
   switch ( $acao ) {
     
       case 'sem_uso_no_momento':
         $instancia->obter_racas();
         break;

      default:
         break;
   }
} // verifica_acao