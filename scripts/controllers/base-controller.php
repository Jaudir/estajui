<?php

require_once(dirname(__FILE__) . '/configs.php');
require_once(dirname(__FILE__) . '/../util/Loader.php');

$loader = new Loader($configs);

/*Carregamentos iniciais*/
$loader->loadUtil('Log');

function base_url(){
    global $configs;
    return $configs['BASE_URL'];
}

function redirect($url){
    header('Location:'.$url);
}

/* SESSÃO ------------------------------------------------------------------------------- */

/*retorna a variável de sessão*/
function getSession(){
    global $loader;

    $session =  $loader->loadUtil('Session', 'Session');
    $session->start();
    return $session;
}

/* Verifica se o usuário está logado com a permissão requerida
    caso não esteja logado ou não tenha permissão redreciona para a página de login
    caso tenha a permissão irá retornar a variável de sessao
*/
function checkPermission($required){
    $session = getSession();

    if(!$session->isLogged())
        redirect(base_url() . '/index.php');

    if($session->getPermissao() != $required)
        redirect(base_url() . '/index.php');

    return $session;
}