<?php

require_once '../facebook/vendor/autoload.php'; // autoload do composer

$app_secret='a6eb0699845d5059ea305f8a998e6fe5';
$app_id    = '2548948048478153';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.10',
]);
$helper      = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Permissões Opcionais
$loginUrl    = $helper->getLoginUrl('https://www.oviralata.com.br/cadastro/fb-callback.php', $permissions); 
echo '<a  href="' . $loginUrl . '">
        <div class="btn btn_facebook">
            <img src="../images/facebook.png">&nbsp;&nbsp;Entrar com Facebook!
        </div>
      </a>';


