
<?php
require_once('../base-controller.php');
//require_once('../../scripts/controllers/HomeController.php');
$status = "Se Fudeu";

//!remover essa porra aqui depois! -- > Begin

$usuarioModel = $loader->loadModel("UsuarioModel", "UsuarioModel");
$result = $usuarioModel->validate('wadson.ayres@gmail.com', '12345678');
$session->setUsuario($result);


//! <-- end


$modelAluno = $loader->loadModel('AlunoModel','AlunoModel');
$aluno = $modelAluno->readbyusuario($session->getUsuario(),1);
$estagios =  $modelAluno->visualizarEstagios($aluno);