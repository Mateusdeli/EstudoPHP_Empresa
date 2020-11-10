<?php

session_start();    

use Dotenv\Dotenv;
use EMPRESA\classes\Database;

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
    // $db_server = $_ENV['DB_SERVER'];
    // $db_name = $_ENV['DB_NAME']; 
    // $db_charset = $_ENV['DB_CHARSET'];
    // $db_username = $_ENV['DB_USERNAME']; 
    // $db_password = $_ENV['DB_PASSWORD'];

    // $db = new Database($db_server, $db_name, $db_charset, $db_username, $db_password);

    $email = $_POST['text_email'];
    $password = $_POST['text_password'];

    $e = "mateus_forlevesi@hotmail.com";
    $p = '123';

    if ($email == $e && $password == $p){
        $_SESSION['login'] = array(
            'user' => $email,
            'logged' => true
        );
        return true;
    }

    return false;
}