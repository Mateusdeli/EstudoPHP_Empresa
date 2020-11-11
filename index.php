<?php

session_start();    

use EMPRESA\classes\Database;
use Dotenv\Dotenv;


include('classes/Database.php');
include('layout/html_header.php');
include('layout/nav.php'); 
include('layout/user.php'); 
include('vendor/autoload.php');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pag = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 'home';

switch ($pag) {

    case 'logout':
        session_destroy();
        header('Location:'. $_SERVER['PHP_SELF']);
    break;

    case 'home':
        include_once('home.php');
    break;
    case 'empresa':
        include_once('empresa.php');
    break;
    case 'servicos':
        include_once('servicos.php');
    break;
    case 'contato':
        include_once('contato.php');
    break;
    case 'admin':
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (checkLogin()) {
                include('layout/user.php');
            }
        }
        include_once('admin.php');
    break;
    default:
        include_once('error.php');
}

include('layout/footer.php');
include('layout/html_footer.php');

function checkLogin()
{
    
    $db_server = $_ENV['DB_SERVER'];
    $db_name = $_ENV['DB_NAME']; 
    $db_charset = $_ENV['DB_CHARSET'];
    $db_username = $_ENV['DB_USERNAME']; 
    $db_password = $_ENV['DB_PASSWORD'];

    $db = new Database($db_server, $db_name, $db_charset, $db_username, $db_password);

    $email = trim($_POST['text_email']);
    $password = trim($_POST['text_password']);

    $params = array(
        ':e' => $email
    );
    $query = "SELECT * FROM `users` WHERE `email` = :e LIMIT 1";

    $datatable = $db->EXE_QUERY($query, $params);

    if (count($datatable) > 0) {
        $user_pass = $datatable[0]['pass'];
        $user_email = $datatable[0]['email'];
        if (password_verify($password, $user_pass)) {
            $_SESSION['login'] = array(
                'user' => $user_email,
                'logged' => true
            );
            return true;
        }
        return false;
    }
    else{
        return false;
    }
}