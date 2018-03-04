<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

$estagios = array();

/* Carregar dados dos estágios agurdando professor orientador*/
$estagioModel = $loader->loadModel('PlanoEstagioModel', 'PlanoEstagioModel');

//carregar estágios que estão aguardando definição de professor orientador
$estagios = $estagioModel->carregarAguardandoOrientador();

if($estagios == false){
    $estagios = array();
    $session->pushError('Falha ao carregar dados do servidor!');
}

/*Carregar professores orientadores*/
$funcModel = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');

$professores = $funcModel->carregarOrientadores();
if($professores == false){
    $professores = array();
}
