<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

if($session->isce()){
    if(!isset($_POST['veredito']) || !isset($_POST['justificativa']) || !isset($_POST['cnpj'])){
        $session->pushError('Dados inválidos para a operação!');
    }else{
    $veredito = $_POST['veredito'];
    $justificativa = $_POST['justificativa'];
    $cnpj = $_POST['cnpj'];

    $model = $loader->loadModel('coord-ext', 'CoordExtModel');
    if($model != null){
        if(!$model->verificaPreCadastro($cnpj)){
            //altera convênio e notifica alunos
            if($model->alterarConvenio($veredito, $justificativa, $cnpj)){
            }else{ 
                $session->pushError('Não foi possível realizar a operação! Por favor contate o administrador do sistema!');
            }
        }else{
            $session->pushError('Esta empresa não está pre cadastrada!');
        }
    }
}
}else{
    $session->pushError('Você não tem permissão para realizar esta operação!');
}
redirect(base_url() . '/estajui/coordenador-extensao/home.php');
