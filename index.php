<?php

use Dotenv\Dotenv;

    include('layout/html_header.php');
    include('layout/nav.php'); 
    include('vendor/autoload.php');

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $pag = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 'home';

    switch ($pag) {
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
        default:
            include_once('error.php');
    }

    include('layout/footer.php');
    include('layout/html_footer.php');