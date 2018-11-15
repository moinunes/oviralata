<?php 
include_once 'conecta.php';   
include_once 'endereco_hlp.php';

/**
 *
 * Classe que efetua o cadastro do imóvel
 *
 */

class Cadastro_Hlp_Imovel extends conecta {

   private $id_imovel;
   private $id_tipo_imovel;
   private $codigo_imovel;
   private $titulo;
   private $descricao;
   private $proprietario_nome;
   private $proprietario_dados;
   private $endereco_imovel;
   private $valor_imovel;
   private $valor_condominio;
   private $valor_iptu;
   private $valor_laudemio;
   private $qtd_quartos;
   private $qtd_banheiro;
   private $qtd_vaga;
   private $qtd_suite;
   private $area_util;
   private $area_total;
   private $tem_escritura;
   private $idade_imovel;
   private $data_cadastro;
   private $ativo;
   private $id_domicilio_imovel;
   private $imovel_cep;
   private $imovel_id_logradouro;
   private $imovel_numero;
   private $imovel_complemento;
   private $id_municipio;
      
   private $lavanderia;
   private $salao_festa;
   private $churrasqueira;
   private $academia;
   private $ar_condicionado;
   private $piscina;
   private $prox_mercado;
   private $prox_hospital;



   public function get_id_imovel() {
      return $this->id_imovel;
   }

   public function set_id_imovel( $valor ) {
      $this->id_imovel = $valor;
   }

   public function get_id_tipo_imovel() {
      return $this->id_tipo_imovel;
   }

   public function set_id_tipo_imovel( $valor ) {
      $this->id_tipo_imovel = $valor;
   }  

   public function get_codigo_imovel() {
      return $this->codigo_imovel;
   }

   public function set_codigo_imovel( $valor ) {
      $this->codigo_imovel = $valor;
   }

   public function get_titulo() {
      return $this->titulo;
   }

   public function set_titulo( $valor ) {
      $this->titulo = $valor;
   }

   public function get_proprietario_nome() {
      return $this->proprietario_nome;
   }

   public function set_proprietario_nome( $valor ) {
      $this->proprietario_nome = $valor;
   }

   public function get_proprietario_dados() {
      return $this->proprietario_dados;
   }

   public function set_proprietario_dados( $valor ) {
      $this->proprietario_dados = $valor;
   }

   public function get_valor_imovel() {
      return $this->valor_imovel;
   }

   public function set_valor_imovel( $valor ) {
      $this->valor_imovel = $valor;
   }

   public function get_valor_iptu() {
      return $this->valor_iptu;
   }

   public function set_valor_iptu( $valor ) {
      $this->valor_iptu = $valor;
   }

   public function get_valor_condominio() {
      return $this->valor_condominio;
   }

   public function set_valor_condominio( $valor ) {
      $this->valor_condominio = $valor;
   }

   public function get_valor_laudemio() {
      return $this->valor_laudemio;
   }

