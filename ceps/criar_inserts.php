<?php

/*

     ********  cria os inserts com todos os CEPs do brasil
     
     -  php /var/www/oviraLata/ceps/criar_inserts.php

     -  alter table tblogradouro AUTO_INCREMENT = 1;

*/

class Cria_Inserts {
   
   public $con;
   public $hora_inicial;   

   function __construct() {      
      $this->conecta();
      $this->hora_inicial = date('H:i:s');
   }
   
   //sp,RJ',MG ) { 

   function executar() {
      $this->obter_dados($dados);
      
      $txt =  "INSERT INTO `tblogradouro` ( `cep`, `logradouro`, `complemento`, `bairro`, `municipio`, `uf`, `ddd` )\n";
      $txt .= "VALUES";

      file_put_contents( '/var/www/oviralata/ceps/scripts/insert_ceps_SP.sql',       $txt ."\n" );
      file_put_contents( '/var/www/oviralata/ceps/scripts/insert_ceps_MG_RJ_BA.sql', $txt ."\n" );
      file_put_contents( '/var/www/oviralata/ceps/scripts/insert_ceps_RS_PR_PE.sql', $txt ."\n" );
      file_put_contents( '/var/www/oviralata/ceps/scripts/insert_ceps_OUTROS.sql',   $txt ."\n" );
         
      foreach ( $dados as $item ) {
         $municipio   = utf8_encode( addslashes($item->descricao_cidade) );
         $bairro      = utf8_encode( addslashes($item->descricao_bairro) );
         $descricao   = utf8_encode( addslashes($item->descricao) );
         $complemento = utf8_encode( addslashes($item->complemento) );
         $txt = ' '." ('{$item->CEP}','{$descricao}','{$complemento}','{$bairro}','{$municipio}','{$item->UF}','{$item->ddd}'),";
         
         if ( $item->UF == 'SP' ) {
            file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_SP.sql', $txt ."\n", FILE_APPEND   );

         } else if ( $item->UF=='MG' || $item->UF=='RJ' || $item->UF=='BA' ) {
            file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_MG_RJ_BA.sql', $txt ."\n", FILE_APPEND   );
         
         } else if ( $item->UF=='RS' || $item->UF=='PR' || $item->UF=='PE' ) {
            file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_RS_PR_PE.sql', $txt ."\n", FILE_APPEND   );
         
         } else {
            file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_OUTROS.sql', $txt ."\n", FILE_APPEND   );
         
         }
         
         print $item->CEP.' ->'.++$i."\n";
      }
  
      $insert_ceps_SP       = file_get_contents('/var/www/oviraLata/ceps/scripts/insert_ceps_SP.sql'); 
      $insert_ceps_MG_RJ_BA = file_get_contents('/var/www/oviraLata/ceps/scripts/insert_ceps_MG_RJ_BA.sql'); 
      $insert_ceps_RS_PR_PE = file_get_contents('/var/www/oviraLata/ceps/scripts/insert_ceps_RS_PR_PE.sql'); 
      $insert_ceps_OUTROS   = file_get_contents('/var/www/oviraLata/ceps/scripts/insert_ceps_OUTROS.sql'); 
      
      file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_SP.sql',       substr($insert_ceps_SP,      0,(strlen($insert_ceps_SP      )-2) ) .";\n" );
      file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_MG_RJ_BA.sql', substr($insert_ceps_MG_RJ_BA,0,(strlen($insert_ceps_MG_RJ_BA)-2) ) .";\n" );
      file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_RS_PR_PE.sql', substr($insert_ceps_RS_PR_PE,0,(strlen($insert_ceps_RS_PR_PE)-2) ) .";\n" );
      file_put_contents( '/var/www/oviraLata/ceps/scripts/insert_ceps_OUTROS.sql',   substr($insert_ceps_OUTROS,  0,(strlen($insert_ceps_OUTROS  )-2) ) .";\n" );
      
   } // executar

   function obter_dados(&$dados) {
      $sql = " SELECT
                  logradouro.CEP, 
                  logradouro.descricao,
                  logradouro.complemento,
                  logradouro.descricao_bairro,
                  logradouro.descricao_cidade,
                  logradouro.UF,
                  cidade.ddd                  
               from logradouro
                  JOIN cidade ON (cidade.id_cidade=logradouro.id_cidade)
              ";               
      $stmt = $this->con->prepare( $sql );
      $stmt->execute();
      $dados = $stmt->fetchAll(PDO::FETCH_CLASS);      
   } // obter_dados

   private function conecta() {      
      $username  = "root";
      $password  = "sucesso";
      $host      = "localhost";
      $db        = "db_oviraLata";         
      $this->con = new PDO("mysql:dbname=$db;host=$host", $username, $password );
   } // conecta

   private function obter_do( &$do, $linha ) {
      $do = new stdclass;
      $dados = explode( '|', $linha );
      $do->cep             = trim($dados[1]);
      $do->tipo_logradouro = trim($dados[2]);
      $do->logradouro      = trim($dados[3]);
      $do->complemento     = trim($dados[4]);
      $do->local           = trim($dados[5]);
      $do->bairro          = trim($dados[6]);
      $do->municipio       = trim($dados[7]);
      $do->uf              = trim($dados[8]);
   } // obter_do  
   

} // Cria_Inserts

$instancia = new Cria_Inserts();
$instancia->executar();
