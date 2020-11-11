<?php

use Dotenv\Dotenv;
use EMPRESA\classes\Database;

include_once('classes/Database.php');
include_once('vendor/autoload.php');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_server = $_ENV['DB_SERVER'];
$db_name = $_ENV['DB_NAME']; 
$db_charset = $_ENV['DB_CHARSET'];
$db_username = $_ENV['DB_USERNAME']; 
$db_password = $_ENV['DB_PASSWORD'];

$db = new Database($db_server, $db_name, $db_charset, $db_username, $db_password);

$email = "teste@hotmail.com";
$pass = "mateus123";

$params = array(
    ':e' => $email,
    ':p' => password_hash($pass, PASSWORD_DEFAULT)
);

$db->EXE_NON_QUERY("INSERT INTO `users` (`email`, `pass`) VALUES (:e, :p)", $params);