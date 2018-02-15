<?php

/* 
    Este script irá:
        * Cadastrar uma empresa para ser conveniada caso não esteja.
            - Nesse caso, também será cadastrado o supervisor do estágio
            - Sobre o responsável: caso já exista será associado à empresa, caso contrário ele será
            cadastrado
        * Cadastrar o plano de estágio
*/

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();

$session->setUsuario(
    new Aluno(
        'email@email10.com', 
        '123', 
        1, 
        '1231231', 
        'teste', 
        null, 
        null, 
        null, 
        null, 
        null, 
        null, 
        null, 
        null, 
        null, 
        null, 
        null,
        null,
        null));

if($session->isAluno()){
    //carregar daos
    $loader->loadDAO('Empresa');
    $loader->loadDAO('Endereco');
    $loader->loadDAO('Responsavel');
    $loader->loadDAO('Supervisor');
    $loader->loadDAO('Estagio');
    $loader->loadDAO('PlanoDeEstagio');

    //carregar models
    $planoModel = $loader->loadModel('PlanoEstagioModel', 'PlanoEstagioModel');
    
    //validar dados aqui ...
    $_POST['estagio'] = 1;

    //preenchendo models
    $endereco = new Endereco(-1, $_POST['logradouro'], $_POST['bairro'], $_POST['numero'], null, $_POST['cidade'], null, $_POST['cep']);
    $empresa = new Empresa($_POST['cnpj'], $_POST['nome_fantasia'], $_POST['telefone'], $_POST['fax'], $_POST['nregistro'], $_POST['conselhofiscal'], $endereco, null, 0, $_POST['razao_social']);
    $responsavel = new Responsavel($_POST['email_responsavel'], $_POST['nome_responsavel'], $_POST['telefone_responsavel'], $_POST['cargo_responsavel'], $empresa);
    $supervisor = new Supervisor(-1, $_POST['nome_supervisor'], $_POST['cargo'], $_POST['habilitacao'], $empresa);
    $estagio = new Estagio($_POST['estagio'], null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
    $planoEstagio = new PlanoDeEstagio($estagio, null, $_POST['atividades'], null, null, $_POST['data_inicio'], $_POST['data_termino'], $_POST['inicio_jornada'], null, $_POST['termino_jornada'], null, $_POST['horas_semanais'], null, null);

    if($planoModel->create($planoEstagio, $supervisor, $responsavel, $empresa, $session->getUsuario())){
        $session->pushValue('Estágio cadastrado!', 'resultado');
    }else{
        $session->pushError('Falha ao cadastrar estágio');
    }
}else{
    $session->pushError('Você não é um aluno, não é possível criar estágios!');
}
//redirect(base_url() . '/estajui/estudante/cadastrar-dados-estagios.php');
$session->printErrors();