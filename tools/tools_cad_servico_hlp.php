<?php
include_once '../cadastro/conecta.php';   
include_once '../cadastro/fotos_servico.php';

/**
 *
 * Classe que efetua o cadastro de anuncios
 *
 */

class Tools_Cad_Servico_Hlp extends conecta {

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
   private $filtro_palavra_chave;
   private $mais_palavras;
   private $endereco;

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

   public function get_filtro_palavra_chave() {
      return $this->filtro_palavra_chave;
   }

   public function set_filtro_palavra_chave( $valor ) {
      $this->filtro_palavra_chave = $valor;
   } 
 
   public function get_mais_palavras() {
      return $this->mais_palavras;
   }

   public function set_mais_palavras( $valor ) {
      $this->mais_palavras = $valor;
   }
   
    public function get_endereco() {
      return $this->endereco;
   }

   public function set_endereco( $valor ) {
      $this->endereco = $valor;
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
                  tbservico.palavras,
                  tbservico.mais_palavras,
                  tbservico.id_logradouro,
                  tbtipo_servico.tiposervico,                  
                  tbusuario.id_usuario,
                  tbusuario.apelido,
                  tbusuario.email,
                  tbusuario.ddd,
                  tbusuario.telefone,
                  tbusuario.apelido,
                  tblogradouro.cep,
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco
               FROM 
                  tbservico
                     JOIN tbtipo_servico ON (tbtipo_servico.id_tipo_servico=tbservico.id_tipo_servico)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbservico.id_logradouro)
               WHERE
                  $filtro
               $ordem 
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $consulta = $stmt->fetchAll(PDO::FETCH_CLASS);
   } // obter_anuncios


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
                      mais_palavras   = :mais_palavras,
                      id_logradouro   = :id_logradouro,
                      ativo           = :ativo,
                      id_logradouro   = :id_logradouro,
                      data_atualizacao= :data_atualizacao
                WHERE id_servico = :id_servico";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_servico'       => $id_servico,
                                ':titulo'           => $this->get_titulo(),
                                ':descricao'        => $this->get_descricao(),
                                ':id_tipo_servico'  => $this->get_id_tipo_servico(),
                                ':palavras'         => $palavras,
                                ':id_logradouro'    => $this->get_id_logradouro(),
                                ':mais_palavras'    => $this->get_mais_palavras(),
                                ':ativo'            => $this->get_ativo(),
                                ':id_logradouro'    => $this->get_id_logradouro(),
                                ':data_atualizacao' =>  $this->get_data_atualizacao()
                              ));
          
         $fotos = new Fotos_Servico();
         $fotos->tratar_fotos_apos_alteracao( $this->get_id_servico(), $this->get_data_cadastro() );
         $this->tem_erro = '';
 
      } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
          $this->tem_erro = $e->getMessage();           
      }   
      
      return null;
   } // alterar

  function obter_palavras() {
      $endereco = explode( ',', $this->get_endereco() );
      $endereco_completo = trim($endereco[0]).','.trim($endereco[1]).','.trim($endereco[2]).'_';

      $palavras = $endereco_completo.','.$this->get_titulo();      
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
      $dir_fotos  = str_replace( 'tools','fotos/', dirname(__FILE__) );
      $pasta      = $dir_fotos.date("d_m_Y", strtotime($this->data_cadastro)).'/';
      $fotos      = glob($pasta.$id_servico."_*"); 
      foreach ( $fotos as $foto ) {
         unlink($foto);         
      }
   }

   public function obter_tipo_servico(&$tipos, $id_tipo_servico=null ) {  
      $filtro = $id_tipo_servico!='' ? "WHERE id_tipo_servico=$id_tipo_servico" : '';    
      $sql = " SELECT 
                  id_tipo_servico,
                  tiposervico
               FROM 
                  tbtipo_servico
               {$filtro}   
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tipos = $stmt->fetchAll(PDO::FETCH_CLASS); 
   }


   /**
   *
   * Obtém os dados do anúncio
   *
   */   
   public function obter_dados_do_anuncio( &$dados, $id_servico ) {
      $filtro = " tbservico.id_servico = ".$id_servico;
      $sql = " SELECT 
                  tbservico.id_servico,
                  tbusuario.apelido,
                  tbservico.titulo,
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
   } // obter_anuncios

   private function obter_filtro_palavras( &$resultado ) {
      $array = explode( ' ', $this->get_filtro_palavra_chave() );
      $resultado = '';
      foreach ( $array as $palavra ) {
         $resultado .= '+'.$palavra.'* ';
      }
      $resultado = trim($resultado);
   }

} // Tools_Cad_Servico_Hlp


if ( isset($_REQUEST['acao']) && trim($_REQUEST['acao']) != '' ) {
   verifica_acao( $_REQUEST['acao'] );
}

function verifica_acao( $acao ) {
   $instancia = new Tools_Cad_Servico_Hlp();
   switch ( $acao ) {
      case 'obter_categorias':
         $instancia->obter_categorias();
         break;
       
       
      default:
         break;
   }
} // verifica_acao