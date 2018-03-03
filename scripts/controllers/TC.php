<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";
$session = getSession();
if (!$session->isLogged()) {
    redirect("login.php");
}


if (isset($_GET["estagio_id"])) {
    $estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
    $estagio = $estagioModel->read($_GET["estagio_id"], 1)[0];
} else {
    $session->pushError("Erro ao carregar termo de compromisso!", "error-validacao");
    redirect("home.php");
}