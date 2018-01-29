<?php
/* Carrega os dados da home do coordenador de extensão */

require_once('../base-controller.php');

$session = checkPermission('CE');

$model = loadModel('coord-ext', 'CoordExtModel');
$tabelaStatus = null;

if($model != null){
    /* Carregar dados de estágios e empresas */
    $tabelaStatus = $model->getEstagios();
    array_push($tabelaStatus, $model->getEmpresas());
}