<?php

namespace EMPRESA\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {
    
    private $email_from = "mateus.deliberali1@yahoo.com.br";
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
            $this->mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mail->Username   = 'mateusteste123555@gmail.com';                     // SMTP username
            $this->mail->Password   = 'skidrow123';                               // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port       = 587; 

            $this->mail->setFrom($this->email_from, "Mensagem do site");
            $this->mail->addAddress($this->email_from);

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