<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

if($session->isAluno()){
    if(isset($_POST["estagio_id"])){
        $loader->loadDao('PlanoDeEstagio');
        $loader->loadDao('Supervisor');
        
        $planoDeEstagio = new PLanoDeEstagio($_POST["setor_unidade"],$_POST["estagio_id"], null, $_POST["atividades"], null, null, $_POST["data_inicio"], $_POST["data_fim"], $_POST["hora_inicio1"], null, $_POST["hora_fim1"], null, $_POST["total_horas"], null, null);
        $supervisor = new Supervisor($_POST["nome"], $_POST["cargo"], $_POST["habilitação"], null);
        
    
    }
}


