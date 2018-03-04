<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (!$session->isLogged()) {
    redirect("login.php");
}

if (isset($_POST["id"])) {
//    if (isset($_POST["matricula"]) && isset($_POST["semestre"]) && isset($_POST["serie"]) && isset($_POST["modulo"]) && isset($_POST["periodo"]) && isset($_POST["integralizacao"]) && isset($_POST["dependencias"]) && isset($_POST["aptidao"]))
    if (!empty($_POST["matricula"]) && !empty($_POST["semestre"]) && isset($_POST["aptidao"])) {
        $estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
        $estagio = $estagioModel->read($_POST["id"], 1);
        if (is_array($estagio)) {
            if (count($estagio) > 0) {
                $estagio = $estagio[0];
                $valorestmp = explode("/", $_POST["semestre"]);
                $matricula = $estagio->getmatricula();
                $matricula_anterior = clone($matricula);
                $matricula->setmatricula((int) $_POST["matricula"]);
                $matricula->setsemestre_inicio((int) $valorestmp[0]);
                $matricula->setano_inicio((int) $valorestmp[1]);
                if ($_POST["aptidao"] == "1") {
                    $estagio->setaprovado(TRUE);
                    if (isset($_POST["matriculado"])) {
                        if (!empty($_POST["serie"]) && !empty($_POST["modulo"]) && !empty($_POST["periodo"])) {
                            $estagio->setserie($_POST["serie"]);
                            $estagio->setmodulo($_POST["modulo"]);
                            $estagio->setperiodo($_POST["periodo"]);
                        } else {
                            if (empty($_POST["serie"])) {
                                $session->pushError("Digite a serie do aluno!", "error-validacao");
                            } elseif (empty($_POST["modulo"])) {
                                $session->pushError("Digite o modulo do aluno!", "error-validacao");
                            } else {
                                $session->pushError("Digite o periodo do aluno!", "error-validacao");
                            }
                        }
                    }
                    if (isset($_POST["integralizado"])) {
                        if (!empty($_POST["integralizacao"])) {
                            $valores = explode("/", $_POST["integralizacao"]);
                            $estagio->setsemestre($valores[0]);
                            $estagio->setano($valores[1]);
                        } else {
                            $session->pushError("Digite o semestre/ano da integralização do aluno!", "error-validacao");
                        }
                    }
                    if (isset($_POST["emregime"])) {
                        if (!empty($_POST["dependencias"])) {
                            $estagio->setdependencias($_POST["dependencias"]);
                        } else {
                            $session->pushError("Digite as dependências do aluno!", "error-validacao");
                        }
                    }
                    $modificacaostatusModel = $loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                    $matriculaModel = $loader->loadModel("MatriculaModel", "MatriculaModel");
                    $notificacaoModel = $loader->loadModel("NotificacaoModel", "NotificacaoModel");
                    $statusModel = $loader->loadModel("StatusModel", "StatusModel");
                    $status = $statusModel->read(2, 1);
                    if ($status)
                        $estagio->setstatus($status[0]);
                    else
                        $session->pushError("Erro ao definir novo status!", "error-critico");
                    $modicacao = new ModificacaoStatus(NULL, date("Y-m-d H:i:s"), $estagio, $status[0], $session->getUsuario());
                    $notificacao = new Notificacao(null, false, $modicacao, null);
                    $matricularesult = $matriculaModel->updatematricula($matricula, $matricula_anterior->getmatricula());
                    if (!$matricularesult) {
                        $estagio->setmatricula($matricula);
                        if (!$estagioModel->update($estagio) && !$modificacaostatusModel->create($modicacao) && !$notificacaoModel->create($notificacao)) {
                            $session->pushValue("Aluno avaliado com sucesso!", "sucesso");
                        } else {
                            $session->pushError("Erro no Banco de Dados!", "error-critico");
                        }
                    } else {
                        $session->pushError("Erro no Banco de Dados!", "error-critico");
                    }
                } else {
                    if (!empty($_POST["justificativa"])) {
                        $estagio->setaprovado(FALSE);
                        if (isset($_POST["matriculado"])) {
                            if (!empty($_POST["serie"]) && !empty($_POST["modulo"]) && !empty($_POST["periodo"])) {
                                $estagio->setserie($_POST["serie"]);
                                $estagio->setmodulo($_POST["modulo"]);
                                $estagio->setperiodo($_POST["periodo"]);
                            } else {
                                if (empty($_POST["serie"])) {
                                    $session->pushError("Digite a serie do aluno!", "error-validacao");
                                } elseif (empty($_POST["modulo"])) {
                                    $session->pushError("Digite o modulo do aluno!", "error-validacao");
                                } else {
                                    $session->pushError("Digite o periodo do aluno!", "error-validacao");
                                }
                            }
                        }
                        if (isset($_POST["integralizado"])) {
                            if (!empty($_POST["integralizacao"])) {
                                $valores = explode("/", $_POST["integralizacao"]);
                                $estagio->setsemestre($valores[0]);
                                $estagio->setano($valores[1]);
                            } else {
                                $session->pushError("Digite o semestre/ano da integralização do aluno!", "error-validacao");
                            }
                        }
                        if (isset($_POST["emregime"])) {
                            if (!empty($_POST["dependencias"])) {
                                $estagio->setdependencias($_POST["dependencias"]);
                            } else {
                                $session->pushError("Digite as dependências do aluno!", "error-validacao");
                            }
                        }
                        $modificacaostatusModel = $loader->loadModel("ModificacaoStatusModel", "ModificacaoStatusModel");
                        $matriculaModel = $loader->loadModel("MatriculaModel", "MatriculaModel");
                        $notificacaoModel = $loader->loadModel("NotificacaoModel", "NotificacaoModel");
                        $statusModel = $loader->loadModel("StatusModel", "StatusModel");
                        $status = $statusModel->read(14, 1);
                        if ($status)
                            $estagio->setstatus($status[0]);
                        else
                            $session->pushError("Erro ao definir novo status!", "error-critico");
                        $modicacao = new ModificacaoStatus(NULL, date("Y-m-d H:i:s"), $estagio, $status[0], $session->getUsuario());
                        $notificacao = new Notificacao(null, false, $modicacao, $_POST["justificativa"]);
                        $matricularesult = $matriculaModel->updatematricula($matricula, $matricula_anterior->getmatricula());
                        if (!$matricularesult) {
                            $estagio->setmatricula($matricula);
                            if (!$estagioModel->update($estagio) && !$modificacaostatusModel->create($modicacao) && !$notificacaoModel->create($notificacao)) {
                                $session->pushValue("Aluno avaliado com sucesso!", "sucesso");
                            } else {
                                $session->pushError("Erro no Banco de Dados!", "error-critico");
                            }
                        } else {
                            $session->pushError("Erro no Banco de Dados!", "error-critico");
                        }
                    } else {
                        $session->pushError("Justifique a sua decisão!", "error-validacao");
                    }
                }
            } else {
                $session->pushError("Erro! (Estágio não encontrado)!", "error-critico");
            }
        } else {
            $session->pushError("Erro no Banco de Dados!", "error-critico");
        }
    } else {
        if (empty($_POST["matricula"])) {
            $session->pushError("Digite a matricula do aluno!", "error-validacao");
        } elseif (empty($_POST["semestre"])) {
            $session->pushError("Digite o semestre/ano que o aluno iniciou o curso! (Ex.: 2/2017)", "error-validacao");
        } elseif (!isset($_POST["aptidao"])) {
            $session->pushError("Avalie se o aluno está apto a realizar o estágio!", "error-validacao");
        }
    }
} else {
    $session->pushError("Erro de identificação", "error-critico");
}
redirectToView("home");
