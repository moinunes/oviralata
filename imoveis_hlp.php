<?php
include_once 'tools/conecta.php';
include_once 'tools/utils.php';

/**
*
* Essa classe auxilia na consulta de imóveis para o site
* 
*/   

         //........... file_put_contents( __DIR__.'/teste.txt', $pasta ."\n" );


class Imoveis_Hlp  extends conecta {

   private $id_imovel;
   private $codigo_imovel;
   private $id_municipio;
   private $id_tipo_imovel;
   private $nomes_bairros;
   private $pagina_atual;
   //private $codigo_imovel;
   //private $titulo;
   //private $descricao;
   //private $proprietario_nome;
   //private $proprietario_dados;
   //private $endereco_imovel;
   //private $valor_imovel;
   //private $valor_condominio;
   //private $valor_iptu;
   //private $valor_laudemio;
   //private $qtd_quartos;
   //private $qtd_banheiro;
   //private $qtd_vaga;
   //private $area_util;
   //private $area_total;
   //private $tem_escritura;
   //private $idade_imovel;
   //private $data_cadastro;
   //private $ativo;
   //private $id_domicilio_imovel;
   //private $imovel_cep;
   //private $imovel_numero;
   //private $imovel_complemento;
   

   public function get_id_tipo_imovel() {
      return $this->id_tipo_imovel;
   }

   public function set_id_tipo_imovel( $valor ) {
      $this->id_tipo_imovel = $valor;
   }

   public function get_id_imovel() {
      return $this->id_imovel;
   }

   public function set_id_imovel( $valor ) {
      $this->id_imovel = $valor;
   }

   public function get_codigo_imovel() {
      return $this->codigo_imovel;
   }

   public function set_codigo_imovel( $valor ) {
      $this->codigo_imovel = $valor;
   }

   public function get_id_municipio() {
      return $this->id_municipio;
   }

   public function set_id_municipio( $valor ) {
      $this->id_municipio = $valor;
   }

   public function get_nomes_bairros() {
      return $this->nomes_bairros;
   }

   public function set_nomes_bairros( $valor ) {
      $this->nomes_bairros = $valor;
   }

   public function get_pagina_atual() {
      return $this->pagina_atual;
   }

   public function set_pagina_atual( $valor ) {
      $this->pagina_atual = $valor;
   }

   /**
   *
   * Obtém os imóveis
   *
   */   
   public function obter_imoveis( &$imoveis ) {
      $filtro = "1=1";      
      if ( $this->get_id_tipo_imovel() != '' ) {
         $filtro .= " AND tbimovel.id_tipo_imovel = ".$this->get_id_tipo_imovel();
      }
      if ( $this->get_id_imovel() != '' ) {
         $filtro .= " AND id_imovel = ".$this->get_id_imovel();
      }
      if ( $this->get_codigo_imovel() != '' ) {
         $filtro .= " AND id_imovel = ".$this->get_codigo_imovel();
      }
      if ( $this->get_id_municipio() != '' ) {
         $filtro .= " AND tbmunicipio.id_municipio = ".$this->get_id_municipio();
      }
      
      if ( $this->get_nomes_bairros() != '' ) {
         $filtro_bairro = '';
         $nomes_bairros = explode( ',', $this->get_nomes_bairros(), -1 );         
         foreach ( $nomes_bairros as $i => $bairro ) {
            $nome_bairro = trim($bairro);
            $operador = ( $i+1 < count($nomes_bairros) ) ? ' OR ' : ' ';
            if ($nome_bairro!='') {
               $filtro_bairro .= " tbbairro.nome_bairro='{$bairro}' {$operador} ";
            }     
         }         
         $filtro .= ' AND '.$filtro_bairro;
      }

      //.. total de registros
      $sql = " SELECT       
                  count(*) AS total_registros
               FROM 
                  tbimovel
                     JOIN tbtipo_imovel ON (tbtipo_imovel.id_tipo_imovel=tbimovel.id_tipo_imovel)
                     JOIN tbdomicilio ON (tbimovel.id_domicilio_imovel=tbdomicilio.id_domicilio)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbdomicilio.id_logradouro)
                           JOIN tbbairro ON (tbbairro.id_bairro=tblogradouro.id_bairro)
                              JOIN tbmunicipio ON (tbmunicipio.id_municipio=tbbairro.id_municipio)
               WHERE
                  $filtro";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $imoveis = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->total_registros = (int)$imoveis['total_registros'];
      
      $do = Utils::configura_paginador( $this->total_registros, $this->get_pagina_atual() ) ;
      $this->set_pagina_atual( $do->pagina_atual );
      $this->qtd_paginas = $do->qtd_paginas;

      $sql = " SELECT 
                  tbimovel.id_imovel,
                  tbimovel.id_tipo_imovel,
                  tbimovel.id_imovel AS codigo_imovel,      
                  tbimovel.titulo,
                  tbimovel.descricao,                  
                  tbimovel.endereco_imovel,
                  tbimovel.valor_imovel,
                  tbimovel.valor_condominio,
                  tbimovel.valor_iptu,
                  tbimovel.valor_laudemio,
                  tbimovel.qtd_quartos,
                  tbimovel.qtd_banheiro,
                  tbimovel.qtd_vaga,
                  tbimovel.qtd_suite,
                  tbimovel.area_util,
                  tbimovel.area_total,
                  tbimovel.idade_imovel,
                  tbimovel.data_cadastro,      
                  tbimovel.id_domicilio_imovel,                  
                  tbimovel.lavanderia,
                  tbimovel.salao_festa,
                  tbimovel.churrasqueira,
                  tbimovel.academia,
                  tbimovel.piscina,
                  tbimovel.ar_condicionado,
                  tbimovel.prox_mercado,
                  tbimovel.prox_hospital,
                  tbtipo_imovel.tipo_imovel,
                  tbmunicipio.nome_municipio,
                  tbbairro.nome_bairro
               FROM 
                  tbimovel
                     JOIN tbtipo_imovel ON (tbtipo_imovel.id_tipo_imovel=tbimovel.id_tipo_imovel)
                     JOIN tbdomicilio ON (tbimovel.id_domicilio_imovel=tbdomicilio.id_domicilio)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbdomicilio.id_logradouro)
                           JOIN tbbairro ON (tbbairro.id_bairro=tblogradouro.id_bairro)
                              JOIN tbmunicipio ON (tbmunicipio.id_municipio=tbbairro.id_municipio)
               WHERE
                  $filtro
               LIMIT $do->inicio_exibir, $do->exibir   
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $imoveis = $stmt->fetchAll(PDO::FETCH_CLASS);      

      //print '<pre>'; print_r($stmt->rowCount());
            //print '<pre>'; print_r($imoveis);
      
   } // obter_imoveis

   /**
   *
   * Obtém os nomes das imagens do imóvel
   *
   */   
   public function obter_nomes_imagens( &$imagens, $id_imovel ) {
      $imagens = array();
      $pasta = dirname(__FILE__).'/fotos/'.$id_imovel; 
      if ( is_dir($pasta) ) {
         $fotos = array_slice( scandir($pasta), 2 );      
         foreach ( $fotos as $foto ) {
            if ( substr($foto,0,2)!='t_' ) {
               $imagens[] = $foto;
            }
         }
      }
   } // obter_nomes_imagens

} // Imoveis_Hlp
