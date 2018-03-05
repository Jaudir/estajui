<?php
require_once(dirname(__FILE__) . '/base-controller.php');
$session = getSession();


///Comentar quando não for teste:
//if(1)
///Descomentar quando não for teste
if($session->isce())
{
	if (isset($_POST['buscar']) ) {
	//carregar arquivo da pasta util e model para cadastrar o aluno
		
		$loader->loadUtil('String');
		
		
		///Buscar por e-mail
		if(isset($_POST['tipoBusca']) && $_POST['tipoBusca'] == "email") {
			$loader->loadDao('Usuario');
			$loader->loadDao('Funcionario');
			$loader->loadDao('Leciona');
			$loader->loadDao('OfereceCurso');
			
			///Carregando dados para as variáveis
			$usuarioModel = $loader->loadModel('UsuarioModel','UsuarioModel');$funcionarioModel = $loader->loadModel('FuncionarioModel','FuncionarioModel');
			$funcionarioModel = $loader->loadModel('FuncionarioModel','FuncionarioModel');
			$lecionaModel = $loader->loadModel('LecionaModel','LecionaModel');
			$ofereceCursoModel = $loader->loadModel('OfereceCursoModel','OfereceCursoModel');
			
			$usuarios = $usuarioModel->read($_POST['campoBusca'],0);
			
						
			$funcionarios = array();
			$leciona = array();
						
			foreach($usuarios as $usuario) {
				if($funcionarioModel->readbyusuario($usuario, 1) != null)
					array_push($funcionarios, $funcionarioModel->readbyusuario($usuario, 1)[0]);
			}
			
			$funcionario = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
			
						
			foreach ($funcionarios as $funcionario) {
				
				echo "<br>";
			}
			
			foreach($funcionarios as $funcionario) {
				
				$siapeAux = $funcionario->getsiape();
				$lecionaAux = $lecionaModel->read($siapeAux,0);
				
				foreach($lecionaAux as $value)
					array_push($leciona, $value);
			}
			
					
			
			$session->pushValue($funcionarios, "funcionarios");
			$session->pushValue($leciona, "leciona");
			
			
			
		}
		
		///Buscar por nome
		else { 
			if(isset($_POST['tipoBusca']) && $_POST['tipoBusca'] == "nome"){
						
				$loader->loadDao('Usuario');
				$loader->loadDao('Funcionario');
				$loader->loadDao('Leciona');
				$loader->loadDao('OfereceCurso');
				
				$leciona = array();
				$funcionarios = array();
				
				///Carregando dados para as variáveis
				$usuarioModel = $loader->loadModel('UsuarioModel','UsuarioModel');
				$funcionarioModel = $loader->loadModel('FuncionarioModel','FuncionarioModel');
				$lecionaModel = $loader->loadModel('LecionaModel','LecionaModel');
				$ofereceCursoModel = $loader->loadModel('OfereceCursoModel','OfereceCursoModel');
				
				
				$funcionarios = $funcionarioModel->readbynome($_POST['campoBusca'],0) ;
				if ($funcionarios == 2) {
					
					$session->pushError("Problema ao buscar dados!", "erro");
					redirect(base_url() . '/estajui/coordenador-extensao/usuarios.php');
				}
				
				
				foreach($funcionarios as $funcionario) {
					
					$siapeAux = $funcionario->getsiape();
					$lecionaAux = $lecionaModel->read($siapeAux,0);
					
					foreach($lecionaAux as $value)
						array_push($leciona, $value);
				}
				
				
				$session->pushValue($funcionarios, "funcionarios");
				$session->pushValue($leciona, "leciona");
				
			}
		
		else { ///BUSCA VAZIA
			
				$loader->loadUtil('String');
				$loader->loadDao('Funcionario');	
				
				$loader->loadDao('Usuario');
				$loader->loadDao('Funcionario');
				$loader->loadDao('Leciona');
				$loader->loadDao('OfereceCurso');
				
				///Carregando dados para as variáveis
				$usuarioModel = $loader->loadModel('UsuarioModel','UsuarioModel');
				$funcionarioModel = $loader->loadModel('FuncionarioModel','FuncionarioModel');
				$lecionaModel = $loader->loadModel('LecionaModel','LecionaModel');
				$ofereceCursoModel = $loader->loadModel('OfereceCursoModel','OfereceCursoModel');
				
				$usuarios = $usuarioModel->read("",0);
				
				
				///Tirar usuários que não são funcionários
				$contador = 0;
				foreach($usuarios as $usuario) {
					if($usuario->gettipo() != 2) {
						unset($usuarios[$contador]);
					}
					$contador++;
				}
				
				
				
				$funcionarios = array();
				$leciona = array();
							
				foreach($usuarios as $usuario) {
					$funcionariosAux = $funcionarioModel->readbyusuario($usuario, 0);
					
					foreach($funcionariosAux as $f) {
										
						array_push($funcionarios, $f);	
					}
					
				}
				
				$funcionario = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
				
				
				foreach($funcionarios as $funcionario) {
					
					$siapeAux = $funcionario->getsiape();
					$lecionaAux = $lecionaModel->read($siapeAux,0);
					
					foreach($lecionaAux as $value)
						array_push($leciona, $value);
				}
				
				
				$session->pushValue($funcionarios, "funcionarios");
				$session->pushValue($leciona, "leciona");
		}
	}
	}
	
	else {
		
		if(isset($_POST['buscar'])) ///Busca Vazia
		{
				
				$session->pushError("Não foi possível realizar a busca", "erro");
				
		}
	}
	
	
	$session->pushValue(true, "busca");
	redirect(base_url() . '/estajui/coordenador-extensao/usuarios.php');	
	 
}