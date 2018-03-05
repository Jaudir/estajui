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

if($session->isAluno()){

    $session->clearErrors();
    $session->clearValues();
    $session->valuesFromPOST();

    //validação de dados vem aqui
    $loader->loadUtil('Validation');

    $validate = new Validation($_POST);

    //adiciona campos para serem validados

    //campos do endereço
    $validate->addField('logradouro', array('required' => true, 'min_size' => 4, 'max_size' => 50));
    $validate->addField('bairro', array('required' => true, 'min_size' => 4, 'max_size' => 30));
    $validate->addField('numero', array('required' => true, 'min_size' => 1, 'max_size' => 11, 'integer' => true));
    $validate->addField('cidade', array('required' => true, 'min_size' => 3, 'max_size' => 30));
    $validate->addField('estado', array('required' => true, 'min_size' => 2, 'max_size' => 2));
    $validate->addField('cep', array('required' => true, 'min_size' => 9, 'max_size' => 9, 'integer'));
    $validate->addField('sala', array('required' => true, 'min_size' => 2, 'max_size' => 30));

    //campos da empresa
    $validate->addField('cnpj', array('required' => true, 'min_size' => 18, 'max_size' => 18));
    $validate->addField('nome_fantasia', array('required' => true, 'min_size' => 4, 'max_size' => 30));
    $validate->addField('telefone', array('required' => true, 'tel' => true));
    $validate->addField('fax', array('min_size' => 0, 'max_size' => 10, 'integer' => true));
    $validate->addField('nregistro', array('required' => true, 'min_size' => 8, 'max_size' => 8, 'integer' => true));
    $validate->addField('conselhofiscal', array('required' => true, 'min_size' => 4, 'max_size' => 30));
    $validate->addField('razao_social', array('required' => true, 'min_size' => 4, 'max_size' => 100));

    //campos do responsável
    $validate->addField('email_responsavel', array('required' => true, 'min_size' => 4, 'max_size' => 50, 'email' => true)); 
    $validate->addField('nome_responsavel', array('required' => true, 'min_size' => 4, 'max_size' => 50)); 
    $validate->addField('telefone_responsavel', array('required' => true, 'tel' => true));
    $validate->addField('cargo_responsavel', array('required' => true, 'min_size' => 4, 'max_size' => 20));
    
    //campos do supervisor
    $validate->addField('nome_supervisor', array('required' => true, 'min_size' => 4, 'max_size' => 200)); 
    $validate->addField('cargo', array('required' => true, 'min_size' => 4, 'max_size' => 20)); 
    $validate->addField('habilitacao', array('required' => true, 'min_size' => 4, 'max_size' => 100));

    //campos do estágio
    $validate->addField('estagio', array('required' => true, 'integer' => true), array('required' => "Estágio não definido."));

    //campos do plano de estágio
    $validate->addField('setor', array('required' => true, 'min_size' => 4, 'max_size' => 100));
    $validate->addField('atividades', array('required' => true, 'min_size' => 4, 'max_size' => 100));
    $validate->addField('data_inicio', array('required' => true, 'date' => true)); 
    $validate->addField('data_termino', array('required' => true, 'date' => true,)); 
    $validate->addField('inicio_jornada', array('required' => true, 'time' => true)); 
    $validate->addField('termino_jornada', array('required' => true, 'time' => true)); 
    $validate->addField('horas_semanais', array('required' => true, 'time' => true));

    if($validate->validate(false)){
        //carregar daos
        $loader->loadDAO('Empresa');
        $loader->loadDAO('Endereco');
        $loader->loadDAO('Responsavel');
        $loader->loadDAO('Supervisor');
        $loader->loadDAO('Estagio');
        $loader->loadDAO('PlanoDeEstagio');

        //carregar models
        $planoModel = $loader->loadModel('PlanoEstagioModel', 'PlanoEstagioModel');

        //preenchendo models
        $endereco = new Endereco(-1, $_POST['logradouro'], $_POST['bairro'], $_POST['numero'], null, $_POST['cidade'], $_POST['estado'], preg_replace("/[^0-9]/", "", $_POST['cep']), $_POST['sala']);
        $empresa = new Empresa(preg_replace("/[^0-9]/", "", $_POST['cnpj']), $_POST['nome_fantasia'], preg_replace("/[^0-9]/", "", $_POST['telefone']), isset($_POST['fax']) ? $_POST['fax'] : null, $_POST['nregistro'], $_POST['conselhofiscal'], $endereco, null, 0, $_POST['razao_social']);
        $responsavel = new Responsavel($_POST['email_responsavel'], $_POST['nome_responsavel'], preg_replace("/[^0-9]/", "", $_POST['telefone_responsavel']), $_POST['cargo_responsavel'], $empresa, null);
        $supervisor = new Supervisor(-1, $_POST['nome_supervisor'], $_POST['cargo'], $_POST['habilitacao'], $empresa);
        $estagio = new Estagio($_POST['estagio'], null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
        $planoEstagio = new PlanoDeEstagio($_POST['setor'], $estagio, null, $_POST['atividades'], null, null, $_POST['data_inicio'], $_POST['data_termino'], $_POST['inicio_jornada'], null, $_POST['termino_jornada'], null, $_POST['horas_semanais'], null, null);

        if($planoModel->create($planoEstagio, $supervisor, $responsavel, $empresa, $session->getUsuario())){
            $session->pushValue('Estágio cadastrado!', 'resultado');
        }else{
            $session->pushError('Falha de comunicação com o servidor!');
        }
    }else{
        $validate->pushErrors($session);
        $session->pushError(true, 'missing');
    }
}else{
    $session->pushError('Você não é um aluno, não é possível criar estágios!');
}
//redirect(base_url() . '/estajui/estudante/cadastrar-dados-estagio.php');