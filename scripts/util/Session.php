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
        $_SESSION['errors'] = array();
    }

    public function getUsuario(){
        return $_SESSION['usuario'];
    }

    public function isAluno(){
        return !$_SESSION['is_func'];
    }

    public function isUsuario(){

	}
    /*Retorna true caso o usuário logado seja funcionário*/
    public function isFuncionario(){

        return $_SESSION['is_func'];
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

    public function pushError($description, $type = 'normal'){
        if(!isset($_SESSION['errors'][$type]))
            $_SESSION['errors'][$type] = array();

        array_push($_SESSION['errors'][$type], $description);
    }

    public function hasError(){
        return (count($_SESSION['erros']) > 0);
    }

    public function getErrors(){
        return $_SESSION['errors'];
    }

    public function clearErrors(){
        $_SESSION['errors'] = array();
    }

    public function printErrors(){
        foreach($_SESSION['errors'] as $type => $descriptions){
            echo "Error type: <b>$type</b> :<br>";
            foreach($descriptions as $description){
                echo "<p style='margin-left:12px;'>Descrição: <span style='color:red;'>$description</span></p>";
            } 
        }
    }
}
