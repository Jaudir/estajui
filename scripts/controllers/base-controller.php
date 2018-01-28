<?php

require_once('configs.php');

function base_url(){
    global $configs;
    return $configs['BASE_URL'];
}

function loadModel($modelFile, $modelClassName){
    global $configs;
    global $DB;
    require_once($configs['MODELS_DIR'] . '/' . $modelFile . '.php');

    //instancia o model
    $M = new $modelClassName;

    if($M->init($DB)){
        return $M;
    }

    return null;
}

function loadView($viewFile){
    global $configs;
    require_once($configs['VIEWS_DIR'] . '/' . $view . '.php');
}

function loadDAO($daoFile){
    global $configs;
    require_once($configs['DAOS_DIR'] . '/' . $daoFile . '.php');

    //não instancia a classe
    return true;
}

function loadUtil($utilFile, $utilClassName = null){
    global $configs;
    require_once($configs['UTILS_DIR'] . '/' . $utilFile . '.php');

    //carrega uma classe específica
    if($utilClassName != null){
        $M = new $utilClassName;

        if($M->init($configs['DB'])){
            return $M;
        }else{
            return null;
        }
    }
    //returna true caso não tenha sido solicitado nenhuma classe para carregamento
    return true;
}

function redirect($url){
    header('Location:'.$url);
}