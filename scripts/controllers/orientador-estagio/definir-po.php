<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

if($session->isoe()){
    if(isset($_POST['estagio']) && isset($_POST['professor'])){
        $estagioId = $_POST['estagio'];
        $professorSiape = $_POST['professor'];
        $alterando = $_POST['tipo'] != 'define';  //está definindo o orientador ou ou está alterando?

        $model = $loader->loadModel('OrientaEstagio', 'OrientaEstagio');

        if($model->defineOrientador($estagioId, $professorSiape, $alterando)){
            $session->pushValue('Ok', 'resultado');
        }else{
            $session->pushError('Falha ao salvar dados!');
        }
    }else{
        $session->pushError('Campo(s) obrigatório(s) não foram preenchidos.');
    }
}else{
    $session->pushError('Você não tem permissão para essa operação');
}
//redirect(base_url() . '');