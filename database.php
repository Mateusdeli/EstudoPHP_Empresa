<?php

use Dotenv\Dotenv;
use EMPRESA\classes\Database;

include('vendor\autoload.php');
include('classes\Database.php');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_server = $_ENV['DB_SERVER'];
$db_name = $_ENV['DB_NAME']; 
$db_charset = $_ENV['DB_CHARSET'];
$db_username = $_ENV['DB_USERNAME']; 
$db_password = $_ENV['DB_PASSWORD'];

$db = new Database($db_server, $db_name, $db_charset, $db_username, $db_password);
$results = $db->EXE_QUERY("SELECT * FROM `emails`");

foreach ($results as $key => $value) {
    echo $value['email'];
}

die("Terminado!");

