<?php

if ( !$_SESSION['login'] ) {
   session_start();  
}

require_once('../facebook/vendor/autoload.php');
include_once 'utils.php';
include_once 'cad_usuario_hlp.php';

$app_secret = 'a6eb0699845d5059ea305f8a998e6fe5';
$app_id     = '2548948048478153';

$fb = new Facebook\Facebook([
   'app_id'     => $app_id,
   'app_secret' => $app_secret,
   'default_graph_version' => 'v2.10',
]);


$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) { 
   $helper->getPersistentDataHandler()->set('state', $_GET['state']); 
}

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if ( !isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}
$fb->setDefaultAccessToken($accessToken);
$response = $fb->get('/me?locale=en_US&fields=name,email');
$userNode = $response->getGraphUser();

$_SESSION['nome_completo'] = $userNode->getField('name');
$_SESSION['email'        ] = $userNode->getField('email');
$_SESSION['id_facebook'  ] = $userNode->getField('id');
$_SESSION['login'        ] = true;

$usuario = new Cad_Usuario_Hlp();
$usuario->set_email( $userNode->getField('email'));
$usuario->obter_dados_usuario( $consulta_usuario );

if ( $consulta_usuario->id_usuario != '' ) {
   if ( trim($consulta_usuario->ativo)=='' || $consulta_usuario->id_facebook=='' ) {
       $instancia = new Cad_Usuario_Hlp();
       $instancia->atualizar_usuario_facebook( $consulta_usuario->id_usuario, $userNode->getField('id') );
   }
   Utils::set_session( $consulta_usuario->id_usuario );
   if ( $_SESSION['programa'] =='cad_usuario.php' ) {
      $link = 'cad_usuario.php?acao=alteracao&comportamento=exibir_formulario_alteracao&id_usuario='.$consulta_usuario->id_usuario;
      $link = str_replace( '#_=_', '', $link ); 
      header( 'Location: '.$link , false);
   } else {
      header("Location: index.php");
   }

} else {
   //..inclui usuário
   $usuario = new Cad_Usuario_Hlp();
   $usuario->set_id_facebook( $userNode->getField('id') );
   $usuario->set_email( $userNode->getField('email') );
   $usuario->set_nome_completo( $userNode->getField('name') );
   $usuario->incluir_usuario_facebook();
   $usuario->obter_dados_usuario( $consulta_usuario );
   Utils::set_session( $consulta_usuario->id_usuario );
   $link = 'cad_usuario.php?acao=alteracao&comportamento=exibir_formulario_alteracao&id_usuario='.$consulta_usuario->id_usuario;
   $link = str_replace( '#_=_', '', $link ); 
   header( 'Location: '.$link , false);
 
}
