<?php
session_start();

/**
*
* Essa classe auxilia no controle de fotos
*
* 
*/   

class Fotos {

   /**
   * Apagar pastas temporárias com data de criação < data de hoje
   * obs: 
   */   
   public function apagar_pastas_tmp() {
      $data_hoje = date('Ymd');
      $dir       =  dirname(__FILE__).'/server/php/files/'; 
      $pastas    = array_slice(scandir($dir), 2);
      foreach ( $pastas as  $pasta ) {  
         $data_pasta = substr($pasta,4,8);         
         if ( substr($pasta,0,3)=='tmp' && $pasta != $_SESSION['dir_tmp'] && $data_pasta<$data_hoje) {            
            self::excluir_pasta_fotos( $pasta );
         }
      }
   } // apagar_pastas_tmp

   /**
   * Exclui a pasta e as fotos do imóvel
   * 
   */   
   public static function excluir_pasta_fotos( $pasta ) {
      $thumbnail = dirname(__FILE__).'/server/php/files/'.$pasta.'/thumbnail/'; 
      $media     = dirname(__FILE__).'/server/php/files/'.$pasta.'/media/';
      $padrao    = dirname(__FILE__).'/server/php/files/'.$pasta.'/';
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
  
   /**
   *
   * Exclui uma foto
   *
   */
   public function excluir_foto() {  
      $id_imovel = $_SESSION['dir_tmp'];
      $nome_foto = $_POST['nome_foto'];      
      $thumbnail = dirname(__FILE__).'/server/php/files/'.$id_imovel.'/thumbnail/'.$nome_foto; 
      $media     = dirname(__FILE__).'/server/php/files/'.$id_imovel.'/media/'.$nome_foto; 
      $padrao    = dirname(__FILE__).'/server/php/files/'.$id_imovel.'/'.$nome_foto;       
      unlink($media);
      unlink($thumbnail);
      unlink($padrao);
   } // excluir_foto

   /**
   * Obtém as miniaturas das fotos
   */   
   public function obter_miniaturas($id_imovel) {
      $pasta = dirname(__FILE__).'/server/php/files/'.$id_imovel.'/thumbnail/'; 
      $vetor = array();
      if ( is_dir($pasta) ) {
         //file_put_contents( 'teste.txt', $pasta ."\n" );

         $fotos = array_slice(scandir($pasta), 2);      
         foreach ( $fotos as $foto ) {
            $vetor[] = ['foto'=>$foto];         
         }
      }
      if ( count($vetor)) {
         echo json_encode($vetor);   
      }            
   } // obter_miniaturas

} // Fotos


$fotos = new Fotos(); 
   
switch ($_POST['acao']) {
  
   case 'excluir_foto':
      $fotos->apagar_pastas_tmp();
      $fotos->excluir_foto();
      break;

   case 'obter_miniaturas':
      $id_imovel = $_POST['id_imovel'];
      $fotos->obter_miniaturas($id_imovel);
      break;
   
   default:
      # code...
      break;
}