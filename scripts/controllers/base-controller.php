<?php

require_once(dirname(__FILE__) . '/configs.php');
require_once(dirname(__FILE__) . '/../util/Loader.php');

$loader = new Loader($configs);

/* Carregamentos iniciais */

$loader->loadUtil('Log');
$loader->loadDAO('Usuario');
$loader->loadDAO('Funcionario');
$loader->loadDAO('Aluno');
// gambiarra de wadson
$loader->loadDao('Arquivo');
$loader->loadDao('Status');
$loader->loadDao('Estagio');


//faz com que todas as mensagens de erro log sejam printadas na tela
//Log::setIsDebugging(true);

function base_url() {
    global $configs;
    return $configs['BASE_URL'];
}

function redirect($url) {
    header('Location:' . $url);
    exit();
}

function redirectToView($view) {
    header('Location:' . base_url() . "/estajui/" . $view . ".php");
    exit();
}

/* SESSÃO ------------------------------------------------------------------------------- */

/* retorna a variável de sessão */

function getSession() {
    global $loader;

    $session = $loader->loadUtil('Session', 'Session');
    $session->start();
    return $session;
}
