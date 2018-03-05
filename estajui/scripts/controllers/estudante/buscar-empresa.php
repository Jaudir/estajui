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
        $session->pushValue($empresa->getnome(), 'nome_fantasia');
        $session->pushValue($empresa->getcnpj(), 'cnpj');
        $session->pushValue($empresa->gettelefone(), 'telefone');
        $session->pushValue($empresa->getfax(), 'fax');
        $session->pushValue($empresa->getrazaosocial(), 'razao_social');
        $session->pushValue($empresa->getendereco()->getlogradouro(), 'logradouro');
        $session->pushValue($empresa->getendereco()->getnumero(), 'numero');
        $session->pushValue($empresa->getendereco()->getbairro(), 'bairro');
        $session->pushValue($empresa->getendereco()->getsala(), 'sala');
        $session->pushValue($empresa->getendereco()->getcep(), 'cep');
        $session->pushValue($empresa->getendereco()->getcidade(), 'cidade');
        $session->pushValue($empresa->getendereco()->getuf(), 'estado');
        $session->pushValue($empresa->getnregistro(), 'nregistro');
        $session->pushValue($empresa->getconselhofiscal(), 'conselhofiscal');
        $session->pushValue($empresa->getresponsavel()->getnome(), 'nome_responsavel');
        $session->pushValue($empresa->getresponsavel()->gettelefone(), 'telefone_responsavel');
        $session->pushValue($empresa->getresponsavel()->getemail(), 'email_responsavel');
        $session->pushValue($empresa->getresponsavel()->getcargo(), 'cargo_responsavel');
    }else{
        $session->pushError('Nenhuma empresa encontrada');
    }
}else{
    $session->pushError('Dados de busca inválidos!');
}
redirect(base_url() . '/estajui/estudante/cadastrar-dados-estagio.php');