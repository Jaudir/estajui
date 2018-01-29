<?php

require_once('base-constroller.php');

$session = loadUtil('Session', 'Session');

if(!isset($_POST['veredito']) || !isset($_POST['just']) || !isset($_POST['empresa_id'])){
    $session->pushError('Dados inválidos para a operação!');
}else{

    $veredito = $_POST['veredito'];
    $justificativa = $_POST['just'];
    $empresa_id = $_POST['empresa_id'];

    if($session->getPermissao() == 'CE'){
        /*Verifica pré cadastro*/

        $model = loadModel('empresa', 'EmpresaModel');
        if($model != null){
            if($model->verificaPreCadastro($empresa_id)){
                if($model->confirmarCadastro($veredito, $justificativa)){
                }else{ 
                    $session->pushError('Não foi possível realizar a operação! Por favor contate o administrador do sistema!');
                }
            }else{
                $session->pushError('Esta empresa não está pre cadastrada!');
            }
        }

    }else{
        $session->pushError('Você não tem permissão para realizar esta operação!');
    }
}
redirect(base_url() . '/estajui/coordenador-extensao/home.php');
?>