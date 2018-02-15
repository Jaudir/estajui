<?php
require_once(dirname(__FILE__) . '/base-controller.php');
$session = getSession();

///Comentar quando não for teste:
if(1)
///Descomentar quando não for teste
//if($session->isce())
{
	if (isset($_POST['buscar'])) {
	//carregar arquivo da pasta util e model para cadastrar o aluno
		$loader->loadUtil('String');
		$loader->loadDao('Funcionario');	
		var_dump($_POST);
		
		///Buscar por e-mail
		if(isset($_POST['tipoBusca']) && $_POST['tipoBusca'] == "email") {
			$loader->loadDao('Usuario');
			$loader->loadDao('Funcionario');
			$loader->loadDao('Leciona');
			$loader->loadDao('OfereceCurso');
			
			///Carregando dados para as variáveis
			$usuarioModel = $loader->loadModel('UsuarioModel','UsuarioModel');
			$funcionarioModel = $loader->loadModel('FuncionarioModel','FuncionarioModel');
			$lecionaModel = $loader->loadModel('LecionaModel','LecionaModel');
			$ofereceCursoModel = $loader->loadModel('OfereceCursoModel','OfereceCursoModel');
			
			$usuarios = $usuarioModel->read($_POST['campoBusca'],0);
			
			$funcionarios = array();///O funcionário i corresponde ao usuário i
			$leciona = array(array());
						
			foreach($usuarios as $usuario) {
				array_push($funcionarios, $funcionarioModel->readbyusuario($usuario, 1)[0]);
			}
			
			$funcionario = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
			
			foreach($funcionarios as $funcionario) {
				$lecionaAux = $lecionaModel->read($funcionario->getsiape(),0);
				
				foreach($lecionaAux as $value)
					array_push($leciona, $value);
			}
			
			
		}
		
		///Buscar por nome
		if(isset($_POST['tipoBusca']) && $_POST['tipoBusca'] == "nome"){
			
		}
	}

}



