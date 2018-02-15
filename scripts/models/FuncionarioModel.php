<?php

require_once(dirname(__FILE__) . '/MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Funcionario.php";

class FuncionarioModel extends MainModel {

    private $_tabela = "funcionario";

    public function cadastrar($funcionario, $cursos) {
        $this->loader->loadUtil('funcao-geraSenha');
        $this->loader->loadDAO('Usuario');

        try {


            ///Sempre cadastra no Campus Montes Claros!
            $this->conn->beginTransaction();


            $pstmt = $this->conn->prepare("INSERT INTO usuario (email, senha, tipo) VALUES (?, ?, ?)");


            if ($funcionario->getsenha() == NULL || $funcionario->getsenha() == " ") {
                $verif = $pstmt->execute(array($funcionario->getlogin(), Usuario::generateSenha(geraSenha(8, true, true, true)), 2));
                if (!$verif) {
                    print_r($pstmt->errorInfo());
                    return false;
                }
            } else {
                $verif = $pstmt->execute(array($funcionario->getlogin(), $funcionario->getsenha(), 2));
                if (!$verif) {
                    echo "<br>Ali!";
                    print_r($pstmt->errorInfo());
                    $_SESSION['pau12'] = $pstmt->errorInfo();
                    return false;
                }
            }



            $pstmt = $this->conn->prepare("INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, 
							usuario_email, campus_cnpj) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $verif = $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), $funcionario->ispo(), $funcionario->isoe(), $funcionario->isce(), $funcionario->issra(),
                $funcionario->isroot(), $funcionario->getformacao(), $funcionario->isprivilegio(), $funcionario->getlogin(), 10727655000462));
            if (!$verif) {

                $_SESSION['pau1'] = $pstmt->errorInfo();
                return false;
            }


            /* echo "\n".$pstmt->queryString."\n";
              echo $funcionario->getsiape() . '<br>' . $funcionario->getnome() . '<br>' . $funcionario->ispo() . '<br>' . $funcionario->isoe() . '<br>' .
              $funcionario->isce() . '<br>' .	$funcionario->issra() . '<br>' . $funcionario->isroot() . '<br>' . $funcionario->getformacao() .
              '<br>' . $funcionario->isprivilegio() . '<br>' . $funcionario->getlogin() . '<br>' . 10727655000462; */

            if (isset($cursos)) {

                foreach ($cursos as $i => $c) {
                    $_SESSION['curso'] = $c;
                    if (strcmp($c, "cienciadacomputacao") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 1));
                        if (!$verif) {
                            $_SESSION['pau10'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "engenhariaquimica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 2));
                        if (!$verif) {
                            $_SESSION['pau20'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoeminformatica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 3));
                        if (!$verif) {
                            $_SESSION['pau30'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoemquimica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 4));
                        $_SESSION['pau39'] = "Inseriu";
                        if (!$verif) {
                            $_SESSION['pau40'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoemeletrotecnica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 5));
                        if (!$verif) {
                            $_SESSION['pau50'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoemsegurancadotrabalho") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 6));
                        if (!$verif) {
                            $_SESSION['pau60'] = $pstmt->errorInfo();
                            return false;
                        }
                    }
                }
            }

            return $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollback();
            return false;
        }
    }

    //verifica se uma empresa já foi pré cadastrada
    public function verificaPreCadastro($cnpj) {
        try {
            $st = $this->conn->prepare("SELECT conveniada FROM empresa WHERE cnpj = $cnpj");
            $st->execute();

            $data = $st->fetchAll();
            if (count($data) > 0) {
                return ($data[0]['conveniada'] != 0);
            }
        } catch (PDOException $ex) {
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }

    //altera a situação de uma empresa conveniada e notifica os alunos em estágios associados
    public function alterarConvenio($veredito, $justificativa, $cnpj) {
        try {
            $status_codigo = 0;
            $temJustificativa = 0;

            if ($veredito == 1) {
                $status_codigo = 11; //id direto do BD ://///
                $justificativa = '';
                $temJustificativa = 0;
            } else {
                $status_codigo = 12; //id direto do BD ://///
                $temJustificativa = 1;
            }

            /* Carregar alunos de estágios associados que devem ser notificados desta ação */
            $stmt = $this->conn->prepare(
                    "SELECT * FROM estagio
                JOIN aluno ON aluno.cpf = estagio.aluno_cpf
                JOIN usuario ON aluno.usuario_email = usuario.email
                WHERE empresa_cnpj = $cnpj");
            $stmt->execute();

            $alunos = $stmt->fetchAll();
            if (count($alunos) == 0) {
                Log::LogError("Empresa não tem estágios associados", true); //não tem estágios associados, ou alunos associados aos estágios ??
            }

            //inserção dos dados

            $this->conn->beginTransaction();

            $this->conn->exec("UPDATE empresa SET conveniada = $veredito WHERE cnpj = $cnpj");

            //notificar todos os alunos
            foreach ($alunos as $aluno) {
                $estagio_id = $aluno['id'];
                $email = $aluno['email'];

                $this->conn->exec("INSERT INTO modifica_status(data, estagio_id, status_codigo, usuario_email) VALUES(NOW(), '$estagio_id', '$status_codigo', '$email')");
                $last_id = $this->conn->lastInsertId();
                $this->conn->exec("INSERT INTO notificacao(lida, temJustificativa, justificativa, modifica_status_id) VALUES(0, $temJustificativa, '$justificativa', $last_id)");
            }

            $this->conn->commit();
        } catch (PDOException $ex) {
            Log::LogPDOError($ex);
            $this->conn->rollback();
            return false;
        }
        return true;
    }

    public function removerCadastroEmpresa($cnpj) {
        try {
            $this->conn->exec("delete from empresa where cnpj = $cnpj");
            //remover endereço aqui(delete deve ser on cascade)
        } catch (PDOException $ex) {
            Log::LogPDOError($ex);
            return false;
        }
        return true;
    }

    /* Lista status de todos os estágios */

    public function listaEstagios() {
        //listar estágios aqui
        return array();
    }

    /* Lista empresas que estão aguardando aprovação do convênio */

    public function listaEmpresas() {
        try {
            $st = $this->conn->prepare(
                    'SELECT 
                endereco.*,
                empresa.*,
                responsavel.nome AS resp_nome, responsavel.email AS resp_email, responsavel.telefone AS resp_tel, responsavel.cargo AS resp_cargo
                FROM empresa 
                INNER JOIN endereco ON endereco.id = empresa.endereco_id 
                LEFT JOIN responsavel ON responsavel.empresa_cnpj = empresa.cnpj
                WHERE conveniada = 0');
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $ex) {
            Log::LogPDOError($ex);
            return false;
        }
    }

    public function create(Funcionario $funcionario) {
        $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
        $result = $usuarioModel->create($funcionario);
        if ($result == 0) {
            $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            try {
                $this->conn->beginTransaction();
                $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), (int) $funcionario->ispo(), (int) $funcionario->isoe(), (int) $funcionario->isce(), (int) $funcionario->issra(), (int) $funcionario->isroot(), $funcionario->getformacao(), (int) $funcionario->isprivilegio(), $funcionario->getlogin(), $funcionario->getcampus()->getcnpj()));
                $this->conn->commit();
                return 0;
            } catch (PDOExecption $e) {
                $this->conn->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return 2;
            }
        } else {
            return $result;
        }
    }

    public function read($siape, $limite) {
        if ($limite == 0) {
            if ($siape == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE siape LIKE :siape");
                $pstmt->bindParam(':siape', $siape);
            }
        } else {
            if ($siape == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE siape LIKE :siape LIMIT :limite");
                $pstmt->bindParam(':siape', $siape);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
                $campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
                $user = $usuarioModel->read($row["usuario_email"], 1)[0];
                $result[$cont] = new Funcionario($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["siape"], $row["nome"], boolval($row["bool_po"]), boolval($row["bool_oe"]), boolval($row["bool_ce"]), boolval($row["bool_sra"]), boolval($row["bool_root"]), $row["formacao"], boolval($row["privilegio"]), $campusModel->read($row["campus_cnpj"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyusuario(Usuario $user, $limite) {
        $key = $user->getlogin();
        if ($limite == 0) {
            if ($key == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email");
                $pstmt->bindParam(':usuario_email', $key);
            }
        } else {
            if ($key == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email LIMIT :limite");
                $pstmt->bindParam(':usuario_email', $key);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
                $result[$cont] = new Funcionario($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["siape"], $row["nome"], boolval($row["bool_po"]), boolval($row["bool_oe"]), boolval($row["bool_ce"]), boolval($row["bool_sra"]), boolval($row["bool_root"]), $row["formacao"], boolval($row["privilegio"]), $campusModel->read($row["campus_cnpj"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbycampus(Campus $campus, $limite) {
        $key = $campus->getcnpj();
        if ($limite == 0) {
            if ($key == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE campus_cnpj LIKE :campus_cnpj");
                $pstmt->bindParam(':campus_cnpj', $key);
            }
        } else {
            if ($key == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE campus_cnpj LIKE :campus_cnpj LIMIT :limite");
                $pstmt->bindParam(':campus_cnpj', $key);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
                $user = $usuarioModel->read($row["usuario_email"], 1)[0];
                $result[$cont] = new Funcionario($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["siape"], $row["nome"], boolval($row["bool_po"]), boolval($row["bool_oe"]), boolval($row["bool_ce"]), boolval($row["bool_sra"]), boolval($row["bool_root"]), $row["formacao"], boolval($row["privilegio"]), $campus);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Funcionario $funcionario) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET siape=?, nome=?, bool_po=?, bool_oe=?, bool_ce=?, bool_sra=?, bool_root=?, formacao=?, privilegio=?, campus_cnpj=? WHERE siape = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), (int) $funcionario->ispo(), (int) $funcionario->isoe(), (int) $funcionario->isce(), (int) $funcionario->issra(), (int) $funcionario->isroot(), $funcionario->getformacao(), (int) $funcionario->isprivilegio(), $funcionario->getlogin(), $funcionario->getcampus()->getcnpj(), $funcionario->getsiape()));
            $this->conn->commit();
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->update($funcionario);
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Funcionario $funcionario) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->_tabela . " WHERE siape LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($this->getsiape()));
            $this->conn->commit();
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->delete($funcionario);
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}

?>