<?php
require_once(dirname(__FILE__) . '/../base-controller.php');
$session = getSession();
//Estudante Aluno
$session->setUsuario(
    new Aluno("aluno@aluno", "12345", 1, 3, "Nome de um aluno 3", null, null, null, null, null, null, null, null, null, null, null, null, null)
	);
//OE
/*$session->setUsuario(
	new Funcionario("func@func", "12345", 1, 1, "Professor1", false, true, false, false, null, null, null, null)
);*/
//PO
/*$session->setUsuario(
	new Funcionario("func@func", "12345", 1, 1, "Professor1", true, false, false, false, null, null, null, null)
);*/
//CE
/*$session->setUsuario(
	new Funcionario("func@func", "12345", 1, 2, "Professor2", false, false, true, false, null, null, null, null)
);*/
if($session->isoe()){
    $session->clearErrors();
    // Criar o objeto com as informações da sessão
    $oe = $session->getUsuario('usuario');
    $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
    $oe = $model->read($oe->getsiape(),1)[0];


    $palavras_chave = array("curso"=>"","status"=>"", "empresa"=>"", "responsavel"=>"", "aluno"=>"", "po"=>"", "data_ini"=>"", "data_fim"=>"");
    if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])){

        $palavras_chave['curso'] = $_POST['curso'];
        $palavras_chave['status'] = $_POST['status'];
        $palavras_chave['empresa'] = $_POST['empresa'];
        $palavras_chave['responsavel'] = $_POST['responsavel'];
        $palavras_chave['aluno'] = $_POST['aluno'];
        $palavras_chave['po'] = $_POST['po'];
        $palavras_chave['data_ini'] = $_POST['data_ini'];
        $palavras_chave['data_fim'] = $_POST['data_fim'];
    }
    $palavras_chave['curso'] = "%" . $palavras_chave['curso'] . "%";
    $palavras_chave['status'] = "%" . $palavras_chave['status'] . "%";
    $palavras_chave['empresa'] = "%" . $palavras_chave['empresa'] . "%";
    $palavras_chave['responsavel'] = "%" . $palavras_chave['responsavel'] . "%";
    $palavras_chave['aluno'] = "%" . $palavras_chave['aluno'] . "%";
    $palavras_chave['po'] = "%" . $palavras_chave['po'] . "%";

    $palavras_chave['data_ini'] = strtr($palavras_chave['data_ini'], '/', '-');
    $palavras_chave['data_fim'] = strtr($palavras_chave['data_fim'], '/', '-');
    $palavras_chave['data_ini'] = date('Y-m-d', strtotime($palavras_chave['data_ini']));
    $palavras_chave['data_fim'] = date('Y-m-d', strtotime($palavras_chave['data_fim']));
    $listaEstagios = $model->listarEstagios($palavras_chave, $oe->getsiape(), "oe.siape");
    if (is_array($listaEstagios)){
        $retorno_ajax = array();
        foreach($listaEstagios as $le){
            $le->getpe()->setdata_inicio(date('d/m/Y', strtotime($le->getpe()->getdata_inicio())));
            $le->getpe()->setdata_fim(date('d/m/Y', strtotime($le->getpe()->getdata_fim())));
            $retorno_ajax[] = array("id"=>$le->getid(),"aluno"=>$le->getaluno()->getnome(), "status"=>$le->getstatus()->getdescricao(), "curso"=>$le->getmatricula()->getoferta()->getcurso()->getnome(), "data_ini"=>$le->getpe()->getdata_inicio(), "data_fim"=>$le->getpe()->getdata_fim(), "po"=>$le->getfuncionario()->getnome(), "empresa"=>$le->getempresa()->getnome());

        }
        if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            echo json_encode($retorno_ajax);
            unset($_POST['status']);
            unset($_POST['curso']);
            unset($_POST['empresa']);
            unset($_POST['responsavel']);
            unset($_POST['aluno']);
            unset($_POST['po']);
            unset($_POST['data_ini']);
            unset($_POST['data_fim']);

         }
    } else {
        if (isset($_POST['aluno'])&& isset($_POST['status'])&& isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            $retorno_ajax = array();
            $retorno_ajax[] = array("id"=>"null","aluno" => "null", "status" => "null", "curso" => "null", "data_ini" => "null", "data_fim" => "null", "po" => "null", "empresa" => "null");
            echo json_encode($retorno_ajax);
        }
    }
}else if($session->ispo()){

    $session->clearErrors();
    // Criar o objeto com as informações da sessão
    $po = $session->getUsuario('usuario');
    $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
    $po = $model->read($po->getsiape(),1)[0];


    $palavras_chave = array("curso"=>"","status"=>"", "empresa"=>"", "responsavel"=>"", "aluno"=>"", "po"=>"", "data_ini"=>"", "data_fim"=>"");
    if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])){

        $palavras_chave['curso'] = $_POST['curso'];
        $palavras_chave['status'] = $_POST['status'];
        $palavras_chave['empresa'] = $_POST['empresa'];
        $palavras_chave['responsavel'] = $_POST['responsavel'];
        $palavras_chave['aluno'] = $_POST['aluno'];
        $palavras_chave['po'] = $_POST['po'];
        $palavras_chave['data_ini'] = $_POST['data_ini'];
        $palavras_chave['data_fim'] = $_POST['data_fim'];
    }
    $palavras_chave['curso'] = "%" . $palavras_chave['curso'] . "%";
    $palavras_chave['status'] = "%" . $palavras_chave['status'] . "%";
    $palavras_chave['empresa'] = "%" . $palavras_chave['empresa'] . "%";
    $palavras_chave['responsavel'] = "%" . $palavras_chave['responsavel'] . "%";
    $palavras_chave['aluno'] = "%" . $palavras_chave['aluno'] . "%";
    $palavras_chave['po'] = "%" . $palavras_chave['po'] . "%";

    $palavras_chave['data_ini'] = strtr($palavras_chave['data_ini'], '/', '-');
    $palavras_chave['data_fim'] = strtr($palavras_chave['data_fim'], '/', '-');
    $palavras_chave['data_ini'] = date('Y-m-d', strtotime($palavras_chave['data_ini']));
    $palavras_chave['data_fim'] = date('Y-m-d', strtotime($palavras_chave['data_fim']));

    $listaEstagios = $model->listarEstagios($palavras_chave, $po->getsiape(), "po.siape");
    if (is_array($listaEstagios)){
        $retorno_ajax = array();
        foreach($listaEstagios as $le){
            $le->getpe()->setdata_inicio(date('d/m/Y', strtotime($le->getpe()->getdata_inicio())));
            $le->getpe()->setdata_fim(date('d/m/Y', strtotime($le->getpe()->getdata_fim())));
            $retorno_ajax[] = array("id"=>$le->getid(),"aluno"=>$le->getaluno()->getnome(), "status"=>$le->getstatus()->getdescricao(), "curso"=>$le->getmatricula()->getoferta()->getcurso()->getnome(), "data_ini"=>$le->getpe()->getdata_inicio(), "data_fim"=>$le->getpe()->getdata_fim(), "po"=>$le->getfuncionario()->getnome(), "empresa"=>$le->getempresa()->getnome());

        }
        if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            echo json_encode($retorno_ajax);
            unset($_POST['status']);
            unset($_POST['curso']);
            unset($_POST['empresa']);
            unset($_POST['responsavel']);
            unset($_POST['aluno']);
            unset($_POST['po']);
            unset($_POST['data_ini']);
            unset($_POST['data_fim']);

        }
    } else {
        if (isset($_POST['aluno'])&& isset($_POST['status'])&& isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            $retorno_ajax = array();
            $retorno_ajax[] = array("id"=>"null","aluno" => "null", "status" => "null", "curso" => "null", "data_ini" => "null", "data_fim" => "null", "po" => "null", "empresa" => "null");
            echo json_encode($retorno_ajax);
        }
    }
}else if($session->isce()){
    $session->clearErrors();
    // Criar o objeto com as informações da sessão
    $ce = $session->getUsuario('usuario');
    $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
    $ce = $model->read($ce->getsiape(),1)[0];
    $palavras_chave = array("curso"=>"","status"=>"", "empresa"=>"", "responsavel"=>"", "aluno"=>"", "po"=>"", "data_ini"=>"", "data_fim"=>"");
    if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])){
        $palavras_chave['curso'] = $_POST['curso'];
        $palavras_chave['status'] = $_POST['status'];
        $palavras_chave['empresa'] = $_POST['empresa'];
        $palavras_chave['responsavel'] = $_POST['responsavel'];
        $palavras_chave['aluno'] = $_POST['aluno'];
        $palavras_chave['po'] = $_POST['po'];
        $palavras_chave['data_ini'] = $_POST['data_ini'];
        $palavras_chave['data_fim'] = $_POST['data_fim'];
    }
    $palavras_chave['curso'] = "%" . $palavras_chave['curso'] . "%";
    $palavras_chave['status'] = "%" . $palavras_chave['status'] . "%";
    $palavras_chave['empresa'] = "%" . $palavras_chave['empresa'] . "%";
    $palavras_chave['responsavel'] = "%" . $palavras_chave['responsavel'] . "%";
    $palavras_chave['aluno'] = "%" . $palavras_chave['aluno'] . "%";
    $palavras_chave['po'] = "%" . $palavras_chave['po'] . "%";

    $palavras_chave['data_ini'] = strtr($palavras_chave['data_ini'], '/', '-');
    $palavras_chave['data_fim'] = strtr($palavras_chave['data_fim'], '/', '-');
    $palavras_chave['data_ini'] = date('Y-m-d', strtotime($palavras_chave['data_ini']));
    $palavras_chave['data_fim'] = date('Y-m-d', strtotime($palavras_chave['data_fim']));


    $listaEstagios = $model->listarEstagios_ce($palavras_chave);

    if (is_array($listaEstagios)){
        $retorno_ajax = array();
        foreach($listaEstagios as $le){
            $le->getpe()->setdata_inicio(date('d/m/Y', strtotime($le->getpe()->getdata_inicio())));
            $le->getpe()->setdata_fim(date('d/m/Y', strtotime($le->getpe()->getdata_fim())));
            $retorno_ajax[] = array("id"=>$le->getid(),"aluno"=>$le->getaluno()->getnome(), "status"=>$le->getstatus()->getdescricao(), "curso"=>$le->getmatricula()->getoferta()->getcurso()->getnome(), "data_ini"=>$le->getpe()->getdata_inicio(), "data_fim"=>$le->getpe()->getdata_fim(), "po"=>$le->getfuncionario()->getnome(), "empresa"=>$le->getempresa()->getnome());

        }
        if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            echo json_encode($retorno_ajax);
            unset($_POST['status']);
            unset($_POST['curso']);
            unset($_POST['empresa']);
            unset($_POST['responsavel']);
            unset($_POST['aluno']);
            unset($_POST['po']);
            unset($_POST['data_ini']);
            unset($_POST['data_fim']);

        }
    } else {
        if (isset($_POST['aluno'])&& isset($_POST['status'])&& isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            $retorno_ajax = array();
            $retorno_ajax[] = array("id"=>"null","aluno" => "null", "status" => "null", "curso" => "null", "data_ini" => "null", "data_fim" => "null", "po" => "null", "empresa" => "null");
            echo json_encode($retorno_ajax);
        }
    }
}else if($session->isAluno()){
    $session->clearErrors();
    // Criar o objeto com as informações da sessão
    $aluno = $session->getUsuario('usuario');
    $model = $loader->loadModel('AlunoModel', 'AlunoModel');
    $aluno = $model->read($aluno->getcpf(),1)[0];


    $palavras_chave = array("curso"=>"","status"=>"", "empresa"=>"", "responsavel"=>"", "aluno"=>"", "po"=>"", "data_ini"=>"", "data_fim"=>"");
    if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])){
        $palavras_chave['curso'] = $_POST['curso'];
        $palavras_chave['status'] = $_POST['status'];
        $palavras_chave['empresa'] = $_POST['empresa'];
        $palavras_chave['responsavel'] = $_POST['responsavel'];
        $palavras_chave['aluno'] = $_POST['aluno'];
        $palavras_chave['po'] = $_POST['po'];
        $palavras_chave['data_ini'] = $_POST['data_ini'];
        $palavras_chave['data_fim'] = $_POST['data_fim'];
    }
    $palavras_chave['curso'] = "%" . $palavras_chave['curso'] . "%";
    $palavras_chave['status'] = "%" . $palavras_chave['status'] . "%";
    $palavras_chave['empresa'] = "%" . $palavras_chave['empresa'] . "%";
    $palavras_chave['responsavel'] = "%" . $palavras_chave['responsavel'] . "%";
    $palavras_chave['aluno'] = "%" . $palavras_chave['aluno'] . "%";
    $palavras_chave['po'] = "%" . $palavras_chave['po'] . "%";

    $palavras_chave['data_ini'] = strtr($palavras_chave['data_ini'], '/', '-');
    $palavras_chave['data_fim'] = strtr($palavras_chave['data_fim'], '/', '-');
    $palavras_chave['data_ini'] = date('Y-m-d', strtotime($palavras_chave['data_ini']));
    $palavras_chave['data_fim'] = date('Y-m-d', strtotime($palavras_chave['data_fim']));
    $listaEstagios = $model->listarEstagios($palavras_chave, $aluno->getcpf(), "aluno.cpf");
    if (is_array($listaEstagios)){
        $retorno_ajax = array();
        foreach($listaEstagios as $le){
            $le->getpe()->setdata_inicio(date('d/m/Y', strtotime($le->getpe()->getdata_inicio())));
            $le->getpe()->setdata_fim(date('d/m/Y', strtotime($le->getpe()->getdata_fim())));
            $retorno_ajax[] = array("id"=>$le->getid(),"aluno"=>$le->getaluno()->getnome(), "status"=>$le->getstatus()->getdescricao(), "curso"=>$le->getmatricula()->getoferta()->getcurso()->getnome(), "data_ini"=>$le->getpe()->getdata_inicio(), "data_fim"=>$le->getpe()->getdata_fim(), "po"=>$le->getfuncionario()->getnome(), "empresa"=>$le->getempresa()->getnome());

        }
        if (isset($_POST['aluno']) && isset($_POST['status']) && isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            echo json_encode($retorno_ajax);
            unset($_POST['status']);
            unset($_POST['curso']);
            unset($_POST['empresa']);
            unset($_POST['responsavel']);
            unset($_POST['aluno']);
            unset($_POST['po']);
            unset($_POST['data_ini']);
            unset($_POST['data_fim']);

        }
    } else {
        if (isset($_POST['aluno'])&& isset($_POST['status'])&& isset($_POST['curso']) && isset($_POST['po']) && isset($_POST['responsavel']) && isset($_POST['empresa']) && isset($_POST['data_ini']) && isset($_POST['data_fim'])) {
            $retorno_ajax = array();
            $retorno_ajax[] = array("id"=>"null","aluno" => "null", "status" => "null", "curso" => "null", "data_ini" => "null", "data_fim" => "null", "po" => "null", "empresa" => "null");
            echo json_encode($retorno_ajax);
        }
    }
}else{
    $session->pushError("Tipo de usuário incorreto!");

    redirect(base_url() . '/estajui/login/cadastro.php');
}