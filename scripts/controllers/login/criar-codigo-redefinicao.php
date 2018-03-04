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

    $usuario = $umodel->read($_POST['email'], 1);

    if($usuario){
        $usuario = $usuario[0];

        //carregar o aluno(tipo = 1) ou funcionário(tipo = 2) por que a tabela usuário não tem o nome do usuario :////
        /*if($usuario->getTipo() == 1){
            $usuario = $amodel->readbyusuario($usuario);
        }else{
            $usuario = $fmodel->readbyusuario($usuario);
        }*/

        $email = Email::criarEmailRecuperarSenha($configs['email_estajui'], $configs['responsavel_estajui'], $usuario->getlogin(), 'nome teste');

        //se já existe um código de verificaçao para este email, apenas altera e reenvia o email caso exista
        $verifica = $emodel->buscarCodigo($email, EmailModel::$CODIGO_RECUPERACAO);
        
        $result = null;
        if($verifica){
            $result = $emodel->atualizarCodigoVerificacao($usuario, $email);//atualiza
        }else{
            $result = $emodel->salvarCodigoVerificacao($usuario, $email);//insere um novo
        }

        if($result){
            if($email->enviarEmail()){
                echo "Email de redefinição enviado!";
            }else{
                echo "Não foi possível enviar o email!";
            }
        }else{
            echo "Falha ao contatar servidor!";
        }
    }else{
        echo "Este email não está cadastrado no sistema!";
    }
}else{
    echo "Dados inválidos!";
}