<?php
include_once 'cadastro/conecta.php';
include_once 'cadastro/utils.php';

/**
*
* Essa classe auxilia na consulta dos anúncios para o site
* 
*/   

class Servico_Hlp  extends conecta {

   private $id_servico;
   private $id_municipio;
   private $id_tipo_servico;
   private $pagina_atual; 
   private $filtro_palavra_chave;
   
   public function get_id_tipo_servico() {
      return $this->id_tipo_servico;
   }

   public function set_id_tipo_servico( $valor ) {
      $this->id_tipo_servico = $valor;
   }

   public function get_id_servico() {
      return $this->id_servico;
   }

   public function set_id_servico( $valor ) {
      $this->id_servico = $valor;
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
 
  /**
   *
   * Obtém os imóveis
   *
   */   
   public function obter_servicos( &$anuncios ) {

      $filtro = "1=1 AND tbservico.ativo='S' ";
      if ( $this->get_id_servico() != '' ) {
         $filtro .= " AND tbservico.id_servico = ".$this->get_id_servico();
      }

      if ( $this->get_filtro_palavra_chave() != '' ) {
         $this->obter_filtro_palavras( $palavras );
         $filtro .= " AND MATCH ( palavras,mais_palavras ) AGAINST ( '".$palavras."'  IN BOOLEAN MODE)";
      }

      if ( $this->get_id_municipio() != '' ) {
         $filtro .= " AND tbmunicipio.id_municipio = ".$this->get_id_municipio();
      }

      //.. ordenar
      $ordem = ' ORDER BY tbservico.data_atualizacao DESC';     

      //.. total de registros
      $sql = " SELECT       
                  count(*) AS total_registros
               FROM 
                  tbservico
                     JOIN tbtipo_servico ON (tbtipo_servico.id_tipo_servico=tbservico.id_tipo_servico)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro)
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
                  tbservico.id_servico,                  
                  tbservico.titulo,
                  tbservico.descricao,
                  tbservico.data_cadastro,
                  tbservico.data_atualizacao,
                  tbservico.id_usuario,
                  tblogradouro.municipio,
                  tblogradouro.bairro,
                  tblogradouro.uf,
                  tbtipo_servico.id_tipo_servico,
                  tbtipo_servico.tiposervico,                  
                  tbusuario.email,
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,
                  tbusuario.exibir_tea,
                  tbusuario.apelido                  
               FROM
                  tbservico
                     JOIN tbtipo_servico ON (tbtipo_servico.id_tipo_servico=tbservico.id_tipo_servico)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro) 
                WHERE $filtro
                $ordem    
               LIMIT $do->inicio_exibir, $do->exibir
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $anuncios = $stmt->fetchAll(PDO::FETCH_CLASS);

   } // obter_servicos

   
   private function obter_filtro_palavras( &$resultado ) {
      $array = explode( ' ', $this->get_filtro_palavra_chave() );
      $resultado = '';
      foreach ( $array as $palavra ) {
         $resultado .= '+'.$palavra.'*';
      }
      $resultado = trim($resultado);
   }

} // Servico_Hlp
