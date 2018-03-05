<?php
/* Carrega os dados da home do coordenador de extensão */
require_once(dirname(__FILE__) . '/../base-controller.php');

$session = getSession();
//CE
/*$session->setUsuario(
    new Funcionario("func@func", "12345", 1, 2, "Prof", false, false, true, false, null, null, null, null)
);*/

$listaDeEstagios = array();
$statusEmpresas = array();

if($session->isce()){
    //$session->clearErrors();
    $ce = $session->getUsuario('usuario');
    $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
    $ce = $model->read($ce->getsiape(),1)[0];

    if($model != null){
        /* Carregar dados de estágios e empresas e o que mais for preciso para a home do CE*/
        $palavras_chave = array("curso"=>"","status"=>"", "empresa"=>"", "responsavel"=>"", "aluno"=>"", "po"=>"", "data_ini"=>"", "data_fim"=>"");

        $palavras_chave['curso'] = "%" . $palavras_chave['curso'] . "%";
        $palavras_chave['status'] = "%" . $palavras_chave['status'] . "%";
        $palavras_chave['empresa'] = "%" . $palavras_chave['empresa'] . "%";
        $palavras_chave['responsavel'] = "%" . $palavras_chave['responsavel'] . "%";
        $palavras_chave['aluno'] = "%" . $palavras_chave['aluno'] . "%";
        $palavras_chave['po'] = "%" . $palavras_chave['po'] . "%";

        $listaDeEstagios = $model->listarEstagios_ce($palavras_chave);
        // var_dump($listaDeEstagios);
        if (is_array($listaDeEstagios)){
            foreach($listaDeEstagios as $le){
                $le->getpe()->setdata_inicio(date('d/m/Y', strtotime($le->getpe()->getdata_inicio())));
                $le->getpe()->setdata_fim(date('d/m/Y', strtotime($le->getpe()->getdata_fim())));
                $retorno_ajax[] = array("id"=>$le->getid(),"aluno"=>$le->getaluno()->getnome(), "status"=>$le->getstatus()->getdescricao(), "curso"=>$le->getmatricula()->getoferta()->getcurso()->getnome(), "data_ini"=>$le->getpe()->getdata_inicio(), "data_fim"=>$le->getpe()->getdata_fim(), "po"=>$le->getfuncionario()->getnome(), "empresa"=>$le->getempresa()->getnome());

            }
        }
        $statusEmpresas = $model->listaEmpresas();

        if(!$listaDeEstagios)
            $listaDeEstagios = array();
        
        if(!$statusEmpresas)
            $statusEmpresas = array();
    }
}else{
    redirect(base_url() . '/estajui/login.php');
}