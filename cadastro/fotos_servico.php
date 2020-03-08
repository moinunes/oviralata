<?php
if(!isset($_SESSION)) {
   session_start();
};

/**
*
* Essa classe auxilia no controle de fotos de SERVICOS e Produtos
*
* 
*/   

class Fotos_Servico {

   private $array_pastas_tmp;

   public function guardar_pastas_tmp($nome_pasta_tmp) {
      $this->array_pastas_tmp[$nome_pasta_tmp]=$nome_pasta_tmp;
   }

   /**
   * Obtém as miniaturas das fotos
   */   
   public function obter_miniaturas($id_servico) {
      $acao      = $_SESSION['acao'];
      $dir_fotos = str_replace( 'cadastro','fotos_servico/', dirname(__FILE__) );
   
      if ( $acao=='inclusao' ) {        
         $pasta = $dir_fotos.$id_servico.'/thumbnail/';         
      }

      if ( $acao=='alteracao' ) {
         $data = explode('_', $id_servico );
         $data = $data[0];
         $id   = $data[1];
         $pasta = $dir_fotos.'tmp_'.$id_servico.'/thumbnail/';
      }
      
      file_put_contents( 'teste.txt',  $acao  , FILE_APPEND );

      $vetor = array();
      if ( is_dir($pasta) ) {      
         $fotos = array_slice(scandir($pasta), 2); 
         foreach ( $fotos as $foto ) {
            $vetor[] = ['foto'=>$foto];         
         }
      }
      if ( count($vetor)) {
         echo json_encode($vetor);   
      }            
   } // obter_miniaturas

   /**
   * cria a pasta 
   * 
   */   
   public function criar_pasta($pasta) {
      if ( !is_dir($pasta) ) {
         mkdir( $pasta, 0777, true );
      }
   }


   public function tratar_fotos_apos_inclusao($id_servico, $data_cadastro ) {
      $dir_tmp      = $_SESSION['dir_tmp'];
      $data_hoje    = substr($data_cadastro,8,2).'_'.substr($data_cadastro,5,2).'_'.substr($data_cadastro,0,4);
      $dir_fotos    = str_replace( 'cadastro','fotos_servico/', dirname(__FILE__) );
      $pasta_do_dia = $dir_fotos.$data_hoje.'/';
      $pasta_tmp    = $dir_fotos.$dir_tmp.'/';
      $pasta_tmp_t  = $dir_fotos.$dir_tmp.'/thumbnail/';
      $thumbnail    = 0;

      //.. cria pasta do dia somente se não existir
      $this->criar_pasta($pasta_do_dia);
         
      foreach ( glob($pasta_tmp_t."*.*") as $arquivo) {
         $nome_foto = basename($arquivo);        
         
         //.. copia todas fotos grandes
         copy( $pasta_tmp.$nome_foto, $pasta_do_dia.$id_servico.'_'.$nome_foto );   

         //.. copia apenas uma thumbnail
         if( $thumbnail==0 ) {            
            copy( $pasta_tmp_t.$nome_foto, $pasta_do_dia.$id_servico.'_t_'.$nome_foto );
            $thumbnail=1;
         }

      }

      //.. exclui as pastas tmp
      $this->excluir_pasta_tmp($pasta_tmp_t);
      $this->excluir_pasta_tmp($pasta_tmp);      

   } // tratar_fotos_apos_inclusao
   

   public function tratar_fotos_apos_alteracao( $id_servico, $data_cadastro ) {
      $dir_tmp   = 'tmp_'.$_SESSION['dir_tmp'].'/';      
      $dir_tmp_t = 'tmp_'.$_SESSION['dir_tmp'].'/thumbnail/';      
      $dir_fotos = str_replace( 'cadastro','fotos_servico/', dirname(__FILE__) );
      $pasta_dc  = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      $thumbnail = 0;
      $id = explode('_', $id_servico);
      $id = $id[1];
      //.. exclui as fotos da pasta: 'd_m_Y'
      $this->excluir_fotos($pasta_dc,$id);
      //.. copia as fotos da tmp para pasta: 'd_m_Y'
      $fotos=glob($dir_fotos.$dir_tmp."*");
      foreach ( $fotos as $arquivo) {
         $nome_foto = basename($arquivo);
         if ( $nome_foto != 'thumbnail' ) { //.. thumbnail é nome de pasta
            //.. copia todas fotos grandes
            copy( $dir_fotos.$dir_tmp.$nome_foto, $pasta_dc.$id.'_'.$nome_foto );
            if( $thumbnail==0 ) {
               copy( $dir_fotos.$dir_tmp_t.$nome_foto, $pasta_dc.$id.'_t_'.$nome_foto );
               $thumbnail=1;
            }
         }
      }      
      //.. exclui as pastas tmp
      $this->excluir_pasta_tmp($dir_fotos.$dir_tmp.'/thumbnail/');
      $this->excluir_pasta_tmp($dir_fotos.$dir_tmp);
             
   } // tratar_fotos_apos_alteracao    
  
