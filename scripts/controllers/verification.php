<?php
require_once('base-controller.php');



session_start();

<<<<<<< HEAD:scripts/controllers/email_ativacao.php
if(isset($_GET['code'])){
 $model = loadModel('EmailModel', 'EmailModel');
=======
if(isset($_GET['code']) && isset($_GET['email'])){
 $model = loadModel('email-model', 'EmailModel');
>>>>>>> master:scripts/controllers/verification.php
 if ($model != null) {
    if($model->validarCodigoConfirmacao($_GET['code'],$_GET['email'])){
        $_SESSION['validacao_sucesso'] = true;// MENSAGEM = Conta ativada com sucesso!
    }else {
        echo "invalido";
        $_SESSION['validacao_sucesso'] = false;// MENSAGEM = link de ativação invalido
    }
 }
 redirect(base_url() . '/estajui/login/login.php');
}