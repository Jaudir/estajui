<?php
require_once(dirname(__FILE__) . '/../base-controller.php');


if(isset($_POST['search'])){
    $cnpj = $_POST['search'];
    $model = $loader->loadModel('EmpresaModel', 'EmpresaModel');
    $resultado = $model->RecuperaDadosEmpresa($cnpj); 
    $saida = array();
    
    if($resultado == null)
        $saida['erro'] = 'Empresa nao cadastrada.';
    else
        {
        
        $saida['cnpj'] = $resultado[0]->get_cnpj();
        $saida['nome_fantasia'] = $resultado[0]->get_nome();
        $saida['telefone'] = $resultado[0]->get_telefone();

        $saida['fax'] = $resultado[0]->get_fax();

        $saida['numero_registro'] = $resultado[0]->get_nregistro();

        $saida['conselho_fiscal'] = $resultado[0]->get_conselhofiscal();

        $saida['razao_social'] = $resultado[0]->get_razao_social();
        
        $saida['numero'] = $resultado[2]->getnumero();
        $saida['logradouro'] = $resultado[2]->getlogradouro();
        $saida['bairro'] = $resultado[2]->getbairro();
        $saida['sala'] = $resultado[2]->getsala();
        $saida['cep'] = $resultado[2]->getcep();
        $saida['cidade'] = $resultado[2]->getcidade();
        $saida['uf'] = $resultado[2]->getuf();
        $saida['nome_responsavel'] = $resultado[1]->get_nome();
        $saida['telefone_responsavel'] = $resultado[1]->get_telefone();
        $saida['email'] = $resultado[1]->get_email();
        $saida['cargo_ocupado'] = $resultado[1]->get_cargo();
        unset($resultado);        
    }
    $saida = json_encode($saida);
    echo $saida;
}









