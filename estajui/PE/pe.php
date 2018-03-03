<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";
$session = getSession();
if (!$session->isLogged()) {
    redirect("login.php");
}


if (isset($_GET["estagio_id"])) {

    $estagioModel = $this->loader->loadModel("EstagioModel", "EstagioModel");
    if ($estagioModel) {
        $estagio = $estagioModel->read($_GET["estagio_id"], 1)[0];
        if (is_array($estagio)) {
            if (count($estagio) == 1) {
                
            } else {
                $session->pushError("Erro ao carregar plano de estágio!", "error-validacao");
                redirect("home.php");
            }
        }
        $session->pushError("Erro ao carregar plano de estágio!", "error-validacao");
        redirect("home.php");
    } else {
        $session->pushError("Erro ao carregar plano de estágio!", "error-validacao");
        redirect("home.php");
    }
} else {
    $session->pushError("Erro ao carregar plano de estágio!", "error-validacao");
    redirect("home.php");
}