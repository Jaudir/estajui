<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (!$session->isLogged()) {
    redirect("login.php");
}

if (isset($_POST["id"])) {
    if (isset($_POST["entregue"])) {
        $estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
        $estagio = $estagioModel->read($_POST["id"], 1);
        if (is_array($estagio)) {
            if (count($estagio) > 0) {
                $estagio = $estagio[0];
                if ($_POST["entregue"] == "1") {
                    $modificacaostatusModel = $loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                    $notificacaoModel = $loader->loadModel("NotificacaoModel", "NotificacaoModel");
                    $statusModel = $loader->loadModel("StatusModel", "StatusModel");
                    $status = $statusModel->read(6, 1);
                    if ($status)
                        $estagio->setstatus($status[0]);
                    else
                        $session->pushError("Erro ao definir novo status!", "error-critico");
                    $modicacao = new ModificacaoStatus(NULL, date("Y-m-d H:i:s"), $estagio, $status[0], $session->getUsuario());
                    $notificacao = new Notificacao(null, false, $modicacao, $_POST["justificativa"]);
                    if (!$estagioModel->update($estagio) && !$modificacaostatusModel->create($modicacao) && !$notificacaoModel->create($notificacao)) {
                        $session->pushValue("Operação realizada com sucesso!", "sucesso");
                    } else {
                        $session->pushError("Erro no Banco de Dados!", "error-critico");
                    }
                } else {
                    if (!empty($_POST["justificativa"])) {
                        $modificacaostatusModel = $loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                        $notificacaoModel = $loader->loadModel("NotificacaoModel", "NotificacaoModel");
                        $statusModel = $loader->loadModel("StatusModel", "StatusModel");
                        $status = $statusModel->read(10, 1);
                        if ($status)
                            $estagio->setstatus($status[0]);
                        else
                            $session->pushError("Erro ao definir novo status!", "error-critico");
                        $modicacao = new ModificacaoStatus(NULL, date("Y-m-d H:i:s"), $estagio, $status[0], $session->getUsuario());
                        $notificacao = new Notificacao(null, false, $modicacao, $_POST["justificativa"]);
                        if (!$estagioModel->update($estagio) && !$modificacaostatusModel->create($modicacao) && !$notificacaoModel->create($notificacao)) {
                            $session->pushValue("Operação realizada com sucesso!", "sucesso");
                        } else {
                            $session->pushError("Erro no Banco de Dados!", "error-critico");
                        }
                    } else {
                        $session->pushError("Descreva os erros dos documentos!", "error-validacao");
                    }
                }
            } else {
                $session->pushError("Erro! (Estágio não encontrado)!", "error-critico");
            }
        } else {
            $session->pushError("Erro no Banco de Dados!", "error-critico");
        }
    } else {
        if (!isset($_POST["aptidao"])) {
            $session->pushError("Preencha se os documentos foram corretamente entregues!", "error-validacao");
        }
    }
} else {
    $session->pushError("Erro de identificação", "error-critico");
}
redirectToView("home");
