<?php

require_once(dirname(__FILE__) . '/base-controller.php');
if (true) {
    $session = getSession();
	if(!$session->isAluno())
		redirect(base_url() . '/estajui/login/login.php');
	
	$loader->loadUtil('String');
	$loader->loadDao('Curso');
	$loader->loadDao('Campus');
    $loader->loadDao('Estagio');
    #$loader->loadDao('Email');
	$cursoModel = $loader->loadModel('curso-model','CursoModel');
	$campusModel = $loader->loadModel('campus-model','CampusModel');
	$estagioModel = $loader->loadModel('estagio-model','EstagioModel');
	$modificacaoModel = $loader->loadModel('modifica-status-model','ModificaStatusModel');
	
	$curso = new Curso(null, $_POST['curso_nome'], null);
	$curso = $cursoModel->
	$obrigatorio = 0;
	$aluno = $session->getUsuario();
	if (isset($_POST['obrigatorio']))
		$obrigatorio = 1;
	$estagio = new Estagio(null, 0, $obrigatorio, null, null, null, null, null, null, null, null, $aluno->getcpf(), null, $curso, 0);
	
    $erros = 0;

    if (!filter_var($aluno->getlogin(), FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_erro1'] = true;
        unset($_SESSION['email']);
        unset($_SESSION['email_confirmacao']);
        $erros++;
    } else {
        if (strcmp($aluno->getlogin(), $aluno->getlogin_confirmacao())!=0) {
            $_SESSION['email_erro2'] = "Os emails informados não são iguais.";
            unset($_SESSION['email']);
            unset($_SESSION['email_confirmacao']);
            $erros++;
        }
    }

    if (strcmp($aluno->getsenha(), $aluno->getsenha_confirmacao())!=0) {
        $_SESSION['senha_erro1'] = "As senhas não iguais.";
        unset($_SESSION['senha']);
        unset($_SESSION['senha_confirmacao']);
        $erros++;
    } else {
        if (strlen($aluno->getsenha())<8) {
            $_SESSION['senha_erro2'] = true;
            unset($_SESSION['senha']);
            unset($_SESSION['senha_confirmacao']);

            $erros++;
        }
    }

    $model = $loader->loadModel('aluno-model', 'AlunoModel');

    if($model->VerificaLoginCadastrado($aluno->getlogin())){
        $_SESSION['email_cadastrado'] = true;
        $erros++;
    }


    if ($model != null  && $erros == 0) {
        if ($estagioModel->salvar($estagio)) {
			//Gerar notificação
			
            redirect(base_url() . '/estajui/login/login.php');
        } else {
            $_SESSION['erros_cadastro'] = true;
            redirect(base_url() . '/estajui/login/cadastro.php');
        }
    } else {
        $_SESSION['erro_bd'] = true;
        redirect(base_url() . '/estajui/login/cadastro.php');
    }
	} else {
    	redirect(base_url() . '/estajui/login/cadastro.php');
}
