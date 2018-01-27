<?php

require_once('configs.php');

function base_url(){
    return $configs['BASE_URL'];
}

function loadModel($modelFile, $modelClassName){
    require_once('Sistema/' . $this->configs['MODELS_DIR'] . '/' . $modelFile . '.php');

    $M = new $modelClassName;

    if($M->init($this->configs['DB'])){
        return $M;
    }

    return null;
}

function loadView($viewFile){
    require_once('Sistema/' . $this->configs['VIEWS_DIR'] . '/' . $view . '.php');
}

function loadUtil($utilFile, $utilClassName = null){
    require_once('Sistema/' . $this->configs['UTILS_DIR'] . '/' . $utilFile . '.php');

    //carrega uma classe específica
    if($utilClassName != null){
        $M = new $utilClassName;

        if($M->init($this->configs['DB'])){
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