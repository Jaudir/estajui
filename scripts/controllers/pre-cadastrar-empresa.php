<?php

require_once('base-constroller.php');
require_once('../models/empresa.php');

if(!isset($_POST['veredito']) || !isset($_POST['just'])){
    header('');
}else{
    $verdict = $_POST['veredito'];
    $justf = $_POST['just'];

    $model = new EmpresaModel();
    if($model->init($db)){
        if($model->alterarConvenio($verdict, $justf)){
            header();
        }
    }
}


?>