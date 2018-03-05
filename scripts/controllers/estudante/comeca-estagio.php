<?php

    require_once(dirname(__FILE__) . '/../base-controller.php');

    $session = getSession();

    if(!$session->isAluno())
        redirect(base_url() . '/estajui/login/login.php');
    
    $session->clearErrors();
    if(!isset($_POST['obrigatorio'], $_POST['campus'], $_POST['curso'], $_POST['horario'])){
        $session->pushError('Dados inválidos!');
        redirect(base_url() . '/estajui/estudante/home-novo-estagio.php');
    }

    $loader->loadUtil('String');
    $loader->loadDao('Curso');
    $loader->loadDao('Campus');
    $loader->loadDao('Estagio');
    #$loader->loadDao('Email');
    $cursoModel = $loader->loadModel('CursoModel','CursoModel');
    $campusModel = $loader->loadModel('CampusModel','CampusModel');
    $estagioModel = $loader->loadModel('EstagioModel','EstagioModel');
    $modificacaoModel = $loader->loadModel('StatusModel','StatusModel');

    $curso = new Curso($_POST['curso'], null);
    $campus = new Campus($_POST['campus'], null, null);

    $obrigatorio = 0;
    if (isset($_POST['obrigatorio']) && $_POST['obrigatorio'] == '1')
        $obrigatorio = 1;
    else
        $obrigatorio = 0;

    $estagio = new Estagio(null, 0, $obrigatorio, null, null, null, null, null, null, null, null, null, null, null, null, $session->getUsuario(), null, null, null, null);

    $model = $loader->loadModel('AlunoModel', 'AlunoModel');
    if ($model != null) {
        if ($estagioModel->preCadastrarEstagio($estagio, $curso, $campus)) {
            $session->pushValue('Estágio pré-cadastrado!', 'resultado');
        }else{
            $session->pushError('Falha ao cadastrar estágio!');
        }
    } else {
        $session->pushError('Falha ao comunicar com o servidor!');
    }

    //redirect(base_url() . '/estajui/estudante/home-novo-estagio.php');