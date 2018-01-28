<?php

require_once('base-controller.php');

if (isset($_POST['cadastrar'])) {
    //carregar arquivo da pasta util e model para cadastrar o aluno
    loadUtil('String');
    loadModel('aluno-model', 'AlunoModel');
    loadDao('Aluno');

    session_start();





    $endereco = new Endereco(null,LimpaString::limpar($_POST['logradouro']), LimpaString::limpar($_POST['bairro']), LimpaString::limpar($_POST['numero']),
    LimpaString::limpar($_POST['complemento']), LimpaString::limpar($_POST['cidade']), LimpaString::limpar($_POST['uf']),
    filter_var($_POST['cep'], FILTER_SANITIZE_NUMBER_INT));

    $aluno = new Aluno(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null,$endereco);

    $aluno->setcpf(filter_var($_POST['cpf'], FILTER_SANITIZE_NUMBER_INT));
    $aluno->setnome(LimpaString::limpar($_POST['nome']));
    $aluno->setdata_nasc(date('Y-m-d', strtotime(str_replace('-', '/', $_POST['data_nasc']))));
    $aluno->setrg_num(LimpaString::limpar($_POST['rg']));
    $aluno->setrg_orgao(LimpaString::limpar($_POST['orgao_exp']));
    $aluno->setestado_civil((LimpaString::limpar($_POST['estado_civil'])));
    $aluno->setsexo(LimpaString::limpar($_POST['sexo']));
    $aluno->settelefone(filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT));
    $aluno->setcelular(filter_var($_POST['celular'], FILTER_SANITIZE_NUMBER_INT));
    $aluno->setnome_pai(LimpaString::limpar($_POST['nome_pai']));
    $aluno->setnome_mae(LimpaString::limpar($_POST['nome_mae']));
    $aluno->setcidade_natal(LimpaString::limpar($_POST['cidade_natal']));
    $aluno->setestado_natal(LimpaString::limpar($_POST['estado_natal']));


    $aluno->setlogin(LimpaString::limpar($_POST['email']));
    $aluno->setlogin_confirmacao(LimpaString::limpar($_POST['email_confirmacao']));
    $aluno->setsenha($_POST['senha']);
    $aluno->setsenha_confirmacao($_POST['senha_confirmacao']);
    $aluno->settipo(1);

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



    $model = loadModel('aluno-model', 'AlunoModel');
    if ($model != null  && $erros == 0) {
        if ($model->cadastrar($aluno)) {
            $_SESSION['sucesso_aluno'] = true;
            redirect(base_url() . '/estajui/login/login.php');
        } else {
            redirect(base_url() . '/estajui/login/cadastro.php');
        }
    } else {
        redirect(base_url() . '/estajui/login/cadastro.php');
    }
} else {
    redirect(base_url() . '/estajui/login/cadastro.php');
}
