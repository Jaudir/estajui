<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

$session->getUsuario()->setoe(true);
if($session->isoe()){
    if(isset($_POST['estagio']) && isset($_POST['professor'])){
        $estagioId = $_POST['estagio'];
        $professorSiape = $_POST['professor'];
        $alterando = $_POST['tipo'] != 'define';  //está definindo o orientador ou ou está alterando?

        $loader->loadDao('Estagio');

        $model = $loader->loadModel('OrientaEstagio', 'OrientaEstagio');

        if($model->defineOrientador(new Estagio($estagioId, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null), $professorSiape, $session->getUsuario(), $alterando)){
            $session->pushValue('Orientador definido!', 'resultado');
        }else{
            $session->pushError('Falha ao salvar dados!');
        }
    }else{
        $session->pushError('Campo(s) obrigatório(s) não foram preenchidos.');
    }
}else{
    $session->pushError('Você não tem permissão para essa operação');
}
redirect(base_url() . '/estajui/organizador-estagio/home.php');