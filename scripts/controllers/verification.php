<?php
require_once('base-controller.php');

$session = getSession();

if(isset($_GET['code']) && isset($_GET['email'])){
 $model = $loader->loadModel('EmailModel', 'EmailModel');
 if ($model != null) {
   
       if($model->validarCodigoConfirmacao($_GET['code'],$_GET['email'])){
           $session->pushValue('Conta ativada com sucesso!',"sucesso");
       }
    }else {
        $session->pushError('Codigo inválido!',"error-validacao");
    }
}
 redirect(base_url() . '/estajui/login.php');
