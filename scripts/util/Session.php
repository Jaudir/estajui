<?php

/*Acessar os dados da sessão*/
class Session{
    public function start(){
        session_start();
    }

    public function destroy(){
        session_destroy();
    }

    public function setUsuario($usuario, $permissao){
        $_SESSION['usuario'] = $usuario;
        $_SESSION['permissao'] = $permissao;
    }

    public function getUsuario(){
        return $_SESSION['usuario'];
    }

    public function getPermissao(){
        return $_SESSION['permissao'];
    }

    public function pushError($description){
        $_SESSION['has_error'] = true;
        array_push($_SESSION['errors'], $description);
    }

    public function hasError(){
        return $_SESSION['has_error'];
    }

    public function getErrors(){
        return $_SESSION['errors'];
    }
}