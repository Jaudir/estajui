<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (isset($_GET["logoff"])) {
    $session->destroy();
    redirectToView("login");
}
if (!$session->isLogged()) {
    redirectToView("login");
}
$estagios = array();
$usuario = $session->getUsuario();
$estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
$notificacoesModel = $loader->loadModel("NotificacaoModel", "NotificacaoModel");
$notificacoes = $notificacoesModel->getNotificacoes($usuario);
if (is_a($usuario, "Aluno")) {
    $titulo = "Estudante";
    $estagios = $estagioModel->readbyaluno($usuario, 0);
    $cursoModel = $loader->loadModel('CursoModel', 'CursoModel');
    $campusModel = $loader->loadModel('CampusModel', 'CampusModel');

    $campi = $campusModel->recuperarTodos();

    $cursos = array();
    foreach ($campi as $campus) {
        $var = $cursoModel->recuperarPorCampus($campus);
        $cursos[$campus->getcnpj()] = $var;
    }
} elseif (is_a($usuario, "Funcionario")) {
    if ($usuario->isroot()) {
        $titulo = "Administrador";
    }
    if ($usuario->isce()) {
        //$session->clearErrors();
        $ce = $session->getUsuario('usuario');
        $model = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
        $estagiomodel = $loader->loadModel('EstagioModel', 'EstagioModel');
        $ce = $model->read($ce->getsiape(), 1)[0];

        if ($model != null) {
            /* Carregar dados de estágios e empresas e o que mais for preciso para a home do CE */
            $palavras_chave = array("curso" => "", "status" => "4", "empresa" => "", "responsavel" => "", "aluno" => "", "po" => "", "data_ini" => "", "data_fim" => "");

            $palavras_chave['curso'] = "%" . $palavras_chave['curso'] . "%";
            $palavras_chave['status'] = "%" . $palavras_chave['status'] . "%";
            $palavras_chave['empresa'] = "%" . $palavras_chave['empresa'] . "%";
            $palavras_chave['responsavel'] = "%" . $palavras_chave['responsavel'] . "%";
            $palavras_chave['aluno'] = "%" . $palavras_chave['aluno'] . "%";
            $palavras_chave['po'] = "%" . $palavras_chave['po'] . "%";

            $listaDeEstagios = $estagiomodel->read(null, 0);
            if (is_array($listaDeEstagios)) {
                foreach ($listaDeEstagios as $le) {
                    if ($le->getpe()) {
                        $retorno_ajax[] = array("id" => $le->getid(), "aluno" => $le->getaluno()->getnome(), "status" => $le->getstatus()->getdescricao(), "curso" => $le->getmatricula()->getoferta()->getcurso()->getnome(), "data_ini" => $le->getpe()->getdata_inicio(), "data_fim" => $le->getpe()->getdata_fim(), "po" => $le->getfuncionario()->getnome(), "empresa" => $le->getempresa()->getnome());
                    }
                }
            }
            $statusEmpresas = $model->listaEmpresas();

            if (!$listaDeEstagios)
                $listaDeEstagios = array();

            if (!$statusEmpresas)
                $statusEmpresas = array();
        }
    }
    if ($usuario->isoe()) {
        /* Carregar dados dos estágios agurdando professor orientador */
        $peModel = $loader->loadModel('PlanoEstagioModel', 'PlanoEstagioModel');
//carregar estágios que estão aguardando definição de professor orientador
        $estagios = $peModel->carregarAguardandoOrientador();
        if ($estagios == false) {
            $estagios = array();
        }
        /* Carregar professores orientadores */
        $funcModel = $loader->loadModel('FuncionarioModel', 'FuncionarioModel');
        $professores = $funcModel->carregarOrientadores();
        if ($professores == false) {
            $professores = array();
        }
        $titulo = "Organizador de estagio";
    }
    if ($usuario->issra()) {
        $titulo = "Secretaria";
        $estagios = $estagioModel->read(null, 0);
    }
    if ($usuario->ispo()) {
        $titulo = "Professor orientador";
    }
} else {
    redirectToView("login");
}
$nome = $usuario->getnome();
