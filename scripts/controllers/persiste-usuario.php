<?php

require_once(dirname(__FILE__) . '/base-controller.php');
//require_once('base-controller.php');

$session = getSession();

///Comentar quando não for teste:
if(1)
///Descomentar quando não for teste
//if($session->isce())
{
	if (isset($_POST['cadastrar'])) {
	//carregar arquivo da pasta util e model para cadastrar o aluno
	$loader->loadUtil('String');
	$loader->loadDao('Funcionario');	


	//session_start();
	//talvez seja uma boa inicializar o aluno pelo post(não no construtor, mas em um método init():bool)
	//$aluno = new Aluno(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
	$funcionario = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
	$cursos = array();
	
	$funcionario->setnome(LimpaString::limpar($_POST['nome']));
	$funcionario->setsiape((int)(LimpaString::limpar($_POST['siape'])));
	
	$funcionario->setroot(0);
	$funcionario->setpo(0);
	if(isset($_POST['PO'])) {
		//$funcionario->setpo(FALSE);
	if($_POST['PO'] == "on")
	$funcionario->setpo(1);
	}
	
	$funcionario->setce(0);
	if(!isset($_POST['CE'])) {
		//$funcionario->setce(FALSE);
	if($_POST['CE'] == "on")
	$funcionario->setce(1);
	}
	
	$funcionario->setsra(0);
	if(isset($_POST['SRA'])) {
		//$funcionario->setsra(FALSE);
	if($_POST['SRA'] == "on")
	$funcionario->setsra(1);
	}
	
	$funcionario->setoe(0);
	if(isset($_POST['OE'])) {
		//$funcionario->setpo(FALSE);
	if($_POST['OE'] == "on")
	$funcionario->setoe(1);
	}
	$funcionario->setlogin(LimpaString::limpar($_POST['email']));
	
	if(isset($_POST['CComp']) && $_POST['CComp'] == "on")
		array_push($cursos,"cienciadacomputacao");
	if(isset($_POST['EQuim']) && $_POST['EQuim'] == "on")
		array_push($cursos,"engenhariaquimica");
	if(isset($_POST['TecInf']) && $_POST['TecInf'] == "on")
		array_push($cursos,"tecnicoeminformatica");
	if(isset($_POST['TecQuim']) && $_POST['TecQuim'] == "on")
		array_push($cursos,"tecnicoemquimica");
	if(isset($_POST['TecElet']) && $_POST['TecElet'] == "on")
		array_push($cursos,"tecnicoemeletrotecnica");
	
	//$_SESSION['cursos'] = $cursos;
	
	$_SESSION['erros'] = 0;
	$_SESSION['mensagensErro'] = array();///Vetor que indica a presença de erros;
	
	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || !filter_var($_POST["confirmEmail"], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['mensagensErro'][$_SESSION['erros']] = "Os e-mails informados não são válidos!;";
		$_SESSION['erros']++;
		//array_push($_SESSION['mensagensErro'], "Os e-mails informados não são válidos!;");
	} else {
		if (strcmp($_POST["email"],$_POST["confirmEmail"])!=0) {
			$_SESSION['mensagensErro'][$_SESSION['erros']] = "Problema com o e-mail! Verifique se o de confirmação é o mesmo e-mail.;";
			$_SESSION['erros']++;
			//array_push($_SESSION['mensagensErro'], "Problema com o e-mail! Verifique se o de confirmação é o mesmo e-mail.;");
	}
	}

	if($_SESSION['erros'] != 0) {
		//$_SESSION['pau'] = "Deveria voltar";
		redirect(base_url() . '/estajui/coordenador-extensao/usuarios.php');
	}
	
	//$SESSION['pau2'] = "E passou...";
	//echo "<br>".$funcionario->isroot();

	$model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
	if($model != null){
		if(!$model->cadastrar($funcionario, $cursos)){
			$_SESSION['mensagensErro'][$_SESSION['erros']] = "Problema ao salvar! Erro no BD ou e-mail já cadastrado!";
			$_SESSION['erros']++;
			//array_push($_SESSION['mensagensErro'], "Problema ao salvar! Erro no BD ou e-mail já cadastrado!");
			//redirect(base_url() . '/estajui/coodenador-extensao/usuarios.html');
		}
	}
	//header("Location: cadastro.php");
	redirect(base_url() . '/estajui/coordenador-extensao/usuarios.php');
	}
}else{
	redirect('../../estajui/login.html');
}