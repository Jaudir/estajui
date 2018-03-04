<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

$estagios = array();

/* Carregar dados dos estágios agurdando professor orientador*/
$estagioModel = $loader->loadModel('PlanoEstagioModel', 'PlanoEstagioModel');

$estagios = $estagioModel->carregarAguardandoOrientador();

var_dump($estagios);
if($estagios == false){
    $estagios = array();
    $session->pushError('Falha ao carregar dados do servidor!');
}
