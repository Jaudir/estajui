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
if (is_a($usuario, "Aluno")) {
    $titulo = "Estudante";
    $estagios = $estagioModel->readbyaluno($usuario, 0);
//    $cursoModel = $loader->loadModel('curso-model', 'CursoModel');
//    $campusModel = $loader->loadModel('campus-model', 'CampusModel');
//    $campi = $campusModel->recuperarTodos();
//    $cursos = array();
//    foreach ($campi as $campus)
//        $cursos[$campus->getcnpj()] = $cursoModel->recuperarPorCampus($campus);
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