   /**
   * Exclui a pasta
   * 
   */   
   public static function excluir_pasta_tmp( $pasta ) {
      if ( is_dir( $pasta ) ) {
         $fotos = array_slice( scandir($pasta), 2);            
         foreach ( $fotos as $foto ) {
            unlink($pasta.$foto);         
         }
         rmdir($pasta);
      }
   } // excluir_pasta_tmp

   /**
   *
   * 
   *
   */
   public function prepara_pasta_foto_para_alteracao($id_servico, $data_cadastro ) {
      $dir_fotos= str_replace( 'cadastro','fotos_servico/', dirname(__FILE__) );
      $pasta_dc = $dir_fotos.date("d_m_Y", strtotime($data_cadastro)).'/';
      //..      
      $pasta   = $dir_fotos.'tmp_'.$_SESSION['dir_tmp'].'/';
      $pasta_t = $dir_fotos.'tmp_'.$_SESSION['dir_tmp'].'/thumbnail/';
      //..
      $this->criar_pasta($pasta);
      $this->criar_pasta($pasta_t);
      //..
      $fotos=glob($pasta_dc.$id_servico."*");   
      foreach ( $fotos as $arquivo) {
         $nome_foto = basename($arquivo);
         $pos       = strpos($nome_foto, '_t_' );
         if($pos<=0) {
            $inicio = strlen($id_servico.'_') ;
            $nome_da_foto = substr(basename($arquivo),$inicio, strlen($nome_foto)-$inicio);
            // copiar as fotos grandes
            copy( $pasta_dc.$nome_foto, $pasta.$nome_da_foto);

            // copia as fotos grandes para thumnail e redimensiona
            copy( $pasta_dc.$nome_foto, $pasta_t.$nome_da_foto);
            $this->redimensionar( $pasta_t, $nome_da_foto, 200 );            
         
         }

      }
   } // prepara_pasta_foto_para_alteracao

   /**
   *
   * Exclui fotos de uma pasta
   *
   */
   public function excluir_fotos($pasta,$id_servico) {  
      $fotos=glob($pasta.$id_servico."*");  
      foreach ( $fotos as $arquivo) {       
         unlink($arquivo);
      }
   } // excluir_fotos
  
   /**
   *
   * Exclui uma foto
   *
   */
   public function excluir_foto() {  
      $nome_foto  = $_POST['nome_foto'];  
      if ($_SESSION['acao']=='alteracao' ) {
         $id_servico = 'tmp_'.$_SESSION['dir_tmp'];
      } else {
         $id_servico = $_SESSION['dir_tmp'];
      }
          //file_put_contents( 'teste.txt',  $id_servico  , FILE_APPEND );
      
      $thumbnail  = '../fotos_servico/'.$id_servico.'/thumbnail/'.$nome_foto;
      $padrao     = '../fotos_servico/'.$id_servico.'/'.$nome_foto;    
      unlink($thumbnail);
      unlink($padrao);
   } // excluir_foto


   /**
   *
   * tipos: 1-IMAGETYPE_GIF,  2-IMAGETYPE_JPEG,  3-IMAGETYPE_PNG
   *
   */
   public function redimensionar( $pasta, $nome_foto, $largura=200 ) {      
      $tipo   = exif_imagetype($pasta.$nome_foto);
      $imagem = $pasta.$nome_foto;
      if ( $tipo==1 ) {
         $img = imagecreatefromgif($imagem);
      } else if ( $tipo==2 ) {
         $img = imagecreatefromjpeg($imagem);         
      } else if ( $tipo==3 ) {
         $img = imagecreatefrompng($imagem);      
      }      
      $size = min(imagesx($img), imagesy($img));
      $img = imagecrop( $img, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
      
      $x = imagesx($img);
      $y = imagesy($img);
      $altura = ($largura*$y)/$x;
      
      $nova = imagecreatetruecolor($largura, $altura);
      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);

      if ( $tipo==2 ) {                  //.. jpg
         $local="$pasta/$nome_foto";
         imagejpeg( $nova, $local );
         
      } else if ($tipo==1) {            //.. gif
         $local="$pasta/$nome_foto";
         imagegif($nova, $local);
      
      } else if ($tipo==3 ) {           //.. png
         $local="$pasta/$nome_foto";
         imagepng( $nova, $local );
      
      }

      imagedestroy($img);
      imagedestroy($nova); 
      

      return;
   } // redimensionar

} // Fotos_Servico


$fotos = new Fotos_Servico(); 
if ( isset( $_POST['acao'] ) ) {  

   switch ($_POST['acao'] ) {  
      case 'excluir_foto':
         $fotos->excluir_foto();
         break;

      case 'obter_miniaturas':
         $id_servico = $_POST['id_servico'];    
         $fotos->obter_miniaturas($id_servico);
         break;
      
      default:
         # code...
         break;
   }

}