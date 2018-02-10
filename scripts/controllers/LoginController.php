<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (isset($_POST["email"]) && isset($_POST["senha"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $usuarioModel = $loader->loadModel("UsuarioModel", "UsuarioModel");
    $result = $usuarioModel->validate($email, $senha);
    if (is_a($result, "Aluno") || is_a($result, "Funcionario")) {
        $session->setUsuario($result);
    } else {
        $session->pushError("Login inválido, tente novamente!", "login");
    }
}
if ($session->isLogged()) {
    redirect("home.php");
}
