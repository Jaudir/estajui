<?php
/* Carrega os dados da home do coordenador de extensão */
require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

$session->setUsuario(
    new Funcionario(
        "funcionario0@funcionario.com", 
        "12345", 
        2, 
        12345, 
        "Joao", 
        true, 
        true, 
        true, 
        true, 
        true, 
        "Nadica de nada", 
        true, 
        10727655000462));

if($session->isce()){
    $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');

    $statusEstagios = null;
    $statusEmpresas = null;

    if($model != null){
        /* Carregar dados de estágios e empresas e o que mais for preciso para a home do CE*/
        $statusEstagios = $model->listaEstagios();
        $statusEmpresas = $model->listaEmpresas();

        if(!$statusEstagios)
            $statusEstagios = array();
        
        if(!$statusEmpresas)
            $statusEmpresas = array();
    }
}else{
    redirect(base_url() . '/estajui/login.php');
}