<?php

require_once('base-constroller.php');

if(!isset($_POST['veredito']) || !isset($_POST['just'])){
    header('');
}else{
    /*verificar a sessão de CE*/

    $verdict = $_POST['veredito'];
    $justf = $_POST['just'];

    $model = loadModel('empresa');
    if($model != null){
        if($model->alterarConvenio($verdict, $justf)){
            redirect(base_url());
        }
    }
}


?>