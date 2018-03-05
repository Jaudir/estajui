<?php

require_once(dirname(__FILE__) . '/base-controller.php');

$loader->loadUtil('String');
$loader->loadDao('Aluno');

$session = getSession();

if($session->isAluno()){
	if (1) {
		$session->clearErrors();

		//Recuperar Aluno
		$aluno = $session->getUsuario('usuario');

		$model = $loader->loadModel('AlunoModel', 'AlunoModel');
		$aluno = $model->read($aluno->getcpf(),1)[0];

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
			$session->pushError("As senhas não são iguais.", 'senha_erro1');
			$erros++;
		} else {
			if (strlen($aluno->getsenha())<2) {
				$session->pushError(true, 'senha_erro1');
				$erros++;
			}
		}
                
                $usarioModel = $loader->loadModel('UsuarioModel', 'UsuarioModel');
                        
		if($usarioModel->VerificaLoginCadastrado($aluno->getlogin())){
			$session->pushError(true, 'email_cadastrado');
			$erros++;
		}


		if ($model != null && $erros == 0) {
			if ($model->update($aluno)) {
			} else {
				$session->pushError(true, 'erros_cadastro');
			}
		} else {
			$session->pushError(true, 'erros_bd');
		}
	} else {
		$session->pushError("Dados inválidos!");
	}
}else{
	$session->pushError("Você não é um aluno!");
}
redirect(base_url() . '/estajui/login/cadastro.php');