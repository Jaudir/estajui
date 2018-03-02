<?php

require_once(dirname(__FILE__) . '/configs.php');
require_once(dirname(__FILE__) . '/../util/Loader.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Usuario.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Aluno.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Funcionario.php";

$loader = new Loader($configs);

/*Carregamentos iniciais*/

$loader->loadUtil('Log');
$loader->loadDAO('Usuario');
$loader->loadDAO('Funcionario');
$loader->loadDAO('Aluno');

//faz com que todas as mensagens de erro log sejam printadas na tela
//Log::setIsDebugging(true);

function base_url() {
    global $configs;
    return $configs['BASE_URL'];
}

function redirect($url) {
    header('Location:' . $url);
}

/* SESSÃO ------------------------------------------------------------------------------- */

/* retorna a variável de sessão */

function getSession() {
    global $loader;

    $session = $loader->loadUtil('Session', 'Session');
    $session->start();
    return $session;
}
