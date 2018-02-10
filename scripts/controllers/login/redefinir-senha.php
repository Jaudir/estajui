<?php

require_once(dirname(__FILE__) . '/../base_controller.php');

$session = getSession();

if(isset($_POST['c']) && isset($_POST['senha']) && isset($_POST['senha2'])){
    $emodel = $loader->loadModel('EmailModel', 'EmailModel');

    if($emodel->validarCodigoRecuperacao($_POST['c'], $_POST['senha'])){
        $session->pushValue('Senha alterada!', 'resultado');
    }else{
        $session->pushError('Falha ao completar operação!');
    }
}else{
    $session->pushError('Dados inválidos!');
}
retirect(base_url() . '/estajui/login/redefine-senha.php');