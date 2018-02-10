<?php

/*
    Este script é acessado via ajax
    Sua resposta deve ser printada na página(echo)
*/

require_once(dirname(__FILE__) . '/../base-controller.php');

if(isset($_POST['email'])){
    $loader->loadDAO('Email');
    $umodel = $loader->loadModel('UsuarioModel', 'UsuarioModel');
    $fmodel = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
    $amodel = $loader->loadModel('AlunoModel', 'AlunoModel');
    $emodel = $loader->loadModel('EmailModel', 'EmailModel');

    $usuario = $umodel->read($_POST['email']);

    //carregar o aluno(tipo = 1) ou funcionário(tipo = 2) por que a tabela usuário não tem o nome do usuario :////
    if($usuario->getTipo() == 1){
        $usuario = $amodel->readbyusuario($usuario);
    }else{
        $usuario = $fmodel->readbyusuario($usuario);
    }

    $email = Email::criarEmailRecuperarSenha($configs['email_estajui'], $configs['responsavel_estajui'], $usuario->getlogin(), $usuario->getnome());
    if($emodel->emitirCodigoConfirmacao($usuario, $email)){
        if($email->enviarEmail()){
            echo "Email de redefinição enviado!";
        }else{
            echo "Não foi possível enviar o email!";
        }
    }else{
        echo "Falha ao contatar servidor!";
    }
}else{
    echo "Dados inválidos!";
}