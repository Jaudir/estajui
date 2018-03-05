<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$cursoModel = $loader->loadModel('CursoModel','CursoModel');
$campusModel = $loader->loadModel('CampusModel','CampusModel');

$campi = $campusModel->recuperarTodos();

$cursos = array();
foreach($campi as $campus){
	$var = $cursoModel->recuperarPorCampus($campus);
	$cursos[$campus->getcnpj()] = $var;
}