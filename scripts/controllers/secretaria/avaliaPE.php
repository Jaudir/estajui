<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/base-controller.php";

$session = getSession();
if (isset($_GET["logoff"])) {
    $session->destroy();
    redirect("login.php");
}
if (!$session->isLogged()) {
    redirect("login.php");
}

if (isset($_POST["id"])) {
//    if (isset($_POST["matricula"]) && isset($_POST["semestre"]) && isset($_POST["serie"]) && isset($_POST["modulo"]) && isset($_POST["periodo"]) && isset($_POST["integralizacao"]) && isset($_POST["dependencias"]) && isset($_POST["aptidao"]))
    if (!empty($_POST["matricula"]) && !empty($_POST["semestre"]) && !empty($_POST["aptidao"]) && !empty($_POST["justificativa"])) {
        $estagioModel = $loader->loadModel("EstagioModel", "EstagioModel");
        $estagio = $estagioModel->read($_POST["id"], 1);
        if (is_array($estagio)) {
            if (count($estagio) > 0) {
                if ($_POST["aptidao"] == "0") {
                    $estagio->setaprovado(TRUE);
                } else {
                    $estagio->setaprovado(FALSE);
                }
                $estagio->setjustificativa($_POST["justificativa"]);
                if (isset($_POST["matriculado"])) {
                    if (!empty($_POST["serie"]) && !empty($_POST["modulo"]) && !empty($_POST["periodo"])) {
                        $estagio->setserie($_POST["serie"]);
                        $estagio->setmodulo($_POST["modulo"]);
                        $estagio->setperiodo($_POST["periodo"]);
                    } else {
                        if (empty($_POST["serie"])) {
                            $session->pushError("Digite a serie do aluno!", "avalia-peError");
                        } elseif (empty($_POST["modulo"])) {
                            $session->pushError("Digite o modulo do aluno!", "avalia-peError");
                        } else {
                            $session->pushError("Digite o periodo do aluno!", "avalia-peError");
                        }
                    }
                }
                if (isset($_POST["integralizado"])) {
                    if (!empty($_POST["integralizacao"])) {
                        $valores = explode("/", $_POST["integralizacao"]);
                        $estagio->setsemestre($valores[0]);
                        $estagio->setano($valores[1]);
                    } else {
                        $session->pushError("Digite o semestre/ano da integralização do aluno!", "avalia-peError");
                    }
                }
                if (isset($_POST["emregime"])) {
                    if (!empty($_POST["dependencias"])) {
                        $estagio->setdependencias($_POST["dependencias"]);
                    } else {
                        $session->pushError("Digite as dependências do aluno!", "avalia-peError");
                    }
                }
                if ($estagioModel->update($estagio) == 0) {
                    $session->pushValue("Aluno avaliado com sucesso!", "avalia-pe");
                } else {
                    $session->pushError("Erro no Banco de Dados!", "avalia-peError");
                }
            } else {
                $session->pushError("Erro! (Estágio não encontrado)!", "avalia-peError");
            }
        } else {
            $session->pushError("Erro no Banco de Dados!", "avalia-peError");
        }
    } else {
        if (empty($_POST["matricula"])) {
            $session->pushError("Digite a matricula do aluno!", "avalia-peError");
        } elseif (empty($_POST["semestre"])) {
            $session->pushError("Digite o semestre/ano que o aluno iniciou o curso! (Ex.: 2/2017)", "avalia-peError");
        } elseif (empty($_POST["aptidao"])) {
            $session->pushError("Avalie se o o aluno está apto a realizar o estágio!", "avalia-peError");
        } else {
            $session->pushError("Justifique a sua decisão!", "avalia-peError");
        }
//        redirect("home.php?id=");
    }
    if ($session->hasError("avalia-peError")) {
        echo $session->getErrors("avalia-peError")[0];
    }
}