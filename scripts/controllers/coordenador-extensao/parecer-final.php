<?php
/* Carrega os dados da home do coordenador de extensão */
require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

if($session->isce()){
    $session->clearErrors();

    if(isset($_POST['estagio'])){

        $estagioModel = $loader->loadDao('EstagioModel', 'EstagioModel');

        $estagio = $estagioModel->load($_POST['estagio'], 1);

        if($estagio){
            $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
            if($model->concluirEstagio($estagio)){
                $session->pushValue('Operação realizada com sucesso', 'resultado');
            }else{
                $session->pushError('Falha de comunicação com o servidor!');
            }
        }else{
            $session->pushError('Estágio inválido!');
        }
    }else{
        $session->pushError('Dados inválidos!');
    }
}else{
    redirect(base_url());
}
redirect(base_url() . '/estajui/coordenador-extensao/home.php');