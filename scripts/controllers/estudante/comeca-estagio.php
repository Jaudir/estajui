<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

if (!$session->isAluno())
    redirect(base_url() . '/estajui/login/login.php');

$session->clearErrors();
if (!isset($_POST['obrigatorio'], $_POST['campus'], $_POST['curso'], $_POST['horario'])) {
    $session->pushError('Dados inválidos!');
    redirect(base_url() . '/estajui/estudante/home-novo-estagio.php');
}

$loader->loadUtil('String');
$loader->loadDao('Curso');
$loader->loadDao('Campus');
$loader->loadDao('Estagio');
#$loader->loadDao('Email');
$cursoModel = $loader->loadModel('CursoModel', 'CursoModel');
$campusModel = $loader->loadModel('CampusModel', 'CampusModel');
$estagioModel = $loader->loadModel('EstagioModel', 'EstagioModel');
$modificacaoModel = $loader->loadModel('ModificacaoStatusModel', 'ModificacaoStatusModel');
$model = $loader->loadModel('AlunoModel', 'AlunoModel');
$statusModel = $loader->loadModel("StatusModel", "StatusModel");

$curso = new Curso($_POST['curso'], null);
$campus = new Campus($_POST['campus'], null, null);

$obrigatorio = 0;
if (isset($_POST['obrigatorio']) && $_POST['obrigatorio'] == '1')
    $obrigatorio = 1;
else
    $obrigatorio = 0;

$estagio = new Estagio(null, 0, $obrigatorio, null, null, null, null, null, null, null, null, null, null, null, null, $session->getUsuario(), null, null, null, null);

$status = $statusModel->read(1, 1);
if ($status)
    $estagio->setstatus($status[0]);
else
    $session->pushError("Erro ao definir novo status!", "error-critico");
if ($model != null) {
    if (!$estagioModel->create($estagio)) {
        $modificacao = new ModificacaoStatus(null, date("Y-m-d H:i:s"), $estagio, $status[0], $session->getUsuario());
        $modificacaoModel->create($modificacao);
        $session->pushValue('Estágio pré-cadastrado!', 'resultado');
    } else {
        $session->pushError('Falha ao cadastrar estágio!');
    }
} else {
    $session->pushError('Falha ao comunicar com o servidor!');
}

redirect(base_url() . '/estajui/home.php');
