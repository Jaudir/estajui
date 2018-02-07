<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

if (isset($_POST['cadastrar'])) {
    //carregar arquivo da pasta util e model para cadastrar o aluno
    $loader->loadUtil('String');
    $loader->loadDao('Aluno');
    $loader->loadDao('Email');

    $session = getSession();

	//Recuperar Aluno
    $aluno = $_SESSION['usuario'];
	$model = $loader->loadModel('aluno-model', 'AlunoModel');
	$aluno = $model->recuperar($aluno);
	
	if (isset($_POST['nome']))
    	$aluno->setnome(LimpaString::limpar($_POST['nome']));
	if (isset($_POST['orgao_exp']))
    	$aluno->setrg_orgao(LimpaString::limpar($_POST['orgao_exp']));
	if (isset($_POST['estado_civil']))
		$aluno->setestado_civil((LimpaString::limpar($_POST['estado_civil'])));
	if (isset($_POST['sexo']))
		$aluno->setsexo(LimpaString::limpar($_POST['sexo']));
	if (isset($_POST['telefone']))
		$aluno->settelefone(filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT));
	if (isset($_POST['celular']))
		$aluno->setcelular(filter_var($_POST['celular'], FILTER_SANITIZE_NUMBER_INT));
	if (isset($_POST['nome_pai']))
		$aluno->setnome_pai(LimpaString::limpar($_POST['nome_pai']));
	if (isset($_POST['nome_mae']))
		$aluno->setnome_mae(LimpaString::limpar($_POST['nome_mae']));
	if (isset($_POST['cidade_natal']))
		$aluno->setcidade_natal(LimpaString::limpar($_POST['cidade_natal']));
	if (isset($_POST['estado_natal']))
		$aluno->setestado_natal(LimpaString::limpar($_POST['estado_natal']));
	if (isset($_POST['senha']))
		$aluno->setsenha($_POST['senha']);
	if (isset($_POST['senha_confirmacao']))
		$aluno->setsenha_confirmacao($_POST['senha_confirmacao']);
	
	$endereco = $aluno->getendereco();
	if (isset($_POST['logradouro']))
		$endereco->setlogradouro(LimpaString::limpar($_POST['logradouro']));
	if (isset($_POST['bairro']))
		$endereco->setbairro(LimpaString::limpar($_POST['bairro']));
	if (isset($_POST['numero']))
		$endereco->setnumero(LimpaString::limpar($_POST['numero']));
	if (isset($_POST['complemento']))
		$endereco->setcomplemento(LimpaString::limpar($_POST['complemento']));
	if (isset($_POST['cidade']))
		$endereco->setcidade(LimpaString::limpar($_POST['cidade']));
	if (isset($_POST['uf']))
		$endereco->setuf(LimpaString::limpar($_POST['uf']));
	if (isset($_POST['cep']))
		$endereco->setcep(filter_var($_POST['cep'], FILTER_SANITIZE_NUMBER_INT));
	
	$aluno->setendereco($endereco);
	
    $erros = 0;

    if (strcmp($aluno->getsenha(), $aluno->getsenha_confirmacao())!=0) {
        $_SESSION['senha_erro1'] = "As senhas não são iguais.";
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

    if($model->VerificaLoginCadastrado($aluno->getlogin())){
        $_SESSION['email_cadastrado'] = true;
        $erros++;
    }


    if ($model != null  && $erros == 0) {
        if ($model->atualizar($aluno)) {
            $email = Email::sendEmailAluno($aluno->getlogin());
            $modelEmail = loadModel('email-model', 'EmailModel');
            $modelEmail->emitirCodigoConfirmacao($aluno, $email);
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
