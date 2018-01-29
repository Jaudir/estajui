<?php
require_once('base-controller.php');

session_start();

if(isset($_GET['code'])){
 $model = loadModel('email-model', 'EmailModel');
 if ($model != null) {
    if($model->validarCodigoConfirmacao($_GET['code'])){
        $_SESSION['validacao_sucesso'] = true;// MENSAGEM = Conta ativada com sucesso!
    }else {
        echo "invalido";
        $_SESSION['validacao_sucesso'] = false;// MENSAGEM = link de ativação invalido
    }
 }
 //redirect(base_url() . '/estajui/login/login.php');
}

