<?php

use EMPRESA\classes\Email;

include('classes/Email.php'); 

require 'vendor/autoload.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $errors = [];

        if (!isset($_POST['text_email']) || !isset($_POST['text_assunto']) || !isset($_POST['text_mensagem'])){
            array_push($errors,'Pelo menos um dos campos não existe!');
        }

        $email = $_POST['text_email'];
        $assunto = $_POST['text_assunto'];
        $mensagem = $_POST['text_mensagem'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, 'Email fornecido é inválido!');
        }

        $email = new Email($email, $assunto, $mensagem);
        $email->sendEmail();
    }
?>

<h1>Formulário de Contato</h1>

<form action="?p=contato" method="POST">
    <input type="email" name="text_email" placeholder="Email..." required><br>
    <input type="text" name="text_assunto" placeholder="Assunto..." required><br>
    <textarea name="text_mensagem" placeholder="Mensagem..." cols="60" rows="10" required></textarea><br>
    <input type="submit" value="Enviar Mensagem">
</form>
<?php if(isset($errors) && !empty($errors)): ?>
    <div style="color: red">
        <?php 
            foreach ($errors as $error) {
                echo $error;
            }
        ?>
    </div>
<?php endif ?>
<!--<div class="loader"></div>-->
<?php if(isset($errors) && count($errors) <= 0): ?>
    <span style="color: green;">Mensagem enviado com sucesso!</span>
<?php endif ?>


