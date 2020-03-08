<?php
use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


include_once 'conecta.php';
include_once 'utils.php';

class Enviar_Email_Hlp {

   public $assunto;
   public $mensagem;
   public $email_destinatario;
   public $nome_destinatario;
   public $email_responder_para;
   public $nome_responder_para;
   public $email_do_site; 
   public $enviado;
   public $tem_logo;
   public $email_nome;

   public function __construct() {
      $this->tem_logo   = 'S'; 
      $this->email_nome = 'oViraLata';     
   }

   public function enviar_email() {

      $this->email_site = 'contato@oviralata.com.br'; 

      $mail = new PHPMailer;
      $mail->isSMTP();
      $mail->Host       = 'br948.hostgator.com.br';
      $mail->SMTPAuth   = true;
      $mail->Username   = $this->email_site;
      $mail->Password   = 'cpd392781';
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;
      $mail->CharSet    = "utf-8";
      
      $mail->setFrom( $this->email_site, $this->email_nome );                       //.. De
      $mail->addAddress( $this->email_destinatario,   $this->nome_destinatario );   //.. Adicionar um destinatário
      $mail->addReplyTo( $this->email_responder_para, $this->nome_responder_para ); //.. adicionar resposta a
      $mail->AddBCC('magdapetsrd@gmail.com');                                       //.. Define qual conta de email receberá uma cópia oculta
   
      if ( $this->tem_logo=='S' ) {   
         if ( file_exists('../images/logo.png') ) {
            $mail->AddEmbeddedImage('../images/logo.png', 'logo');
         } else {
            $mail->AddEmbeddedImage('./images/logo.png', 'logo');
         }
      }
      $mail->isHTML(true);
      $mail->Subject = $this->assunto;         //.. Assunto da mensagem
      $mail->Body    = $this->mensagem."<br>"; //.. Texto da mensagem 
      $mail->AltBody = '';                     //.. Este é o corpo em texto sem formatação para clientes de email não HTML;

      if(!$mail->send()) {
         $this->enviado = "erro: ".$mail->ErrorInfo;
      } else {
         $this->enviado = "sucesso";
      }
   }

   public function enviar_email_mostrar_detalhes() {
      $mensagem = "</br>";
      $mensagem.= "<img src='cid:logo' alt='logo' /><br>";
      $mensagem .= "Portal de anúncios PET<br>";
      $mensagem .= "Amor e respeito aos Animais!";
      $mensagem.= "<br><br>";
      $mensagem.= "Olá ".$_REQUEST['apelido'].",\n\n";
      $mensagem.= "Meu nome é {$_POST['nome']}\n";
      $mensagem.= "Eu vi seu anúncio no site oViraLata, e tenho interesse:\n";
      
      $mensagem.= "\n<<< Meus dados >>>"."\n";
      $mensagem.= "nome: ".$_REQUEST['nome']."\n";
      $mensagem.= "email: ".$_REQUEST['email']."\n";
      $mensagem.= "telefone: (".$_REQUEST['ddd'].') '.$_REQUEST['tel']."\n";
      $mensagem.= "\n";
      $mensagem.= $_REQUEST['mens'  ];

      $email = new Enviar_Email_Hlp();
      $email->email_responder_para = $_POST['email'];
      $email->nome_responder_para  = $_POST['nome'];
      $email->email_destinatario   = $_POST['email_destino'];
      $email->nome_destinatario    = $_POST['apelido'];
      $email->assunto              = 'Interessada(o) pelo seu anúncio no site oViraLata';
      $email->mensagem             =  nl2br($mensagem);
      $email->enviar_email();
      
      $vetor = array( 'resultado' => $email->enviado );
      echo json_encode($vetor);
   }

}

//.. tratamento de envio por ajax
if ( isset( $_POST['acao'] ) ) {  
   $instancia = new Enviar_Email_Hlp(); 
   switch ($_POST['acao'] ) {  
      case 'mostrar_detalhes':
         $instancia->enviar_email_mostrar_detalhes();
         break;      
      
      default:
         # code...
         break;
   }

}
