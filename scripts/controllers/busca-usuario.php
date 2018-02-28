<?php
require_once(dirname(__FILE__) . '/base-controller.php');
$session = getSession();


$_SESSION["funcionarios"] = null;
$_SESSION["leciona"] = null;
$_SESSION["busca"] = true;

var_dump($_POST);
///Comentar quando não for teste:
if(1)
///Descomentar quando não for teste
//if($session->isce())
{
	if (isset($_POST['buscar']) ) {
	//carregar arquivo da pasta util e model para cadastrar o aluno
		//echo "Oi1";
		$loader->loadUtil('String');
		//$loader->loadDao('Funcionario');	
		//var_dump($_POST);
		
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
			
			//var_dump($usuarios);
			
			$funcionarios = array();
			$leciona = array();
						
			foreach($usuarios as $usuario) {
				array_push($funcionarios, $funcionarioModel->readbyusuario($usuario, 1)[0]);
			}
			
			$funcionario = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
			
			//var_dump($funcionarios);
			
			foreach ($funcionarios as $funcionario) {
				//var_dump($funcionario);
				echo "<br>";
			}
			
			foreach($funcionarios as $funcionario) {
				//echo "Objeto da classe: " . get_class($funcionario);
				$siapeAux = $funcionario->getsiape();
				$lecionaAux = $lecionaModel->read($siapeAux,0);
				
				foreach($lecionaAux as $value)
					array_push($leciona, $value);
			}
			
			//echo "<br><br><br>Leciona<br><br><br>";
			//var_dump($leciona);
			$_SESSION["funcionarios"] = null;
			$_SESSION["leciona"] = null;
			
			$_SESSION["funcionarios"] = $funcionarios;
			$_SESSION["leciona"] = $leciona;
			
		}
		
		///Buscar por nome
		else { 
			if(isset($_POST['tipoBusca']) && $_POST['tipoBusca'] == "nome"){
			
				$_SESSION['erros'] = 0;
				$_SESSION['mensagensErro'] = array();///Vetor que indica a presença de erros;
				
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
					$_SESSION['mensagensErro'][$_SESSION['erros']] = "Problema ao buscar dados!";
					$_SESSION['erros']++;
					redirect(base_url() . '/estajui/coordenador-extensao/usuarios.php');
				}
				
				echo "<br><br><br>Funcionarios<br><br><br>";
				var_dump($funcionarios);
				
				foreach($funcionarios as $funcionario) {
					//echo "Objeto da classe: " . get_class($funcionario);
					$siapeAux = $funcionario->getsiape();
					$lecionaAux = $lecionaModel->read($siapeAux,0);
					
					foreach($lecionaAux as $value)
						array_push($leciona, $value);
				}
				
				//echo "<br><br><br>Leciona<br><br><br>";
				//var_dump($leciona);
				$_SESSION["funcionarios"] = null;
				$_SESSION["leciona"] = null;
				
				$_SESSION["funcionarios"] = $funcionarios;
				$_SESSION["leciona"] = $leciona;
			}
		
		else { ///BUSCA VAZIA
			//echo "Oi2";
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
				
				//var_dump($usuarios);
				
				///Tirar usuários que não são funcionários
				$contador = 0;
				foreach($usuarios as $usuario) {
					if($usuario->gettipo() != 2) {
						unset($usuarios[$contador]);
					}
					$contador++;
				}
				
				echo "<br><br><br><br><br><br>";
				
				$funcionarios = array();
				$leciona = array();
							
				foreach($usuarios as $usuario) {
					$funcionariosAux = $funcionarioModel->readbyusuario($usuario, 0);
					
					foreach($funcionariosAux as $f) {
										
						array_push($funcionarios, $f);	
					}
					
				}
				
				$funcionario = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
				
				echo "<br><br><br>Todos os funcionarios<br><br><br>";
				//var_dump($funcionarios);
				
				
				foreach($funcionarios as $funcionario) {
					//echo "Objeto da classe: " . get_class($funcionario);
					$siapeAux = $funcionario->getsiape();
					$lecionaAux = $lecionaModel->read($siapeAux,0);
					
					foreach($lecionaAux as $value)
						array_push($leciona, $value);
				}
				
				//echo "<br><br><br>Leciona<br><br><br>";
				//var_dump($leciona);
				$_SESSION["funcionarios"] = null;
				$_SESSION["leciona"] = null;
				
				$_SESSION["funcionarios"] = $funcionarios;
				$_SESSION["leciona"] = $leciona;
		}
	}
	}
	
	else {
		
		if(isset($_POST['buscar'])) ///Busca Vazia
		{
				$_SESSION["erros"] = 0;
				$_SESSION['mensagensErro'][$_SESSION['erros']] = "Não foi possível realizar a busca;";
				$_SESSION["erros"] = 1;
				
		}
	}
	
	
	redirect(base_url() . '/estajui/coordenador-extensao/usuarios.php');

}



