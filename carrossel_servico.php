<?php
include_once 'cadastro/conecta.php';
include_once 'cadastro/utils.php';

/**
*
* Essa classe monta o carrossel Serviço
* 
*/         

class Carrossel_Servico {

   public $id_carousel = 'padrao';
   public $cor_fundo   = 'fundo_branco';
   public $filtro_palavra_chave;
   public $exibir_btn_detalhes='N';
   public $titulo ='';

   function __construct() {
      $this->total_anuncios = 0; // default
   }

   public function executar() {
      $this->obter_anuncios( $this->anuncios, $this->total_anuncios );
      $this->exibir_carrossel();
   }

   private function exibir_carrossel() {?>
      <div class="row">
         <div class="col-12 text-center">   
            <span class="destaque_1"><?=$this->titulo?></span>  
         </div>
      </div>
      <div class="row <?=$this->cor_fundo?> margem_pequena">
         <div class="col-12 text center">         
            <div id="<?=$this->id_carousel?>" class="carousel slide carousel-fade" data-ride="carousel">
               <!-- The slideshow -->
               <div class="carousel-inner text-center">
                   <?php
                   $this->montar_carrossel();?>                   
               </div>               
               <div onclick="fechar()">
                  <!-- Left and right controls -->
                  <a class="carousel-control-prev" href="#<?=$this->id_carousel?>" data-slide="prev">
                     <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#<?=$this->id_carousel?>" data-slide="next">
                     <span class="carousel-control-next-icon"></span>
                  </a> 
               </div>           
            </div>
         </div>
         <div class="col-12 altura_linha_2"><br></div>
      </div>
   <?php
   } 

   private function montar_carrossel() {
      $active='active';
      foreach ($this->anuncios as $anuncio) {
         $nome_foto = Utils::obter_thumbnail_servico( $anuncio->id_servico, $anuncio->data_cadastro );

         $pasta_dc = 'fotos_servico/';
         $pasta_dc = $pasta_dc.date("d_m_Y", strtotime($anuncio->data_cadastro)).'/';
         $thumbnail = $pasta_dc.$nome_foto;
         ?>
         <div class="carousel-item <?=$active?>">
            <img src="<?=$thumbnail?>" alt="<?=$anuncio->titulo?>">
            <br>
            <span class="destaque_1"><?=$anuncio->titulo?></span><br>
            <span><?=$anuncio->bairro.' '.$anuncio->municipio.' '.$anuncio->uf?><br></span>
            
            <?php 
            $this->exibir_telefone($anuncio);
            if ( $this->exibir_btn_detalhes=='S' ) {?>
               <div class="text-center">         
                  <a href="javascript:mostrar_detalhes_servico('<?=$anuncio->id_servico?>')" class="btn btn_detalhes" >
                     Veja mais...      
                  </a>
               </div>
            <?php   
            }?>

         </div>
         <?php
         $active='';
      }
   } 
      
   private function exibir_telefone($anuncio) {
      if ( $anuncio->exibir_tea=='T' || $anuncio->exibir_tea=='A' ) {
         $display_celular  =  $anuncio->tel_celular  == '' ? 'display:none;' : '';
         $display_whatzapp =  $anuncio->tel_whatzapp == '' ? 'display:none;' : '';
         $display_fixo     =  $anuncio->tel_fixo     == '' ? 'display:none;' : '';       
         ?>
         <div style="<?=$display_celular?>" >
            <img src="./images/cel.png" alt="o vira lata - adote um pet, cachorro, gato ou outro animal de estimação">
            <span class="text">(<?=$anuncio->ddd_celular?>) <?=$anuncio->tel_celular?></span>
         </div>         
         <div style="<?=$display_whatzapp?>" >   
            <img src="./images/whatsapp.png" alt="<?=$anuncio->tel_whatzapp?>">
            <span class="text">(<?=$anuncio->ddd_whatzapp?>) <?=$anuncio->tel_whatzapp?></span>
         </div>                          
      <?php
      }      
   } // exibir_telefone
 
   private function obter_filtro_palavras( &$resultado ) {
      $array = explode( ' ', $this->filtro_palavra_chave );
      $resultado = '';
      foreach ( $array as $palavra ) {
         $resultado .= '+'.$palavra.'*';
      }
      $resultado = trim($resultado);
   }

   /**
   * Obtém os  Servicos-Produtos
   * 
   * $limite=0 -> retorna todos registros
   *
   */   
   public function obter_anuncios( &$resultado, $limite=1 ) {
      $conecta = new Conecta();     

      $filtro = "1=1 AND tbservico.ativo='S' ";
      if ( $this->filtro_palavra_chave != '' ) {
         $this->obter_filtro_palavras( $palavras );
         $filtro .= " AND MATCH ( palavras,mais_palavras ) AGAINST ( '".$palavras."'  IN BOOLEAN MODE)";
      }
      $ordem   = ' ORDER BY tbservico.id_servico DESC ';
      $limit   = $limite==0 ? '' : "LIMIT {$limite}";

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
                  tbtipo_servico.tiposervico,
                  tbusuario.email,                  
                  tbusuario.exibir_tea,
                  tbusuario.ddd_fixo,
                  tbusuario.ddd_celular,
                  tbusuario.ddd_whatzapp,
                  tbusuario.tel_celular,   
                  tbusuario.tel_whatzapp,
                  tbusuario.tel_fixo,                  
                  tbusuario.apelido
               FROM
                  tbservico
                     JOIN tbtipo_servico ON (tbtipo_servico.id_tipo_servico=tbservico.id_tipo_servico)
                     JOIN tbusuario ON (tbusuario.id_usuario=tbservico.id_usuario)
                        JOIN tblogradouro ON (tblogradouro.id_logradouro=tbusuario.id_logradouro) 
                WHERE $filtro
               $ordem    
               $limit;
             ";
             //Utils::Dbga_Abort($sql);
      $stmt = $conecta->con->prepare( $sql );
      $stmt->execute();
      if($limite==1){
         $resultado = $stmt->fetch(PDO::FETCH_OBJ);
      } else {      
         $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);   
      }
   } // obter_anuncios
   
}


