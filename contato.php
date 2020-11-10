<?php

use EMPRESA\classes\Database;
use EMPRESA\classes\Email;

include('classes/Email.php'); 
include('classes/Database.php');

require 'vendor/autoload.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if ($_POST['formulario'] == 'email') {

            if (!isset($_POST['text_email']) || !isset($_POST['text_assunto']) || !isset($_POST['text_mensagem'])){
                $error = 'Pelo menos um dos campos não existe!';
            }

            $email = $_POST['text_email'];
            $assunto = $_POST['text_assunto'];
            $mensagem = $_POST['text_mensagem'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = 'Email fornecido é inválido!';
            }
            else {
                $email = new Email($email, $assunto, $mensagem);
                //$email->sendEmail();
                $sucess = 'Email enviado com sucesso!';
            }
        }

        if ($_POST['formulario'] == 'newsletter') {

            if (!empty($_POST['text_email'])) {
                $db_server = $_ENV['DB_SERVER'];
                $db_name = $_ENV['DB_NAME']; 
                $db_charset = $_ENV['DB_CHARSET'];
                $db_username = $_ENV['DB_USERNAME']; 
                $db_password = $_ENV['DB_PASSWORD'];

                $email = $_POST['text_email'];
    
                $db = new Database($db_server, $db_name, $db_charset, $db_username, $db_password);

                $query_select = "SELECT `email` FROM `emails` WHERE `email` = :email";
                $result = $db->EXE_QUERY($query_select, array(":email" => $email));

                if (count($result) > 0) {
                    $error = 'Este e-mail já está cadastrado!';
                }
                else {
                    $query_into = "INSERT INTO `emails` (`email`) VALUES (:email)";
                    $db->EXE_NON_QUERY($query_into, array(":email" => $email));
                    $sucess = 'Email cadastrado com sucesso!';
                }
                
            }
        }
    }
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-6 text-center pt-3 pb-3">
            <h1>Formulário de Contato</h1>
            <?php if (!empty($error) && isset($error) && $_POST['formulario'] == 'email'): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif?>
            <?php if (!empty($sucess) && isset($sucess) && $_POST['formulario'] == 'email'): ?>
                <div class="alert alert-success"><?= $sucess ?></div>
            <?php endif?>
            <form action="?p=contato" method="POST">
                <input type="hidden" name="formulario" value="email">
                <div class="form-group">
                    <input type="email" class="form-control" name="text_email" placeholder="Email..." required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="text_assunto" placeholder="Assunto..." required>
                </div>
                <div class="form-group">
                    <textarea name="text_mensagem" class="form-control" placeholder="Mensagem..." cols="60" rows="10" required></textarea>
                </div>
                <div class="text-right">
                    <input type="submit" class="btn btn-primary" value="Enviar Mensagem">
                </div>
            </form>
        </div>
        <div class="offset-3 col-6 text-center pt-3">
            <h3>NewSletter</h3>
            <div class="error">
                <?php if (!empty($error) && isset($error) && $_POST['formulario'] == 'newsletter'): ?>
                    <div class="alert alert-danger error"><?= $error ?></div>
                <?php endif?>
                <?php if (!empty($sucess) && isset($sucess) && $_POST['formulario'] == 'newsletter'): ?>
                    <div class="alert alert-success"><?= $sucess ?></div>
                <?php endif?>
            </div>
            <form action="?p=contato" method="POST">
                <div class="form-group">
                    <input type="hidden" name="formulario" value="newsletter">
                    <div class="form-group">
                        <input type="email" class="form-control" name="text_email" placeholder="Cadastre seu email aqui..." required>
                    </div>
                    <div class="text-right pb-4">
                        <input type="submit" class="btn btn-primary" value="Receber Novidades">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--<div class="loader"></div>-->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>
    
</script>
