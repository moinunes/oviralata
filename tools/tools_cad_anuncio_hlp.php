<?php
include_once '../cadastro/conecta.php';   
include_once '../cadastro/fotos.php';

/**
 *
 * Classe que efetua o cadastro de anuncios
 *
 */

class Tools_Cad_Anuncio_Hlp extends conecta {

   private $id_anuncio;
   private $id_tipo_anuncio;
   private $id_categoria;
   private $id_raca;
   private $id_usuario;
   private $codigo_anuncio;
   private $titulo;
   private $descricao;
   private $mais_palavras;
   private $data_cadastro;
   private $data_atualizacao;
   private $cep;
   private $id_logradouro;
   private $ativo;
   private $filtro_palavra_chave;
   private $endereco;

   public function get_id_anuncio() {
      return $this->id_anuncio;
   }

   public function set_id_anuncio( $valor ) {
      $this->id_anuncio = $valor;
   }

   public function get_id_usuario() {
      return $this->id_usuario;
   }

   public function set_id_usuario( $valor ) {
      $this->id_usuario = $valor;
   }

   public function get_id_tipo_anuncio() {
      return $this->id_tipo_anuncio;
   }

   public function set_id_tipo_anuncio( $valor ) {
      $this->id_tipo_anuncio = $valor;
   }

   public function get_id_categoria() {
      return $this->id_categoria;
   }

   public function set_id_categoria( $valor ) {
      $this->id_categoria = $valor;
   }  

   public function get_id_raca() {
      return $this->id_raca;
   }

   public function set_id_raca( $valor ) {
      $this->id_raca = $valor;
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

   public function get_ativo() {
      return $this->ativo;
   }

   public function set_ativo( $valor ) {
      $this->ativo = $valor;
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

   public function get_endereco() {
      return $this->endereco;
   }

   public function set_endereco( $valor ) {
      $this->endereco = $valor;
   }

   public function get_mais_palavras() {
      return $this->mais_palavras;
   }

   public function set_mais_palavras( $valor ) {
      $this->mais_palavras = $valor;
   }

   /**
   *
   * Obtém os anúncios
   *
   */   
   public function obter_anuncios( &$anuncios ) {
      $filtro = "1=1 ";
      if ( $this->get_id_anuncio() != '' ) {
         $filtro .= " AND tbanuncio.id_anuncio = ".$this->get_id_anuncio();
      }
      if ( $this->get_id_usuario() != '' ) {
         $filtro .= " AND tbanuncio.id_usuario = ".$this->get_id_usuario();
      }
      if ( $this->get_ativo() != '' ) {
         $filtro .= " AND tbanuncio.ativo = '".$this->get_ativo()."'";
      }

      if ( $this->get_filtro_palavra_chave() != '' ) {
         $this->obter_filtro_palavras( $palavras );
         $filtro .= " AND MATCH ( palavras,mais_palavras ) AGAINST ( '".$palavras."'".  " IN BOOLEAN MODE )";
      }

      $ordem = ' ORDER BY tbanuncio.data_atualizacao DESC ';
   
      $sql = " SELECT 
                  tbanuncio.id_anuncio,
                  tbanuncio.id_tipo_anuncio,
                  tbanuncio.id_categoria,
                  tbanuncio.id_raca,
                  tbanuncio.id_usuario,                  
                  tbanuncio.titulo,
                  tbanuncio.descricao,
                  tbanuncio.palavras,
                  tbanuncio.mais_palavras,
                  tbanuncio.data_cadastro,
                  tbanuncio.data_atualizacao,
                  tbanuncio.ativo,
                  tbanuncio.id_logradouro,
                  tblogradouro.municipio,
                  tblogradouro.bairro,
                  tblogradouro.uf,
                  tbtipo_anuncio.tipo_anuncio,
                  tbtipo_anuncio.codigo,
                  tbraca.raca,
                  tbusuario.email,
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,
                  tbusuario.apelido,
                  tbcategoria.categoria,
                  tbcategoria.codigo,
                  tblogradouro.cep,
                  CONCAT( tblogradouro.bairro,', ',trim(tblogradouro.municipio),', ',tblogradouro.uf) AS endereco
               FROM 
                  tbanuncio
                     JOIN tbtipo_anuncio ON (tbtipo_anuncio.id_tipo_anuncio=tbanuncio.id_tipo_anuncio)
                     LEFT JOIN tbraca ON (tbraca.id_raca=tbanuncio.id_raca)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbanuncio.id_usuario)
                     JOIN tbcategoria ON (tbcategoria.id_categoria=tbanuncio.id_categoria)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbanuncio.id_logradouro)
               WHERE
                  $filtro
               $ordem 
               LIMIT 100
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $anuncios = $stmt->fetchAll(PDO::FETCH_CLASS);
   } // obter_anuncios

