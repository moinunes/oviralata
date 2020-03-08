<?php
include_once '../cadastro/conecta.php';   
include_once '../cadastro/fotos_mural.php';


/**
 *
 * Classe que efetua o cadastro - Mural da Fama
 *
 */

class Tools_Cad_Mural_Fama_Hlp extends conecta {

   private $id_mural_fama;
   private $id_usuario;
   private $titulo;
   private $descricao;
   private $data_cadastro;
   private $filtro_palavra_chave;
   private $mais_palavras;
   private $ativo;
   private $endereco;

   public function get_id_mural_fama() {
      return $this->id_mural_fama;
   }

   public function set_id_mural_fama( $valor ) {
      $this->id_mural_fama = $valor;
   }

   public function get_id_usuario() {
      return $this->id_usuario;
   }

   public function set_id_usuario( $valor ) {
      $this->id_usuario = $valor;
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

   public function get_ativo() {
      return $this->ativo;
   }

   public function set_ativo( $valor ) {
      $this->ativo = $valor;
   }

   /**
   *
   * Obtém os dados do mural da fama do usuário logado
   *
   */   
   public function obter_dados_mural( &$dados ) {
      $filtro = "1=1 ";
      if ( $this->get_id_usuario() ) {
         $filtro = " tbmural_fama.id_usuario = ".$this->get_id_usuario();
      }
      if ( $this->get_id_mural_fama() ) {
         $filtro = " tbmural_fama.id_mural_fama = ".$this->get_id_mural_fama();
      }

      if ( $this->get_filtro_palavra_chave() != '' ) {
         $this->obter_filtro_palavras( $palavras );
         $filtro .= " AND MATCH ( palavras,mais_palavras ) AGAINST ( '".$palavras."'".  " IN BOOLEAN MODE )";
      }
      
      $ordem = ' ORDER BY tbmural_fama.data_atualizacao DESC ';
      
      $sql = " SELECT 
                  tbmural_fama.id_mural_fama,
                  tbmural_fama.titulo,
                  tbmural_fama.descricao,
                  tbmural_fama.palavras,
                  tbmural_fama.mais_palavras,
                  tbmural_fama.data_cadastro,
                  tbmural_fama.data_atualizacao,
                  tbmural_fama.ativo,
                  tbusuario.id_logradouro,
                  tbusuario.id_usuario,
                  tbusuario.ddd,
                  tbusuario.telefone,
                  tbusuario.apelido,
                  tbusuario.email,
                  tblogradouro.cep,                  
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco
               FROM 
                  tbmural_fama
                     JOIN tbusuario ON (tbusuario.id_usuario=tbmural_fama.id_usuario)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro)
               WHERE $filtro 
               $ordem 
               LIMIT 100
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $dados = $stmt->fetchAll(PDO::FETCH_CLASS);      
   } // obter_dados_mural

   
   /**
   *
   * Alterar o anúncio
   *
   */
   function alterar() {      
      $id_mural_fama = explode( '_', $this->get_id_mural_fama(), 2 );
      $id_mural_fama = $id_mural_fama[1];
      
      $palavras = $this->obter_palavras();

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = " UPDATE tbmural_fama 
                  SET titulo          = :titulo,
                      descricao       = :descricao,
                      palavras        = :palavras,
                      mais_palavras   = :mais_palavras,
                      ativo           = :ativo,
                      data_atualizacao= :data_atualizacao
                WHERE id_mural_fama = :id_mural_fama";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_mural_fama'    => $id_mural_fama,
                                ':titulo'           => $this->get_titulo(),
                                ':descricao'        => $this->get_descricao(),
                                ':palavras'         => $palavras,
                                ':mais_palavras'    => $this->get_mais_palavras(),
                                ':ativo'            => $this->get_ativo(),
                                ':data_atualizacao' => $this->get_data_atualizacao()
                              ));
          
         $fotos = new Fotos_Mural_Fama();
         $fotos->tratar_fotos_apos_alteracao( $this->get_id_mural_fama(), $this->get_data_cadastro() );
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
         
         $sql = " DELETE FROM tbmural_fama                 
                  WHERE id_mural_fama={$this->get_id_mural_fama()} ";
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
      $id_mural_fama = $this->get_id_mural_fama();
      $dir_fotos  = str_replace( 'tools','fotos_mural/', dirname(__FILE__) );
      $pasta      = $dir_fotos.date("d_m_Y", strtotime($this->data_cadastro)).'/';
      $fotos      = glob($pasta.$id_mural_fama."_*");
      foreach ( $fotos as $foto ) {
         unlink($foto);         
      }
   }

   private function obter_filtro_palavras( &$resultado ) {
      $array = explode( ' ', $this->get_filtro_palavra_chave() );
      $resultado = '';
      foreach ( $array as $palavra ) {
         $resultado .= '+'.$palavra.'* ';
      }
      $resultado = trim($resultado);
   }

} // Tools_Cad_Mural_Fama_Hlp


if ( isset($_REQUEST['acao']) && trim($_REQUEST['acao']) != '' ) {
   verifica_acao( $_REQUEST['acao'] );
}

function verifica_acao( $acao ) {
   $instancia = new Tools_Cad_Mural_Fama_Hlp();
   switch ( $acao ) {
      case 'obter_categorias':
         $instancia->obter_categorias();
         break;
       
       case 'obter_racas':
         $instancia->obter_racas();
         break;

      default:
         break;
   }
} // verifica_acao