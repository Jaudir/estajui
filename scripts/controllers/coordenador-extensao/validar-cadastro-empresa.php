<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

if($session->isce()){
    if(!isset($_POST['veredito']) || !isset($_POST['justificativa']) || !isset($_POST['cnpj'])){
        $session->pushError('Dados inválidos para a operação!');
    }else{
        $veredito = ($_POST['veredito'] == 1 ? 1 : -1); 
        $justificativa = $_POST['justificativa'];
        $cnpj = $_POST['cnpj'];

        $session->clearErrors();
        $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
        if($model != null){
            if(!$model->verificaPreCadastro($cnpj)){
                //altera convênio e notifica alunos
                if(!$model->alterarConvenio($veredito, $justificativa, $cnpj, $session->getUsuario())){
                    $session->pushError('Falha de comunicação com o servidor');
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
