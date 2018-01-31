<?php

/*Acessar os dados da sessão*/
class Session{
    public function start(){
        session_start();
        $_SESSION['errors'] = array();
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

    public function isLogged(){
        return isset($_SESSION['usuario']);
    }

    public function getPermissao(){
        return $_SESSION['permissao'];
    }

    public function pushError($description){
        array_push($_SESSION['errors'], $description);
    }

    public function hasError(){
        return (count($_SESSION['erros']) > 0);
    }

    public function getErrors(){
        return $_SESSION['errors'];
    }
}