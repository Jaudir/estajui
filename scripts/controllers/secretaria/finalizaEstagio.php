<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (!$session->isLogged()) {
    redirect("login.php");
}

if (isset($_POST["id"])) {
    if (!empty($_POST["horas"])) {
        $estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
        $estagio = $estagioModel->read($_POST["id"], 1);
        if (is_array($estagio)) {
            if (count($estagio) > 0) {
                $estagio = $estagio[0];
                $modificacaostatusModel = $loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                $planoModel = $loader->loadModel("PlanoDeEstagioModel", "PlanoDeEstagioModel");
                $notificacaoModel = $loader->loadModel("NotificacaoModel", "NotificacaoModel");
                $statusModel = $loader->loadModel("StatusModel", "StatusModel");
                $status = $statusModel->read(12, 1);
                if ($status)
                    $estagio->setstatus($status[0]);
                else
                    $session->pushError("Erro ao definir novo status!", "error-critico");
                $modicacao = new ModificacaoStatus(NULL, date("Y-m-d H:i:s"), $estagio, $status[0], $session->getUsuario());
                $notificacao = new Notificacao(null, false, $modicacao, "Estágio concluido");
                $estagio->sethoras_contabilizadas($_POST["horas"]);
                if (!$estagioModel->update($estagio) && !$modificacaostatusModel->create($modicacao) && !$notificacaoModel->create($notificacao)) {
                    $session->pushValue("Operação realizada com sucesso!", "sucesso");
                } else {
                    $session->pushError("Erro no Banco de Dados!", "error-critico");
                }
            } else {
                $session->pushError("Erro! (Estágio não encontrado)!", "error-critico");
            }
        } else {
            $session->pushError("Erro no Banco de Dados!", "error-critico");
        }
    } else {
        if (!empty($_POST["horas"])) {
            $session->pushError("Preencha as horas contabilizadas do aluno!", "error-validacao");
        }
    }
} else {
    $session->pushError("Erro de identificação", "error-critico");
}
redirectToView("home");
