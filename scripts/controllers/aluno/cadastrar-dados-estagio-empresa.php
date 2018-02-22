<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

//$session = getSession();

//if($session->isAluno()){
    if(isset($_POST["cadastrar"]) )//&& isset($_POST["estagio_id"])){//adicionar condição de restrição e de dono

        $loader->loadDao('PlanoDeEstagio');
        $loader->loadDao('Supervisor');
        $loader->loadDao('Empresa');
        $loader->loadDao('Responsavel');
        


        $empresa = new Empresa($_POST["cnpj"], $_POST["nome_fantasia"], $_POST["telefone"],$_POST["razao_social"], $_POST["fax"], $_POST["numero_registro"], $_POST["conselho_fiscal"], null, $_POST["responsavel"]);       
        $endereco = new Endereco(null,$_POST["logradouro"],$_POST["bairro"],$_POST["numero"],null,$_POST["cidade"],$_POST["uf"],$_POST["cep"],$_POST["sala"]);
        $responsavel = new Responsavel($_POST["email"],$_POST["nome_responsavel"],$_POST["telefone_responsavel"],$_POST["cargo_ocupado"],null);
        $planoDeEstagio = new PLanoDeEstagio($_POST["setor_unidade"],
        $_POST["estagio_id"], null, $_POST["atividades"], null, null,
        $_POST["data_inicio"], $_POST["data_fim"], $_POST["hora_inicio1"], 
        null, $_POST["hora_fim1"], null, $_POST["total_horas"], null, null);
        $supervisor = new Supervisor($_POST["nome"], $_POST["cargo"], $_POST["habilitação"], null);
        $model = $loader->loadModel('EstagioModel','EstagioModel');
         if($model->InserirDadosEstagio($supervisor, $endereco, $planoDeEstagio,$empresa, isset($_POST['novaEmpresa']))){
             echo "<script> alert('Tudo certo');</script>";
         }
    }
//}

