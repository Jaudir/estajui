<?php
/* Carrega os dados da home do coordenador de extensão */
require_once(dirname(__FILE__) . '/../base-controller.php');

//$session = checkPermission('CE');

$model = $loader->loadModel('coord-ext', 'CoordExtModel');

$statusEstagios = null;
$statusEstagios = null;

if($model != null){
    /* Carregar dados de estágios e empresas */
    $statusEstagios = $model->listaEstagios();
    $statusEmpresas = $model->listaEmpresas();

    if(!$statusEstagios)
        $statusEstagios = array();
    
    if(!$statusEmpresas)
        $statusEmpresas = array();
}