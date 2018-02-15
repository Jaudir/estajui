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

if (isset($_POST["submit"])) {
//    if (isset($_POST["matricula"]) && isset($_POST["semestre"]) && isset($_POST["serie"]) && isset($_POST["modulo"]) && isset($_POST["periodo"]) && isset($_POST["integralizacao"]) && isset($_POST["dependencias"]) && isset($_POST["aptidao"]))
    if (!empty($_POST["matricula"]) && !empty($_POST["semestre"]) && !empty($_POST["aptidao"]) && !empty($_POST["justificativa"])) {
        
    } else {
        if (empty($_POST["matricula"])) {
            $session->pushError("Digite a matricula do aluno!", "avalia-peError");
        } elseif (empty($_POST["semestre"])) {
            $session->pushError("Digite o semestre/ano que o aluno iniciou o curso! (Ex.: 2/2017)", "avalia-peError");
        } elseif (empty($_POST["aptidao"])) {
            $session->pushError("Avalie se o o aluno está apto a realizar o estágio!", "avalia-peError");
        } else {
            $session->pushError("Justifique a sua decisão!", "avalia-peError");
        }
        redirect("home.php?id=");
    }
}