<?php

require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();
$session->clearErrors();
$session->clearValues();

if(isset($_POST['cnpj-busca'])){
    $empresaModel = $loader->loadModel('EmpresaModel', 'EmpresaModel');

    $empresa = $empresaModel->buscar($_POST['cnpj-busca']);

    $session->pushValue('busca', 'busca');
    if($empresa){
        $session->pushValue($empresa->get_nome(), 'nome_fantasia');
        $session->pushValue($empresa->get_cnpj(), 'cnpj');
        $session->pushValue($empresa->get_telefone(), 'telefone');
        $session->pushValue($empresa->get_fax(), 'fax');
        $session->pushValue($empresa->get_razaosocial(), 'razao_social');
        $session->pushValue($empresa->get_endereco()->getlogradouro(), 'logradouro');
        $session->pushValue($empresa->get_endereco()->getnumero(), 'numero');
        $session->pushValue($empresa->get_endereco()->getbairro(), 'bairro');
        $session->pushValue($empresa->get_endereco()->getsala(), 'sala');
        $session->pushValue($empresa->get_endereco()->getcep(), 'cep');
        $session->pushValue($empresa->get_endereco()->getcidade(), 'cidade');
        $session->pushValue($empresa->get_endereco()->getuf(), 'estado');
        $session->pushValue($empresa->get_nregistro(), 'nregistro');
        $session->pushValue($empresa->get_conselhofiscal(), 'conselhofiscal');
        $session->pushValue($empresa->get_responsavel()->get_nome(), 'nome_responsavel');
        $session->pushValue($empresa->get_responsavel()->get_telefone(), 'telefone_responsavel');
        $session->pushValue($empresa->get_responsavel()->get_email(), 'email_responsavel');
        $session->pushValue($empresa->get_responsavel()->get_cargo(), 'cargo_responsavel');
    }else{
        $session->pushError('Nenhuma empresa encontrada');
    }
}else{
    $session->pushError('Dados de busca inválidos!');
}
redirect(base_url() . '/estajui/estudante/cadastrar-dados-estagio.php');