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
   private $valor_imovel;
   
   //private $codigo_imovel;
   //private $titulo;
   //private $descricao;
   //private $proprietario_nome;
   //private $proprietario_dados;
   //private $endereco_imovel;
   
   //private $valor_condominio;
   //private $valor_iptu;
   //private $valor_laudemio;
   private $qtd_quartos;
   private $qtd_banheiro;
   private $qtd_vaga;
   private $area_util;
   private $area_total;
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

   public function get_valor_imovel() {
      return $this->valor_imovel;
   }

   public function set_valor_imovel( $valor ) {
      $this->valor_imovel = $valor;
   }

   public function get_qtd_quartos() {
      return $this->qtd_quartos;
   }

   public function set_qtd_quartos( $valor ) {
      $this->qtd_quartos = $valor;
   }  

   public function get_qtd_vaga() {
      return $this->qtd_vaga;
   }

   public function set_qtd_vaga( $valor ) {
      $this->qtd_vaga = $valor;
   }

   public function get_area_util() {
      return $this->area_util;
   }

   public function set_area_util( $valor ) {
      $this->area_util = $valor;
   }

   public function get_area_total() {
      return $this->area_total;
   }

   public function set_area_total( $valor ) {
      $this->area_total = $valor;
   }

   public function get_qtd_banheiro() {
      return $this->qtd_banheiro;
   }

   public function set_qtd_banheiro( $valor ) {
      $this->qtd_banheiro = $valor;
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
      if ( $this->get_valor_imovel() != '' ) {
         $valor_imovel = str_replace( '.', '', trim($this->get_valor_imovel()) );
         $valor_imovel = str_replace( ',', '.', $valor_imovel );
         $filtro .= " AND tbimovel.valor_imovel <= ".$valor_imovel;
      }
      if ( $this->get_qtd_quartos() > 0 ) {         
         $filtro .= " AND tbimovel.qtd_quartos >= ".$this->get_qtd_quartos();
      }
      if ( $this->get_qtd_vaga() > 0 ) {         
         $filtro .= " AND tbimovel.qtd_vaga >= ".$this->get_qtd_vaga();
      }
      if ( $this->get_qtd_banheiro() > 0 ) {         
         $filtro .= " AND tbimovel.qtd_banheiro >= ".$this->get_qtd_banheiro();
      }
      if ( $this->get_area_util() > 0 ) {         
         $filtro .= " AND tbimovel.area_util >= ".$this->get_area_util();
      }


      if ( $this->get_nomes_bairros() != '' ) {
         $filtro_bairro = '';
         $nomes_bairros = explode( ',', $this->get_nomes_bairros(), -1 );         
         foreach ( $nomes_bairros as $i => $bairro ) {
            $nome_bairro = trim($bairro);
            $operador = ( $i+1 < count($nomes_bairros) ) ? ' OR ' : ' ';
            if ($nome_bairro!='') {
               $filtro_bairro .= " tbbairro.nome_bairro='{$nome_bairro}' {$operador} ";               
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

     // print $sql;
     // print '<pre>'; print_r($stmt->rowCount());
     // print '<pre>'; print_r($imoveis);
      
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
