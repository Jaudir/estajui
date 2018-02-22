<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$cursoModel = $loader->loadModel('curso-model','CursoModel');
$campusModel = $loader->loadModel('campus-model','CampusModel');

$campi = $campusModel->recuperarTodos();
$cursos = array();

foreach($campi as $campus)
	$cursos[$campus->getcnpj()] = $cursoModel->recuperarPorCampus($campus);