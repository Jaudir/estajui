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
$usuario = $session->getUsuario();
if (is_a($usuario, "Aluno")) {
    $loader->loadModel("EstagioModel","EstagioModel");
    $titulo = "Estudante";
//    $estagios = 
} elseif (is_a($usuario, "Funcionario")) {
    $titulo = "Funcionario";
} else {
    redirect("login.php");
}
$nome = $usuario->getnome();
