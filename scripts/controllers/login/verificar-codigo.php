<?php

/*Verifica se o código passado é válido, caso seja, recupera informações relacionadas ao usuário*/

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();
$usuario = null;

if(isset($_GET['c'])){
    $email = $loader->loadModel('EmailModel', 'EmailModel');

    $usuario = $email->verificarUsuarioCodigo($_GET['c']);

    if(!$usuario){
        $session->pushError('O código foi expirado e não é mais válido!');
    }
}else{
    $session->pushError('Código inválido!');
}