<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (isset($_POST["email"]) && isset($_POST["senha"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $result = Usuario::validate($email, $senha);
    if (is_a($result, "Aluno") || is_a($result, "Funcionario")) {
        $session->setUsuario($result);
    } else {
        $session->pushError("Erro ao fazer login, tente novamente!");
    }
}
if ($session->isLogged()) {
    redirect("home.php");
}
