<?php

//........... file_put_contents( __DIR__.'/teste.txt', $pasta ."\n" );


session_start();

define( 'DIR_FOTOS', dirname(dirname(__FILE__)).'/fotos/' ); 

/**
*
* Essa classe auxilia no upload das fotos do site
* 
*/   

class Fotos {

   /**
   * Inclui a foto na pasta /fotos
   */
   public function incluir_foto() {
      $dir = DIR_FOTOS.$_SESSION['dir_tmp'];
      $imagem = urldecode( $_POST['imagem'] );
      $tipo   = $_POST['tipo'];
      $nome   = $_POST['nome'];
      if ($tipo=='thumbnail'){
         $nome = 't_'.$nome;   
      }
      $retirar = 'data:image/jpeg;base64,';
      $imagem  = str_replace( $retirar, '', $imagem );
      $dados   = base64_decode($imagem);
      if ( !is_dir($dir) ) {
         mkdir( $dir, 0755 );
      }
      $nome_foto = $dir."/{$nome}";

      //.. Salva a foto na pasta
      file_put_contents( $nome_foto, $dados );

   } // incluir_foto

   /**
   * Apagar pastas temporárias com data de criação < data de hoje
   * obs: 
   */   
   public function apagar_pastas_tmp() {
      $dir    = DIR_FOTOS;
      $pastas = array_slice(scandir($dir), 2);
      foreach ( $pastas as  $pasta ) {  
         $data_pasta = substr($pasta,4,8);
         $data_hoje  = date('Ymd');         
         if ( substr($pasta,0,3)=='tmp' && $pasta != $_SESSION['dir_tmp'] && $data_pasta<$data_hoje) {            
            $fotos = array_slice(scandir($dir.$pasta), 2);            
            foreach ( $fotos as $foto ) {
               $link = $dir.$pasta.'/'.$foto;      
               unlink($link);
            }
            rmdir($dir.$pasta);
         }
      }
   } // apagar_pastas_tmp

   /**
   *
   * Exclui a foto da pasta /fotos
   *
   */
   public function excluir_foto() {
      file_put_contents( __DIR__.'/teste.txt','vixi' , FILE_APPEND );
      $dir       = DIR_FOTOS;
      $retirar = 't_';      
      $thumbnail = $_POST['nome_foto'];
       file_put_contents( __DIR__.'/teste.txt', $thumbnail ."\n" , FILE_APPEND );
      $nome_foto = str_replace( $retirar, '', $_POST['nome_foto'] );
      $foto      = $dir.$_SESSION['dir_tmp'].'/'.$nome_foto;
      $thumbnail = $dir.$_SESSION['dir_tmp'].'/'.$thumbnail;
      file_put_contents( __DIR__.'/teste.txt', $foto.' '. $thumbnail ."\n" , FILE_APPEND );
      unlink($foto);
      unlink($thumbnail);
   } // excluir_foto

   /**
   * Obtém as miniaturas das fotos
   */   
   public function obter_miniaturas($id_imovel) {
      $dir       = DIR_FOTOS;
      $pasta = $dir.$id_imovel;
      $fotos = array_slice(scandir($pasta), 2);
      $vetor = array();
      foreach ( $fotos as $foto ) {
         if ( substr($foto,0,2)=='t_' ) {
            $vetor[] = ['foto'=>$foto];
         }
      }
      echo json_encode($vetor);      
   } // obter_miniaturas

} // Fotos


$fotos = new Fotos(); 
   
switch ($_POST['acao']) {
   case 'incluir_foto':   
      $fotos->apagar_pastas_tmp();
      $fotos->incluir_foto();
      break;
   
   case 'excluir_foto':
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