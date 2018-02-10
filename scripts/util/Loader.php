<?php

/*Classe responsável por carregar arquivos de pastas específicas dentro
do diretório de scripts*/
class Loader{
    private $modelsDir;
    private $daosDir;
    private $controllersDir;
    private $utilDir;
    private $DB;

    public function __construct($configs){
        $this->modelsDir = dirname(__FILE__) . '/../models/';
        $this->daosDir = dirname(__FILE__) . '/../daos/';
        $this->controllersDir = dirname(__FILE__) . '/../controllers/';
        $this->utilDir = dirname(__FILE__) . '/';
        $this->DB = $configs['DB'];
    }

    public function loadModel($modelFile, $modelClassName){
        require_once($this->modelsDir . $modelFile . '.php');;
    
        //instancia o model
        $M = new $modelClassName;
    
        if($M->init($this->DB, $this)){
            return $M;
        }
    
        return null;
    }
    
    public function loadDAO($daoFile){
        require_once($this->daosDir . $daoFile . '.php');
    
        //não instancia a classe
        return true;
    }
    
    public function loadUtil($utilFile, $utilClassName = null){
        require_once($this->utilDir . $utilFile . '.php');
    
        //carrega uma classe específica
        if($utilClassName != null){
            return new $utilClassName;
        }

        //returna true caso não tenha sido solicitado nenhuma classe para carregamento
        return true;
    }
}