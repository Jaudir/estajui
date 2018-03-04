<?php
require_once('base-controller.php');

$session = getSession();

if(isset($_GET['code']) && isset($_GET['email'])){
 $model = $loader->loadModel('EmailModel', 'EmailModel');
 if ($model != null) {
    if($model->verificarValidadeCodigo($_GET['code'],0)){
       if($model->validarCodigoConfirmacao($_GET['code'],$_GET['email'])){
           $session->pushValue('Conta ativada com sucesso!',"confirmacao");
       }
    }else {
        $session->pushValue('Codigo inválido!',"confirmacao");
    }
 }
 redirect(base_url() . '/estajui/login.php');
}