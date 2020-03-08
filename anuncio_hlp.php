<?php
include_once 'cadastro/conecta.php';
include_once 'cadastro/utils.php';

/**
*
* Essa classe auxilia na consulta dos anúncios para o site
* 
*/   

class Anuncio_Hlp  extends conecta {

   private $id_anuncio;
   private $id_municipio;
   private $id_tipo_anuncio;
   private $pagina_atual;
   private $tipo_anuncio;
   private $filtro_palavra_chave;
   
   public function get_id_tipo_anuncio() {
      return $this->id_tipo_anuncio;
   }

   public function set_id_tipo_anuncio( $valor ) {
      $this->id_tipo_anuncio = $valor;
   }

   public function get_id_anuncio() {
      return $this->id_anuncio;
   }

   public function set_id_anuncio( $valor ) {
      $this->id_anuncio = $valor;
   }

   public function get_id_municipio() {
      return $this->id_municipio;
   }

   public function set_id_municipio( $valor ) {
      $this->id_municipio = $valor;
   }

   public function get_pagina_atual() {
      return $this->pagina_atual;
   }

   public function set_pagina_atual( $valor ) {
      $this->pagina_atual = $valor;
   }

   public function get_filtro_palavra_chave() {
      return $this->filtro_palavra_chave;
   }

   public function set_filtro_palavra_chave( $valor ) {
      $this->filtro_palavra_chave = $valor;
   }

   public function get_tipo_anuncio() {
      return $this->tipo_anuncio;
   }

   public function set_tipo_anuncio( $valor ) {
      $this->tipo_anuncio = $valor;
   }
 
  /**
   *
   * Obtém os imóveis
   *
   */   
   public function obter_anuncios( &$anuncios ) {

      $filtro = "1=1 AND tbanuncio.ativo='S' ";
      if ( $this->get_id_anuncio() != '' ) {
         $filtro .= " AND tbanuncio.id_anuncio = ".$this->get_id_anuncio();
      }
      if ( $this->get_filtro_palavra_chave() != '' ) {
         $this->obter_filtro_palavras( $palavras );
         $filtro .= " AND MATCH ( palavras,mais_palavras ) AGAINST ( '".$palavras."'  IN BOOLEAN MODE)";
      }
      if ( $this->get_id_municipio() != '' ) {
         $filtro .= " AND tbmunicipio.id_municipio = ".$this->get_id_municipio();
      }
      if ( $this->get_tipo_anuncio() != '' ) {
         $filtro .= " AND tbtipo_anuncio.codigo ='petperdido' ";
      }


      //.. ordenar
      $ordem = ' ORDER BY tbanuncio.data_atualizacao DESC';     

      //.. total de registros
      $sql = " SELECT       
                  count(*) AS total_registros
               FROM 
                  tbanuncio
                     JOIN tbtipo_anuncio ON (tbtipo_anuncio.id_tipo_anuncio=tbanuncio.id_tipo_anuncio)
                     LEFT JOIN tbraca ON (tbraca.id_raca=tbanuncio.id_raca)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbanuncio.id_usuario)
                     JOIN tbcategoria ON (tbcategoria.id_categoria=tbanuncio.id_categoria)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbanuncio.id_logradouro)
                  WHERE $filtro
                  $ordem";  
      $stmt = $this->con->prepare( $sql );      
      $stmt->execute();
      $consulta_anuncio = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->total_registros = (int)$consulta_anuncio['total_registros'];
      $do = Utils::configura_paginador( $this->total_registros, $this->get_pagina_atual() ) ;
      $this->set_pagina_atual( $do->pagina_atual );
      $this->qtd_paginas = $do->qtd_paginas;

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
                  tbtipo_anuncio.codigo,
                  tbraca.raca,
                  tbusuario.email,
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,
                  tbusuario.exibir_tea,
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
               LIMIT $do->inicio_exibir, $do->exibir
             ";
             //Utils::Dbga_Abort($sql);
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $anuncios = $stmt->fetchAll(PDO::FETCH_CLASS);

   } // obter_anuncios

   
   private function obter_filtro_palavras( &$resultado ) {
      $array = explode( ' ', $this->get_filtro_palavra_chave() );
      $resultado = '';
      foreach ( $array as $palavra ) {
         $resultado .= '+'.$palavra.'*';
      }
      $resultado = trim($resultado);
   }

} // Anuncio_Hlp
