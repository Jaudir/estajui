<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$cursoModel = $loader->loadModel('curso-model','CursoModel');
$campusModel = $loader->loadModel('campus-model','CampusModel');

$campi = $campusModel->recuperarTodos();
$cursos = array();

foreach($campi as $campus){
	$var = $cursoModel->recuperarPorCampus($campus);
	$cursos[$campus->getcnpj()] = $var;
	print_r($var);
	echo "<br>";
}