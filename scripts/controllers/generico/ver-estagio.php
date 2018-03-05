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
        $ajax_ans[] = array("aluno"=>$le->getaluno()->getnome(),
            "curso"=>$le->getmatricula()->getoferta()->getcurso()->getnome(),
            "matricula"=>$le->getmatricula()->getmatricula(),
            "bool_obrigatorio"=>$le->getobrigatorio(),
            "status" => $le->getstatus()->getdescricao(),
            "apolice_numero" => $le->getapolice()->getnumero(),
            "apolice_seguradora" => $le->getapolice()->getseguradora(),
            "supervisor" => $le->getsupervisor()->getnome(),
            "supervisor_habilitacao" => $le->getsupervisor()->gethabilitacao(),
            "supervisor_cargo" => $le->getsupervisor()->getcargo(),
            "po" => $le->getfuncionario()->getnome(),
            "po_formacao" => $le->getfuncionario()->getformacao(),
            "data_inicio" => date('d/m/Y', strtotime($le->getpe()->getdata_inicio())),
            "data_fim" => date('d/m/Y', strtotime($le->getpe()->getdata_fim())),
            "hora_inicio1"=> substr($le->getpe()->gethora_inicio1(), 11),
            "hora_fim1"=>substr($le->getpe()->gethora_fim1(), 11),
            "hora_inicio2"=> substr($le->getpe()->gethora_inicio2(), 11),
            "hora_fim2"=> substr($le->getpe()->gethora_fim2(), 11),
            "total_horas"=> $le->getpe()->gettotal_horas(),
            "atividades" => $le->getpe()->getatividades(),
            "empresa" => $le->getempresa()->getnome(),
            "empresa_cnpj" => $le->getempresa()->getcnpj(),
            "empresa_telefone" => $le->getempresa()->gettelefone(),
            "empresa_fax" => $le->getempresa()->getfax(),
            "empresa_logradouro" => $le->getempresa()->getendereco()->getlogradouro(),
            "empresa_numero" => $le->getempresa()->getendereco()->getnumero(),
            "empresa_bairro" => $le->getempresa()->getendereco()->getbairro(),
            "empresa_cidade" => $le->getempresa()->getendereco()->getcidade(),
            "empresa_uf" => $le->getempresa()->getendereco()->getuf(),
            "empresa_cep" => $le->getempresa()->getendereco()->getcep(),
            "empresa_nregistro" => $le->getempresa()->getnregistro(),
            "empresa_conselhofiscal" => $le->getempresa()->getconselhofiscal()
            );
        echo json_encode($ajax_ans);
    }
}
