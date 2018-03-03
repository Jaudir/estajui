<?php
/**
 * Created by PhpStorm.
 * User: Luciano Oliva
 * Date: 03/03/2018
 * Time: 11:30
 */
require_once(dirname(__FILE__) . '/../base-controller.php');
$session = getSession();
if($session->isoe() || $session->isAluno() || $session->ispo() || $session->isce()) {
    if (isset($_POST['estagio_id'])) {
        $model = $loader->loadModel('EstagioModel', 'EstagioModel');
        $loader->loadDao('Estagio');
        $le = $model->recuperar($_POST['estagio_id']);
        $ajax_ans = array();
        $ajax_ans[] = array("status" => $le->getstatus()->get_descricao(),
            "apolice_numero" => $le->getapolice()->get_numero(),
            "apolice_seguradora" => $le->getapolice()->get_seguradora(),
            "supervisor" => $le->getsupervisor()->get_nome(),
            "supervisor_habilitacao" => $le->getsupervisor()->get_habilitacao(),
            "supervisor_cargo" => $le->getsupervisor()->get_cargo(),
            "po" => $le->getfuncionario()->getnome(),
            "po_formacao" => $le->getfuncionario()->getformacao(),
            "data_inicio" => date('d/m/Y', strtotime($le->getpe()->get_data_inicio())),
            "data_fim" => date('d/m/Y', strtotime($le->getpe()->get_data_fim())),
            "hora_inicio1"=> substr($le->getpe()->get_hora_inicio1(), 11),
            "hora_fim1"=>substr($le->getpe()->get_hora_fim1(), 11),
            "hora_inicio2"=> substr($le->getpe()->get_hora_inicio2(), 11),
            "hora_fim2"=> substr($le->getpe()->get_hora_fim2(), 11),
            "total_horas"=> $le->getpe()->get_total_horas(),
            "atividades" => $le->getpe()->get_atividades(),
            "empresa" => $le->getempresa()->get_nome(),
            "empresa_cnpj" => $le->getempresa()->get_cnpj(),
            "empresa_telefone" => $le->getempresa()->get_telefone(),
            "empresa_fax" => $le->getempresa()->get_fax(),
            "empresa_logradouro" => $le->getempresa()->get_endereco()->getlogradouro(),
            "empresa_numero" => $le->getempresa()->get_endereco()->getnumero(),
            "empresa_bairro" => $le->getempresa()->get_endereco()->getbairro(),
            "empresa_cidade" => $le->getempresa()->get_endereco()->getcidade(),
            "empresa_uf" => $le->getempresa()->get_endereco()->getuf(),
            "empresa_cep" => $le->getempresa()->get_endereco()->getcep(),
            "empresa_nregistro" => $le->getempresa()->get_nregistro(),
            "empresa_conselhofiscal" => $le->getempresa()->get_conselhofiscal()
            );
        echo json_encode($ajax_ans);
    }
}
