<?php

namespace EMPRESA\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {
    
    private $email;
    private $assunto;
    private $mensagem;
    private $mail;

    public function __construct($email, $assunto, $mensagem) {
        
        $this->mail = new PHPMailer(true);

        $this->email = $email;
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
    }

    public function sendEmail(){

        try {
            //$this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->isSMTP();                                            // Send using SMTP
            $this->mail->Host       = $_ENV['SMTP_HOST'];                    // Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mail->Username   = $_ENV['SMTP_USER'];;                     // SMTP username
            $this->mail->Password   = $_ENV['SMTP_PASS'];;                               // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port       = $_ENV['SMTP_PORT'];; 

            $this->mail->setFrom($_ENV['EMAIL_DESTINATION'], "Mensagem do site");
            $this->mail->addAddress($_ENV['EMAIL_DESTINATION']);

            // Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $this->assunto;
            $this->mail->Body    = $this->email . $this->mensagem;
            
            $this->mail->send();
            return true;
        }
        catch(Exception $ex) {
            return "Erro ao tentar enviar o email. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

}