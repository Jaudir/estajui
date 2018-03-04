<?php

/*Acessar os dados da sessão*/
class Session{
    public function start(){
        session_start();

        if(!isset($_SESSION['errors']))
            $_SESSION['errors'] = array();

        if(!isset($_SESSION['values']))
            $_SESSION['values'] = array();
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

    public function isAluno(){
        return !$_SESSION['is_func'];
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

    public function pushValue($value, $key){
        if(!isset($_SESSION['values'][$key]))
            $_SESSION['values'][$key] = array();

        array_push($_SESSION['values'][$key], $value);
    }

    public function getValues($key){
        if(isset($_SESSION['values'][$key])){
            $v = $_SESSION['values'][$key];
            unset($_SESSION['values'][$key]);
            return $v;
        }
        return null;
    }

    public function hasValues($key = null){
        if($key == null)
            return count($_SESSION['values']) > 0;
        return isset($_SESSION['values'][$key]);
    }

    public function clearValues(){
        $_SESSION['values'] = array();
    }

    public function pushError($description, $type = 'normal'){
        if(!isset($_SESSION['errors'][$type]))
            $_SESSION['errors'][$type] = array();

        array_push($_SESSION['errors'][$type], $description);
    }

    public function hasError($type = null){
        if($type == null)
            return (count($_SESSION['errors']) > 0);
        return (isset($_SESSION['errors'][$type]) && count($_SESSION['errors'][$type]) > 0);
    }

    public function getErrors($type){
        if(isset($_SESSION['errors'][$type])){
            $err = $_SESSION['errors'][$type];
            unset($_SESSION['errors'][$type]);
            return $err;
        }
        return null;
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

    /*
        Pega os dados do post e passa para os valores na sessão
        Parametros: 
            filter: dados para serem filtrados
            boolExclude: Se for true, os dados em filter serão ignorados durante a cópia, caso sea
                        falso, os dados em filter serão os únicos à serem adicionados.
    */
    public function valuesFromPOST($filter = array(), $boolExclude = true){
        $values = array();

        if($boolExclude == false)
            $values = array_intersect_key($_POST, $filter);
        else
            $values = array_diff_key($_POST, $filter);

        foreach($values as $key => $value){
            $this->pushValue($value, $key);
        }
    }
}
