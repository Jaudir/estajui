<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (isset($_POST["btn-logar"])) {
    if (!empty($_POST["email"]) && !empty($_POST["senha"])) {
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        
        if(!$usuarioModel = $loader->loadModel("UsuarioModel", "UsuarioModel"))
                $session->pushError("Erro ao conectar no banco de dados, tente novamente!!", "login");
        
        if($result = $usuarioModel->validate($email, $senha))
        if (is_a($result, "Funcionario")) {
            $session->setUsuario($result);
        } elseif (is_a($result, "Aluno")) {
            if ($result->getacesso())
                $session->setUsuario($result);
            else
                $session->pushError("Verifique seu email!", "login");
        } else {
            $session->pushError("Login inválido, tente novamente!", "login");
        }
    } else {
        if (empty($_POST["email"])) {
            $session->pushError("Digite o seu email!", "login");
        }
        if (empty($_POST["senha"])) {
            $session->pushError("Digite a sua senha!", "login");
        }
    }
}
if ($session->isLogged()) {
    redirect("home.php");
}
