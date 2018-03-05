<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (isset($_GET["logoff"])) {
    $session->destroy();
    redirect("login.php");
}
if (!$session->isLogged()) {
    redirect("login.php");
}
$estagios = array();
$usuario = $session->getUsuario();
$estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
$notificacoesModel = $loader->loadModel("NotificacaoModel", "NotificacaoModel");
$notificacoes = $notificacoesModel->getNotificacoes($usuario);
if (is_a($usuario, "Aluno")) {
    $titulo = "Estudante";
    $estagios = $estagioModel->readbyaluno($usuario, 0);
    $cursoModel = $loader->loadModel('CursoModel', 'CursoModel');
    $campusModel = $loader->loadModel('CampusModel', 'CampusModel');

    $campi = $campusModel->recuperarTodos();

    $cursos = array();
    foreach ($campi as $campus) {
        $var = $cursoModel->recuperarPorCampus($campus);
        $cursos[$campus->getcnpj()] = $var;
    }
} elseif (is_a($usuario, "Funcionario")) {
    if ($usuario->isroot()) {
        $titulo = "Administrador";
    } elseif ($usuario->isce()) {
        $titulo = "Coordenador de extensão";
    } elseif ($usuario->isoe()) {
        $titulo = "Organizador de estagio";
    } elseif ($usuario->issra()) {
        $titulo = "Secretaria";
        $estagios = $estagioModel->read(null, 0);
    } elseif ($usuario->ispo()) {
        $titulo = "Professor orientador";
    } else {
        $titulo = "Funcionario";
    }
} else {
    redirect("login.php");
}
$nome = $usuario->getnome();
