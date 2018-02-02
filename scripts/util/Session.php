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

    /* cahamr quando efetuar o login do usuário */
    public function setUsuario($usuario){
        $_SESSION['is_func'] = (get_class($usuario) == 'Funcionario');
        $_SESSION['usuario'] = $usuario;
    }

    public function getUsuario(){
        return $_SESSION['usuario'];
    }

    public function ispo(){
        return ($_SESSION['is_func'] && $_SESSION['usuario']->ispo());
    }

    public function isoe(){
        return ($_SESSION['is_func'] && $_SESSION['usuario']->isoe());
    }

    public function isce(){
        return ($_SESSION['is_func'] && $_SESSION['usuario']->isce());
    }

    public function issra(){
        return ($_SESSION['is_func'] && $_SESSION['usuario']->issra());
    }

    public function isroot(){
        return ($_SESSION['is_func'] && $_SESSION['usuario']->isroot());
    }

    public function isLogged(){
        return isset($_SESSION['usuario']);
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
