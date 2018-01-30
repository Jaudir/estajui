<?php

/*Classe responsável por carregar arquivos de pastas específicas dentro
do diretório de scripts*/
class Loader{
    private $configs;   //deve conter os diretórios de cada módulo referente à localização deste script

    public function __construct($configs){
        $this->$configs = $configs;
    }

    public function getConfigs(){
        return $this->configs;
    }

    public function loadModel($modelFile, $modelClassName){
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
    
    public function loadView($viewFile){
        global $configs;
        require_once($configs['VIEWS_DIR'] . '/' . $view . '.php');
    }
    
    public function loadDAO($daoFile){
        global $configs;
        require_once($configs['DAOS_DIR'] . '/' . $daoFile . '.php');
    
        //não instancia a classe
        return true;
    }
    
    public function loadUtil($utilFile, $utilClassName = null){
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
}