   /**
   *
   * Alterar o anúncio
   *
   */
   function alterar() {      
      $id_raca    = trim($this->get_id_raca())=='' ? NULL : $this->get_id_raca();
      $id_anuncio = explode( '_', $this->get_id_anuncio(), 2 );
      $id_anuncio = $id_anuncio[1];

      $palavras = $this->obter_palavras();
  
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = " UPDATE tbanuncio 
                  SET id_tipo_anuncio  = :id_tipo_anuncio,
                      id_categoria     = :id_categoria,
                      id_raca          = :id_raca,
                      titulo           = :titulo,
                      descricao        = :descricao,
                      palavras         = :palavras,
                      mais_palavras    = :mais_palavras,
                      id_logradouro    = :id_logradouro,
                      ativo            = :ativo,
                      data_atualizacao = :data_atualizacao
                WHERE id_anuncio = :id_anuncio";
         $stmt = $this->con->prepare($sql);
         $stmt->execute( array( ':id_anuncio'       => $id_anuncio,
                                ':id_tipo_anuncio'  => $this->get_id_tipo_anuncio(),
                                ':id_categoria'     => $this->get_id_categoria(),
                                ':id_raca'          => $id_raca,
                                ':titulo'           => $this->get_titulo(),
                                ':descricao'        => $this->get_descricao(),
                                ':palavras'         => $palavras,
                                ':mais_palavras'    => $this->get_mais_palavras(),
                                ':id_logradouro'    => $this->get_id_logradouro(),
                                ':ativo'            => $this->get_ativo(),
                                ':data_atualizacao' => $this->get_data_atualizacao()
                              ));
          
         $fotos = new Fotos();
         $fotos->tratar_fotos_apos_alteracao( $this->get_id_anuncio(), $this->get_data_cadastro() );
         $this->tem_erro = '';
 
      } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
          $this->tem_erro = $e->getMessage();           
      }   
      
      return null;
   } // alterar

   function obter_palavras() {
      $str_tipo      = ''; 
      $str_categoria = '';
      $str_raca      = '';

      //.. tipo
      $this->obter_tipo_anuncio( $tipo, $this->get_id_tipo_anuncio() );
      if ( $tipo[0]->tipo_anuncio=='Doação' ) {
         $str_tipo = $tipo[0]->tipo_anuncio;
      } else if (  $tipo[0]->tipo_anuncio=='Pet Perdido' ) {
         $str_tipo = $tipo[0]->tipo_anuncio.'-desaparecido';      
      }

      //.. categoria
      $this->obter_categoria( $categoria, $this->get_id_categoria() );
      if ( $categoria[0]->codigo == 'cao' ) {
         $str_categoria = "{$categoria[0]->codigo}-caes-cachorros";
      } else if ( $categoria[0]->codigo == 'gato' ) {
         $str_categoria = "{$categoria[0]->codigo}s-felinos";
      } else if ( $categoria[0]->codigo == 'outropet' ) {
         $str_categoria = "outros pets";
      } else if ( $categoria[0]->codigo == 'acessorios' ) {
         $str_categoria = "acessorios-produtos";
      }
      
      //.. raca
      $this->obter_raca( $raca, $this->get_id_raca() );
      if ( $raca ) { 
         if ( $raca->raca == 'Sem Raça Definida' ) {
            $str_raca = "{$raca->raca}-srd";
         } else {
            $str_raca = "{$raca->raca}";
         }     
      }   

      $endereco = explode( ',', $this->get_endereco() );
      $endereco_completo = trim($endereco[0]).','.trim($endereco[1]).','.trim($endereco[2]).'_';

      $palavras = $endereco_completo.','.$str_tipo.','.$str_categoria.','.$str_raca;      
      $palavras = strtolower($palavras);
      
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
         $sql = " DELETE FROM tbanuncio                 
                  WHERE id_anuncio={$this->get_id_anuncio()} ";
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
      $id_anuncio = $this->get_id_anuncio();
      $dir_fotos  = str_replace( 'tools','fotos/', dirname(__FILE__) );
      $pasta      = $dir_fotos.date("d_m_Y", strtotime($this->data_cadastro)).'/';
      $fotos      = glob($pasta.$id_anuncio."_*"); 
      foreach ( $fotos as $foto ) {
         unlink($foto);         
      }
   }

   public function obter_tipo_anuncio(&$tipos, $id_tipo_anuncio=null ) {  
      $filtro = $id_tipo_anuncio!='' ? "WHERE id_tipo_anuncio=$id_tipo_anuncio" : '';    
      $sql = " SELECT 
                  id_tipo_anuncio,
                  tipo_anuncio,
                  codigo
               FROM 
                  tbtipo_anuncio
               {$filtro}   
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tipos = $stmt->fetchAll(PDO::FETCH_CLASS); 
   }

   /**
   * Obtém todas as categorias
   * obs: 
   */   
   public function obter_categoria(&$resultado, $id_categoria=null ) {
      $filtro = $id_categoria!='' ? "WHERE id_categoria=$id_categoria" : ''; 
      $sql = " SELECT
                  id_categoria,
                  categoria,
                  codigo
               FROM 
                  tbcategoria
               {$filtro}   
               ORDER BY id_categoria   
            ";  
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);
   }

   /**
   * Obtém todas as racas
   * obs: 
   */   
   public function obter_todas_racas( &$racas, $id_categoria=null ) {
      $filtro  = '1=1';
      if ( $id_categoria != '' ) {
         $filtro .= " AND tbraca.id_categoria = ".$id_categoria;
      }
      $sql = " SELECT
                  id_raca,
                  raca,
                  id_categoria
               FROM 
                  tbraca
               WHERE
                  $filtro   
            ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $racas = $stmt->fetchAll(PDO::FETCH_CLASS);
   }   

   /**
   * Obtém as raças
   *
   */   
   public function obter_racas() {
      $id_categoria = $_REQUEST['id_categoria'];
      $sql = " SELECT
                  id_raca,
                  raca
               FROM 
                  tbraca
                     JOIN tbcategoria ON (tbcategoria.id_categoria=tbraca.id_categoria)
               WHERE tbraca.id_categoria={$id_categoria}
            ";            
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $raca = $stmt->fetchAll(PDO::FETCH_CLASS);
      foreach ( $raca as $key => $item ) {
         $racas[] = array( 'id_raca' => $item->id_raca,
                           'raca'    => $item->raca
                         );
      }
      echo(json_encode($racas));
   }

   /**
   * Obtém raça
   *
   */   
   public function obter_raca(&$resultado, $id_raca ) {
      $sql = " SELECT
                  id_raca,
                  raca
               FROM 
                  tbraca
               WHERE tbraca.id_raca={$id_raca}
            ";            
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_OBJ);
   }

   /**
   * Obtém as categorias
   * obs: 
   */   
   public function obter_categorias() {
      $id_tipo_anuncio = $_REQUEST['id_tipo_anuncio'];
      $sql = " SELECT
                  tipo_anuncio,
                  codigo
               FROM 
                  tbtipo_anuncio
               WHERE id_tipo_anuncio={$id_tipo_anuncio}
            ";  
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tipo = $stmt->fetch(PDO::FETCH_OBJ);
      
      if ( trim($tipo->codigo)=='doacao' ) {
         $filtro = '1=1';   
      } else if ( trim($tipo->codigo)=='petperdido' ) {
         $filtro = "codigo='cao' OR codigo='gato' OR codigo='outropet'";
      }      
      
      //..
      $sql = " SELECT 
                  id_categoria,
                  categoria,
                  codigo
               FROM 
                  tbcategoria
               WHERE {$filtro}
               ORDER BY id_categoria 
           ";    
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);              
      foreach ( $resultado as $key => $item ) {
         $categorias[] = array( 'id_categoria' => $item->id_categoria,
                                'categoria'    => $item->categoria,
                                'codigo'       => $item->codigo
                              );
      }      
      echo(json_encode($categorias));
   } // obter_categorias


   /**
   *
   * Obtém os dados do anúncio
   *
   */   
   public function obter_dados_do_anuncio( &$dados, $id_anuncio ) {
      $filtro = " tbanuncio.id_anuncio = ".$id_anuncio;
      $sql = " SELECT 
                  tbanuncio.id_anuncio,
                  tbusuario.apelido,
                  tbanuncio.titulo,
                  tbusuario.email
               FROM 
                  tbanuncio
                     JOIN tbusuario ON (tbusuario.id_usuario=tbanuncio.id_usuario)
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

} // Tools_Cad_Anuncio_Hlp


if ( isset($_REQUEST['acao']) && trim($_REQUEST['acao']) != '' ) {
   verifica_acao( $_REQUEST['acao'] );
}

function verifica_acao( $acao ) {
   $instancia = new Tools_Cad_Anuncio_Hlp();
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