   public function set_valor_laudemio( $valor ) {
      $this->valor_laudemio = $valor;
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

   public function get_qtd_suite() {
      return $this->qtd_suite;
   }

   public function set_qtd_suite( $valor ) {
      $this->qtd_suite = $valor;
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

   public function get_endereco_imovel() {
      return $this->endereco_imovel;
   }

   public function set_endereco_imovel( $valor ) {
      $this->endereco_imovel = $valor;
   }  

   public function get_tem_escritura() {
      return $this->tem_escritura;
   }

   public function set_tem_escritura( $valor ) {
      $this->tem_escritura = $valor;
   }

   public function get_idade_imovel() {
      return $this->idade_imovel;
   }

   public function set_idade_imovel( $valor ) {
      $this->idade_imovel = $valor;
   }

   public function get_data_cadastro() {
      return $this->data_cadastro;
   }

   public function set_data_cadastro( $valor ) {
      $this->data_cadastro = $valor;
   }

   public function get_ativo() {
      return $this->ativo;
   }

   public function set_ativo( $valor ) {
      $this->ativo = $valor;
   }

   public function get_descricao() {
      return $this->descricao;
   }

   public function set_descricao( $valor ) {
      $this->descricao = $valor;
   }

   public function get_imovel_cep() {
      return $this->imovel_cep;
   }

   public function set_imovel_cep( $valor ) {
      $this->imovel_cep = $valor;
   }

   public function get_imovel_id_logradouro() {
      return $this->imovel_id_logradouro;
   }

   public function set_imovel_id_logradouro( $valor ) {
      $this->imovel_id_logradouro = $valor;
   }

   public function get_imovel_numero() {
      return $this->imovel_numero;
   }

   public function set_imovel_numero( $valor ) {
      $this->imovel_numero = $valor;
   }

   public function get_imovel_complemento() {
      return $this->imovel_complemento;
   }

   public function set_imovel_complemento( $valor ) {
      $this->imovel_complemento = $valor;
   }

   public function get_id_domicilio_imovel() {
      return $this->id_domicilio_imovel;
   }

   public function set_id_domicilio_imovel( $valor ) {
      $this->id_domicilio_imovel = $valor;
   }

   public function get_id_municipio() {
      return $this->id_municipio;
   }

   public function set_id_municipio( $valor ) {
      $this->id_municipio = $valor;
   }

   public function get_lavanderia() {
      return $this->lavanderia;
   }

   public function set_lavanderia( $valor ) {
      $this->lavanderia = $valor;
   }

   public function get_salao_festa() {
      return $this->salao_festa;
   }

   public function set_salao_festa( $valor ) {
      $this->salao_festa = $valor;
   }

   public function get_churrasqueira() {
      return $this->churrasqueira;
   }

   public function set_churrasqueira( $valor ) {
      $this->churrasqueira = $valor;
   }

   public function get_academia() {
      return $this->academia;
   }

   public function set_academia( $valor ) {
      $this->academia = $valor;
   }
      
   public function get_piscina() {
      return $this->piscina;
   }

   public function set_piscina( $valor ) {
      $this->piscina = $valor;
   }

   public function get_ar_condicionado() {
      return $this->ar_condicionado;
   }

   public function set_ar_condicionado( $valor ) {
      $this->ar_condicionado = $valor;
   }

   public function get_prox_mercado() {
      return $this->prox_mercado;
   }

   public function set_prox_mercado( $valor ) {
      $this->prox_mercado = $valor;
   }

   public function get_prox_hospital() {
      return $this->prox_hospital;
   }

   public function set_prox_hospital( $valor ) {
      $this->prox_hospital = $valor;
   }

   
   /**
    * Inclui o imóvel
    */
   function incluir() {     

      $valor_imovel = 0.00;
      if ( trim($this->get_valor_imovel()) !='' ) {
         $valor_imovel = str_replace( '.', '', trim($this->get_valor_imovel()) );
         $valor_imovel = str_replace( ',', '.', $valor_imovel );
      }

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         // inclui domicilio imóvel
         $this->incluir_domicilio_imovel($id_domicilio_imovel);

         // inclui o imóvel
         $campos = " id_tipo_imovel,                        
                     titulo,
                     descricao,
                     proprietario_nome,
                     proprietario_dados,
                     endereco_imovel,
                     valor_imovel,
                     valor_condominio,
                     valor_iptu,
                     valor_laudemio,
                     qtd_quartos,
                     qtd_banheiro,
                     qtd_vaga,
                     qtd_suite,
                     area_util,
                     area_total,
                     tem_escritura,
                     idade_imovel,
                     ativo,
                     id_domicilio_imovel,
                     lavanderia,
                     salao_festa,
                     churrasqueira,
                     academia,
                     piscina,
                     ar_condicionado,
                     prox_mercado,
                     prox_hospital
                     ";
         $sql = "INSERT INTO tbimovel({$campos})
                 VALUES (:id_tipo_imovel,                      
                         :titulo,
                         :descricao,
                         :proprietario_nome,
                         :proprietario_dados,
                         :endereco_imovel,
                         :valor_imovel,
                         :valor_condominio,
                         :valor_iptu,
                         :valor_laudemio,
                         :qtd_quartos,
                         :qtd_banheiro,
                         :qtd_vaga,
                         :qtd_suite,
                         :area_util,
                         :area_total,
                         :tem_escritura,
                         :idade_imovel,
                         :ativo,
                         :id_domicilio_imovel,
                         :lavanderia,
                         :salao_festa,
                         :churrasqueira,
                         :academia,
                         :piscina,
                         :ar_condicionado,
                         :prox_mercado,
                         :prox_hospital
                  )";
         $stmt = $this->con->prepare($sql);
         $stmt->bindValue(':id_tipo_imovel',      $this->get_id_tipo_imovel(),    PDO::PARAM_INT);      
         $stmt->bindValue(':titulo',              $this->get_titulo(),            PDO::PARAM_STR);
         $stmt->bindValue(':descricao',           $this->get_descricao(),         PDO::PARAM_STR);
         $stmt->bindValue(':proprietario_nome',   $this->get_proprietario_nome(), PDO::PARAM_STR);
         $stmt->bindValue(':proprietario_dados',  $this->get_proprietario_dados(),PDO::PARAM_STR);
         $stmt->bindValue(':endereco_imovel',     $this->get_endereco_imovel(),   PDO::PARAM_STR);
         $stmt->bindValue(':valor_imovel',        $valor_imovel,                  PDO::PARAM_STR);
         $stmt->bindValue(':valor_condominio',    $this->get_valor_condominio(),  PDO::PARAM_STR);
         $stmt->bindValue(':valor_iptu',          $this->get_valor_iptu(),        PDO::PARAM_STR);
         $stmt->bindValue(':valor_laudemio',      $this->get_valor_laudemio(),    PDO::PARAM_STR);
         $stmt->bindValue(':qtd_quartos',         $this->get_qtd_quartos(),       PDO::PARAM_STR);
         $stmt->bindValue(':qtd_banheiro',        $this->get_qtd_banheiro(),      PDO::PARAM_STR);
         $stmt->bindValue(':qtd_vaga',            $this->get_qtd_vaga(),          PDO::PARAM_STR);
         $stmt->bindValue(':qtd_suite',           $this->get_qtd_suite(),         PDO::PARAM_STR);
         $stmt->bindValue(':area_util',           $this->get_area_util(),         PDO::PARAM_STR);
         $stmt->bindValue(':area_total',          $this->get_area_total(),        PDO::PARAM_STR);
         $stmt->bindValue(':tem_escritura',       $this->get_tem_escritura(),     PDO::PARAM_STR);
         $stmt->bindValue(':idade_imovel',        $this->get_idade_imovel(),      PDO::PARAM_STR);
         $stmt->bindValue(':ativo',               $this->get_ativo(),             PDO::PARAM_STR);
         $stmt->bindValue(':id_domicilio_imovel', $id_domicilio_imovel,           PDO::PARAM_INT);

         $stmt->bindValue(':lavanderia',          $this->get_lavanderia(),         PDO::PARAM_STR);
         $stmt->bindValue(':salao_festa',         $this->get_salao_festa(),        PDO::PARAM_STR);
         $stmt->bindValue(':churrasqueira',       $this->get_churrasqueira(),      PDO::PARAM_STR);
         $stmt->bindValue(':academia',            $this->get_academia(),           PDO::PARAM_STR);
         $stmt->bindValue(':piscina',             $this->get_piscina(),            PDO::PARAM_STR);
         $stmt->bindValue(':ar_condicionado',     $this->get_ar_condicionado(),    PDO::PARAM_STR);
         $stmt->bindValue(':prox_mercado',        $this->get_prox_mercado(),       PDO::PARAM_STR);
         $stmt->bindValue(':prox_hospital',       $this->get_prox_hospital(),      PDO::PARAM_STR);

         $stmt->execute();
         $id_movel = $this->con->lastInsertId();
         $this->set_id_imovel($id_movel);
         
         // renomear a pasta de fotos
         $this->renomear_pasta_temporaria($id_movel);

         
      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }      

      return null;
   } // incluir


   /**
    * Inclui o domicilio do imóvel
    */
   function incluir_domicilio_imovel(&$id) {
      $instancia = new Endereco_Hlp();
      $instancia->set_filtro_cep( $this->get_imovel_cep() );
      $instancia->set_filtro_id_logradouro( $this->get_imovel_id_logradouro() );
      $instancia->obter_dados($dados);
      $id_logradouro = $dados[0]['id_logradouro'];

      $campos = " numero, complemento, id_logradouro";
      $sql = "INSERT INTO tbdomicilio({$campos})
              VALUES (:numero, :complemento, :id_logradouro) ";
      $stmt = $this->con->prepare($sql);
      $stmt->bindValue(':numero',        $this->get_imovel_numero(),      PDO::PARAM_STR);      
      $stmt->bindValue(':complemento',   $this->get_imovel_complemento(), PDO::PARAM_STR);
      $stmt->bindValue(':id_logradouro', $id_logradouro,                  PDO::PARAM_INT);      
      $stmt->execute();
      $id = $this->con->lastInsertId();
   } // incluir_domicilio_imovel


   /**
    * Alterar o imóvel
    */
   function alterar() {
      $valor_imovel = 0.00;
      if ( trim($this->get_valor_imovel()) !='' ) {
         $valor_imovel = str_replace( '.', '', trim($this->get_valor_imovel()) );
         $valor_imovel = str_replace( ',', '.', $valor_imovel );
      }
      $descricao =  $this->get_descricao() ;

      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " UPDATE tbimovel
                  SET id_tipo_imovel    ='{$this->get_id_tipo_imovel()}',                      
                      titulo            ='{$this->get_titulo()}',
                      descricao         ='{$descricao}',
                      proprietario_nome ='{$this->get_proprietario_nome()}',
                      proprietario_dados='{$this->get_proprietario_dados()}',
                      endereco_imovel   ='{$this->get_endereco_imovel()}',
                      valor_imovel      ='{$valor_imovel}',
                      valor_condominio  ='{$this->get_valor_condominio()}',
                      valor_iptu        ='{$this->get_valor_iptu()}',
                      valor_laudemio    ='{$this->get_valor_laudemio()}',
                      qtd_quartos       ='{$this->get_qtd_quartos()}',
                      qtd_banheiro      ='{$this->get_qtd_banheiro()}',
                      qtd_vaga          ='{$this->get_qtd_vaga()}',
                      qtd_suite         ='{$this->get_qtd_suite()}',
                      area_util         ='{$this->get_area_util()}',
                      area_total        ='{$this->get_area_total()}',
                      tem_escritura     ='{$this->get_tem_escritura()}',
                      idade_imovel      ='{$this->get_idade_imovel()}',                      
                      lavanderia        ='{$this->get_lavanderia()}',
                      salao_festa       ='{$this->get_salao_festa()}',
                      churrasqueira     ='{$this->get_churrasqueira()}',
                      academia          ='{$this->get_academia()}',
                      piscina           ='{$this->get_piscina()}',
                      ar_condicionado   ='{$this->get_ar_condicionado()}',
                      prox_mercado      ='{$this->get_prox_mercado()}',
                      prox_hospital     ='{$this->get_prox_hospital()}',
                      ativo             ='{$this->get_ativo()}'
                  WHERE id_imovel={$this->get_id_imovel()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();
         $this->alterar_domicilio_imovel();

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }   
      
      return null;
   } // alterar

   /**
    *
    * Excluir o imóvel
    *
    */
   function excluir() {
      try {
         $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = " DELETE FROM tbimovel                  
                  WHERE id_imovel={$this->get_id_imovel()} ";
         $stmt = $this->con->prepare($sql);
         $stmt->execute();   

         $this->excluir_pasta_foto();

      } catch(PDOException $e) {
         echo 'Error: ' . $e->getMessage();
      }   
      
      return null;
   } // excluir

   /**
    *
    * Altera o domicilio do imóvel
    *
    */
   function alterar_domicilio_imovel() {
      $instancia = new Endereco_Hlp();
      $instancia->obter_id_logradouro( $id, $this->get_imovel_cep(),  $this->get_imovel_id_logradouro() );
      $sql = " UPDATE tbdomicilio
                  SET numero        ='{$this->get_imovel_numero()}',
                      complemento   ='{$this->get_imovel_complemento()}',
                      id_logradouro ={$id}
                  WHERE id_domicilio={$this->get_id_domicilio_imovel()} ";
      $stmt = $this->con->prepare($sql);
      $stmt->execute();
   } // alterar_domicilio_imovel

   /**
    *
    * Obtém os imóveis
    *
    */   
   function obter_imoveis( &$imoveis ) {
      $filtro = "1=1";
      if ( $this->get_id_imovel() != '' ) {
         $filtro .= " AND id_imovel = ".$this->get_id_imovel();
      }
      if ( $this->get_id_tipo_imovel() != '' ) {
         $filtro .= " AND tbimovel.id_tipo_imovel = ".$this->get_id_tipo_imovel();
      }
      if ( $this->get_codigo_imovel() != '' ) {
         $filtro .= " AND id_imovel = ".$this->get_codigo_imovel();
      }
      if ( $this->get_titulo() != '' ) {
         $filtro .= " AND LOWER(titulo) LIKE '%".$this->get_titulo()."%'";
      }
      if ( $this->get_id_municipio() != '' ) {
         $filtro .= " AND tbmunicipio.id_municipio = ".$this->get_id_municipio();
      }
      if ( $this->get_proprietario_nome() != '' ) {
         $filtro .= " AND LOWER(proprietario_nome) LIKE '%".$this->get_proprietario_nome()."%'";
      }
      $sql = " SELECT 
                  tbimovel.id_imovel,
                  tbimovel.id_tipo_imovel,
                  tbimovel.id_imovel AS codigo_imovel,      
                  tbimovel.titulo,
                  tbimovel.descricao,
                  tbimovel.proprietario_nome,
                  tbimovel.proprietario_dados,
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
                  tbimovel.tem_escritura,
                  tbimovel.idade_imovel,
                  tbimovel.ativo,
                  tbimovel.id_domicilio_imovel,
                  tbimovel.lavanderia,
                  tbimovel.salao_festa,
                  tbimovel.churrasqueira,
                  tbimovel.academia,
                  tbimovel.piscina,
                  tbimovel.ar_condicionado,
                  tbimovel.prox_mercado,
                  tbimovel.prox_hospital,
                  tbimovel.data_cadastro,
                  tbtipo_imovel.tipo_imovel
               FROM 
                  tbimovel
                     JOIN tbtipo_imovel ON (tbtipo_imovel.id_tipo_imovel=tbimovel.id_tipo_imovel)
                     JOIN tbdomicilio ON (tbimovel.id_domicilio_imovel=tbdomicilio.id_domicilio)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbdomicilio.id_logradouro)
                           JOIN tbbairro ON (tbbairro.id_bairro=tblogradouro.id_bairro)
                              JOIN tbmunicipio ON (tbmunicipio.id_municipio=tbbairro.id_municipio)
               WHERE
                  $filtro
               ORDER BY tbimovel.id_imovel DESC   
             ";

      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $imoveis = $stmt->fetchAll(PDO::FETCH_CLASS);      
      
   } // obter_imoveis

