<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

$loader->loadDao('Funcionario');

//descomentar para testes
$session->setUsuario(
    new Funcionario(
        "func@func", 
        "12345", 
        5, 
        12345, 
        "Joao", 
        true, 
        true, 
        true, 
        true, 
        true, 
        "Nadica de nada", 
        true, 
        10727655000462));

if($session->isce()){
    if((!isset($_POST['aprova']) && !isset($_POST['reprova'])) || !isset($_POST['justificativa']) || !isset($_POST['cnpj'])){
        $session->pushError('Dados inválidos para a operação!');
    }else{
        $veredito = (isset($_POST['aprova']) ? 1 : -1); 
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
                $session->pushError('Esta empresa já está pre cadastrada!');
            }
        }
    }
}else{
    $session->pushError('Você não tem permissão para realizar esta operação!');
}
redirect(base_url() . '/estajui/coordenador-extensao/home.php');
//$session->printErrors();
