<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/scripts/daos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/util/String.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/estajui/util/connect.php';



if (isset($_POST['cadastrar'])) {
    session_start();
    $_cpf=filter_var($_POST['cpf'], FILTER_SANITIZE_NUMBER_INT);
    $_nome=LimpaString::limpar($_POST['nome']);
    $_data_nasc = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['data_nasc'])));
    $_rg_num=LimpaString::limpar($_POST['rg']);
    $_rg_orgao=LimpaString::limpar($_POST['orgao_exp']);
    $_estado_civil=LimpaString::limpar($_POST['estado_civil']);
    $_sexo=LimpaString::limpar($_POST['sexo']);
    $_telefone=filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT);
    $_celular=filter_var($_POST['celular'], FILTER_SANITIZE_NUMBER_INT);
    $_nome_pai=LimpaString::limpar($_POST['nome_pai']);
    $_nome_mae=LimpaString::limpar($_POST['nome_mae']);
    $_cidade_natal=LimpaString::limpar($_POST['cidade_natal']);
    $_estado_natal=LimpaString::limpar($_POST['estado_natal']);

    $_logradouro=LimpaString::limpar($_POST['logradouro']);
    $_bairro=LimpaString::limpar($_POST['bairro']);
    $_numero=LimpaString::limpar($_POST['numero']);
    $_complemento=LimpaString::limpar($_POST['complemento']);
    $_cidade=LimpaString::limpar($_POST['cidade']);
    $_uf=LimpaString::limpar($_POST['uf']);
    $_cep=filter_var($_POST['cep'], FILTER_SANITIZE_NUMBER_INT);

    $_login = LimpaString::limpar($_POST['email']);
    $_login_confirmacao= LimpaString::limpar($_POST['email_confirmacao']);
    $_senha= $_POST['senha'];
    $_senha_confirmacao= $_POST['senha_confirmacao'];
    $_tipo = 1;//Aluno




    foreach ($_POST as $key => $value) {
        $_SESSION[$key] = $value;
    }

    $erros = 0;
    $notificao_erros = array();
    if (!filter_var($_login, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_erro1'] = true;
        unset($_SESSION['email']);
        unset($_SESSION['email_confirmacao']);
        $erros++;
    } else {
        if (strcmp($_login, $_login_confirmacao)!=0) {
            $_SESSION['email_erro2'] = "Os emails informados não são iguais.";
            unset($_SESSION['email']);
            unset($_SESSION['email_confirmacao']);
            $erros++;
        }
    }

    if (strcmp($_senha, $_senha_confirmacao)!=0) {
        $_SESSION['senha_erro1'] = "As senhas não iguais.";
        unset($_SESSION['senha']);
        unset($_SESSION['senha_confirmacao']);
        $erros++;
    } else {
        if (strlen($_senha)<8) {
            $_SESSION['senha_erro2'] = true;
            unset($_SESSION['senha']);
            unset($_SESSION['senha_confirmacao']);

            $erros++;
        }
    }

    // verifica se o email já está cadastrado

    $conexao = conexao::getConnection();



    //BANCO DE DADOS - > VAI NA MÃO MESMO!

    if ($erros == 0) {
        $conexao = conexao::getConnection();
        if ($conexao) {
            try {
                $conexao->beginTransaction();
                $pstmt = $conexao->prepare("INSERT INTO usuario (email, senha, tipo) VALUES(?,?, ?)");
                $pstmt->execute(array($_login,Usuario::generateSenha($_senha), $_tipo));

                $pstmt = $conexao->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
                $pstmt->execute(array($_logradouro, $_bairro, $_numero, $_complemento, $_cidade, $_uf, $_cep));

                $endereco_id = $conexao->lastInsertId();


                $pstmt = $conexao->prepare(" INSERT INTO aluno (nome, estado_natal, cidade_natal, data_nasc, nome_pai, nome_mae, estado_civil, sexo, rg_num, rg_orgao, cpf, telefone, celular, usuario_email, endereco_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $pstmt->execute(array($_nome,$_estado_natal,$_cidade_natal,$_data_nasc,$_nome_pai,$_nome_mae,$_estado_civil,$_sexo,$_rg_num,$_rg_orgao,$_cpf,$_telefone,$_celular,$_login,$endereco_id));
                $conexao->commit();
                // apaga as variáveis do $_POST
                foreach ($_POST as $key) {
                    unset($key);
                    unset($_SESSION[$key]);
                }
                header("Location:../login/login.html");
            } catch (PDOExecption $e) {
                $conexao->rollback();
            }
        }
    }
}
header("Location: cadastro.php");