   private function renomear_pasta_temporaria($id) {
      $pasta_tmp  = dirname(__FILE__).'/server/php/files/'.$_SESSION['dir_tmp'].'/';
      $pasta_nova = dirname(__FILE__).'/server/php/files/'.$id;
      if ( is_dir($pasta_tmp) ) {       
         rename( $pasta_tmp, $pasta_nova );
      } else {
         mkdir( $pasta_nova, 0777 );
      }
   } // renomear_pasta_temporaria  

    function obter_endereco() {
      $cep = $_POST['cep'];
      $sql = " SELECT 
                  tblogradouro.cep,
                  tblogradouro.nome_logradouro,
                  tblogradouro.complemento,
                  tblogradouro.local,
                  tbbairro.nome_bairro,
                  tbmunicipio.nome_municipio,
                  tbuf.nome_uf                  
               FROM 
                  tblogradouro
                  JOIN tbbairro on (tbbairro.id_bairro=tblogradouro.id_bairro)
                     JOIN tbmunicipio on (tbmunicipio.id_municipio=tbbairro.id_municipio)
                        JOIN tbuf on (tbuf.id_uf=tbmunicipio.id_uf)               
               WHERE cep='{$cep}'
             ";  
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();      
      $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ( count($resultado)>0 ) {
         $resultado=$resultado[0];
         $resultado['nome_municipio'   ]= utf8_encode($resultado['nome_municipio']);
         $resultado['nome_bairro'      ]= utf8_encode($resultado['nome_bairro']);
         $resultado['nome_logradouro'  ]= utf8_encode($resultado['nome_logradouro']);
         $resultado['complemento'      ]= utf8_encode($resultado['complemento']);
         $resultado['local'            ]= utf8_encode($resultado['local']);
         $resultado['status'           ] = 'ok'; 
         $resultado['endereco_completo'] = $resultado['nome_logradouro'].' / '.
                                           $resultado['nome_bairro'].' / '.
                                           $resultado['complemento'].' / '.
                                           $resultado['local'].' / '.
                                           $resultado['nome_municipio' ];
         echo json_encode($resultado);
      } else {
         $resultado['status'] = 'CEP não encontrado.';
         echo json_encode($resultado);
      }
   } // obter_endereco

   public function obter_tipos_imoveis(&$tipos) {      
      $sql = " SELECT 
                  id_tipo_imovel,
                  tipo_imovel
               FROM 
                  tbtipo_imovel
             ";
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $tipos = $stmt->fetchAll(PDO::FETCH_CLASS); 
   } // obter_tipos_imoveis

   /**
   * Exclui a pasta das fotos do imóvel
   * obs: 
   */   
   public function excluir_pasta_foto() {
      $id        = $this->get_id_imovel();
      $thumbnail = dirname(__FILE__).'/server/php/files/'.$id.'/thumbnail/'; 
      $media     = dirname(__FILE__).'/server/php/files/'.$id.'/media/';
      $padrao    = dirname(__FILE__).'/server/php/files/'.$id.'/';
      $fotos = array_slice( scandir($thumbnail), 2);            
      foreach ( $fotos as $foto ) {
         unlink($thumbnail.$foto);
         unlink($media.$foto);
         unlink($padrao.$foto);
      }
      rmdir($thumbnail);
      rmdir($media);
      rmdir($padrao);
   } // excluir_pasta_foto

} // Cadastro_Hlp_Imovel
