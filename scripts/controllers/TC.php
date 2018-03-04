<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";
$session = getSession();
if (!$session->isLogged()) {
    redirect("./../login.php");
}


if (isset($_GET["estagio_id"])) {
    $estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
    $estagio = $estagioModel->read($_GET["estagio_id"], 1);
    $usuario = $session->getUsuario();
    if (count($estagio) != 0) {
        $estagio = $estagio[0];
        if (is_a($usuario, "Aluno")) {
            if ($usuario->getcpf() != $estagio->getaluno()->getcpf()) {
                $session->pushError("Erro ao carregar Termo de Compromisso!", "error-critico");
                redirect("./../home.php");
            }
        }
    } else {
        $session->pushError("Erro ao carregar Termo de Compromisso!", "error-critico");
        redirect("./../home.php");
    }
} else {
    $session->pushError("Erro ao carregar Termo de Compromisso!", "error-critico");
    redirect("./../home.php");
}