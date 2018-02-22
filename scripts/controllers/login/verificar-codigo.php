<?php

/*Verifica se o código passado é válido, caso seja, recupera informações relacionadas ao usuário*/

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();
$usuario = null;

if(isset($_GET['c'])){
    $email = $loader->loadModel('EmailModel', 'EmailModel');

    if($email->verificarValidadeCodigo($_GET['c'], EmailModel::$CODIGO_RECUPERACAO) == false){
        $session->pushError('O código foi expirado e/ou não é mais válido!');
    }
}else{
    $session->pushError('Código inválido!');
}