<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

if(isset($_POST['c']) && isset($_POST['senha']) && isset($_POST['senha2'])){
    $emodel = $loader->loadModel('EmailModel', 'EmailModel');
    
    //validar senhas
    if($_POST['senha'] != $_POST['senha2']){
        $session->pushError('As senhas são diferentes!');
    }else if(strlen($_POST['senha']) == 0){
        $session->pushError('A senha não pode ser vazia');
    }else if(!preg_match('/[a-zA-Z0-9]/', $_POST['senha'])){
        $session->pushError('A senha deve conter letras e números!');
    }else{
        if($emodel->validarCodigoRecuperacao($_POST['c'], $_POST['senha'])){
            $session->pushValue('Senha alterada!', 'resultado');
        }else{
            $session->pushError('Falha ao completar operação!');
        }
    }
}else{
    $session->pushError('Dados inválidos!');
}