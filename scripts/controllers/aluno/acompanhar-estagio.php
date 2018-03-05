<?php

/* Contexto do caso de uso:
 * Visualizar informações gerais de todos os estágios do estudante e 
 * permitir que ele escolha algum para mais detalhes
 */
require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();
if (isset($_GET["logoff"])) {
    $session->destroy();
    redirect("../login.php");
}
if (!$session->isLogged()) {
    redirect("../login.php");
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
} else {
    redirect("../login.php");
}
$nome = $usuario->getnome();
