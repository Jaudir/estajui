<?php

require_once(dirname(__FILE__) . '/MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Funcionario.php';

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
    public function alterarConvenio($veredito, $justificativa, $cnpj, $usuario) {
        try {
            $statusModel = $this->loader->loadModel('StatusModel', 'StatusModel');
            $estagioModel = $this->loader->loadModel('EstagioModel', 'EstagioModel');
            $alunoModel = $this->loader->loadModel('AlunoModel', 'AlunoModel');

            $status_codigo = 0;

            if ($veredito == 1) {
                $status_codigo = StatusModel::$CONVENIO_APR;
                $justificativa = null;
            } else {
                $status_codigo = StatusModel::$CONVENIO_RPR;
            }

            /* Carregar estágios associados que devem ser notificados desta ação */
            $estagios = $estagioModel->buscarPorEmpresa($cnpj);

            if ($estagios == false) {
                //acontece quando você insere dados manualmente para testes...
                Log::LogError('Empresa não possui nenhum estágio associado');
                return false;
            }

            //inserção dos dados
            $this->conn->beginTransaction();

            $this->conn->exec("UPDATE empresa SET conveniada = $veredito WHERE cnpj = $cnpj");

            //notificar todos os estagios
            foreach ($estagios as $estagio) {
                $statusModel->adicionaNotificacao($status_codigo, $estagio, $usuario, $justificativa);
            }

            if ($veredito == 0)
                $this->removerCadastroEmpresa($cnpj);

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
            $this->loader->loadDAO('Empresa');
            $this->loader->loadDAO('Endereco');
            $this->loader->loadDAO('Responsavel');

            $st = $this->conn->prepare(
                    'SELECT 
                endereco.id as endr_id,
                endereco.*,
                empresa.*,
                responsavel.nome AS resp_nome, responsavel.email AS resp_email, responsavel.telefone AS resp_tel, responsavel.cargo AS resp_cargo
                FROM empresa 
                INNER JOIN endereco ON endereco.id = empresa.endereco_id 
                LEFT JOIN responsavel ON responsavel.empresa_cnpj = empresa.cnpj
                WHERE conveniada = 0');

            $st->execute();

            $emprs = $st->fetchAll();
            if (count($emprs) > 0) {
                $empresas = array();
                foreach ($emprs as $empr) {
                    $empresas[] = new Empresa(
                            $empr['cnpj'], $empr['nome'], $empr['telefone'], $empr['fax'], $empr['nregistro'], $empr['conselhofiscal'], new Endereco(
                            $empr['endr_id'], $empr['logradouro'], $empr['bairro'], $empr['numero'], $empr['complemento'], $empr['cidade'], $empr['uf'], $empr['cep'], null
                            ), new Responsavel(
                            $empr['resp_email'], $empr['resp_nome'], $empr['resp_tel'], $empr['resp_cargo'], null, null
                            ), $empr['conveniada'], $empr['razao_social']
                    );
                }
                return $empresas;
            }
            return false;
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
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE siape LIKE :siape"); ///Recomendo que seja = ao invés de LIKE
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

    public function readbynome($nome, $limite) {
        if ($limite == 0) {
            if ($nome == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE nome LIKE :nome");
                $nomeAux = "%" . $nome . "%";
                $pstmt->bindParam(':nome', $nomeAux);
            }
        } else {
            if ($nome == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE nome LIKE :nome LIMIT :limite");
                $nomeAux = "%" . $nome . "%";
                $pstmt->bindParam(':nome', $nomeAux);
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
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email"); ///Recomendo que seja = ao invés de LIKE
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

    public function updatePermissoes($funcionario) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET bool_po=?, bool_oe=?, bool_ce=?, bool_sra=?, bool_root=?, privilegio=?, formacao=? WHERE siape = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array((int) $funcionario->ispo(), (int) $funcionario->isoe(), (int) $funcionario->isce(), (int) $funcionario->issra(), (int) $funcionario->isroot(), (int) $funcionario->isprivilegio(), $funcionario->getformacao(), $funcionario->getsiape()));
            $this->conn->commit();
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->update($funcionario);
        } catch (PDOExecption $e) {
            $this->conn->rollback();
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

    public function carregarOrientadores() {
        try {
            $campusModel = $this->loader->loadModel('CampusModel', 'CampusModel');

            $stmt = $this->conn->prepare('SELECT * FROM funcionario JOIN usuario ON usuario.email = funcionario.usuario_email WHERE bool_po = 1');
            $stmt->execute();

            $stmt = $stmt->fetchAll();

            $orientadores = array();
            foreach ($stmt as $orientador) {
                $campus = $campusModel->read($orientador["campus_cnpj"], 1)[0];
                $func = $this->newFuncionario($orientador);

                $func->setcampus($campus);

                $orientadores[] = $func;
            }
            return $orientadores;
        } catch (PDOException $ex) {
            Log::LogPDOError($ex);
            return false;
        }
    }

    private function newFuncionario($array) {
        $this->loader->loadDao('Funcionario');

        $func = new Funcionario(null, null, null, null, null, null, null, null, null, null, null, null, null);

        if (isset($array['email']))
            $func->setlogin($array['email']);
        if (isset($array['senha']))
            $func->setsenha($array['senha']);
        if (isset($array['tipo']))
            $func->settipo($array['tipo']);

        if (isset($array['siape']))
            $func->setsiape($array['siape']);
        if (isset($array['nome']))
            $func->setnome($array['nome']);
        if (isset($array['bool_po']))
            $func->setpo(boolval($array['bool_po']));
        if (isset($array['bool_oe']))
            $func->setoe(boolval($array['bool_oe']));
        if (isset($array['bool_ce']))
            $func->setce(boolval($array['bool_ce']));
        if (isset($array['bool_sra']))
            $func->setsra(boolval($array['bool_sra']));
        if (isset($array['bool_root']))
            $func->setroot(boolval($array['bool_root']));
        if (isset($array['formacao']))
            $func->setformacao($array['formacao']);
        if (isset($array['privilegio']))
            $func->setformacao(boolval($array['formacao']));

        return $func;
    }

    // Campos de pesquisa: nome da empresa, nome do responsável, professor orientador ou aluno, entre data de início e de término
    // Infos a serem retornadas: Nome do Estagiário, Data de Início, Término, PO, empresa
    // a função recebe o array $palavras_chave que sao os termos de pesquisa
    // recebe id do usuário que está pesquisando
    // recebe a string relacionada ao tipo de usuario: oe.siape, po.siape ou aluno.cpf
    public function listarEstagios($palavras_chave, $id, $tipo_de_usuario) {
        try {
            $pstmt = $this->conn->prepare("SELECT es.id AS estagio_id, aluno.cpf AS aluno_cpf, curso.nome AS curso_nome, aluno.nome AS aluno_nome, status.codigo AS status_codigo, status.descricao AS status_descricao, pe.data_ini AS pe_data_ini, "
                    . "pe.data_fim AS pe_data_fim, po.nome AS po_nome, em.nome AS em_nome FROM plano_estagio AS pe "
                    . "JOIN estagio AS es ON es.id = pe.estagio_id "
                    . "JOIN funcionario AS po ON po.siape = es.po_siape "
                    . "JOIN empresa AS em ON em.cnpj = es.empresa_cnpj "
                    . "JOIN aluno_estuda_curso AS alescu ON alescu.matricula = es.aluno_estuda_curso_matricula "
                    . "JOIN oferece_curso AS ocu ON ocu.id = alescu.oferece_curso_id "
                    . "JOIN curso ON curso.id = ocu.curso_id = curso.id "
                    . "JOIN funcionario AS oe ON oe.siape = ocu.oe_siape "
                    . "JOIN responsavel AS resp ON resp.empresa_cnpj = em.cnpj "
                    . "JOIN aluno ON aluno.cpf = es.aluno_cpf "
                    . "JOIN status ON status.codigo = es.status_codigo "
                    . "WHERE " . $tipo_de_usuario . " = ? AND curso.nome LIKE ? AND status.descricao LIKE ? AND em.nome LIKE ? AND resp.nome LIKE ? AND aluno.nome LIKE ? AND po.nome LIKE ? AND (pe.data_ini >= ? OR pe.data_fim <= ?)");
            $termos = array();
            $termos[] = $id;
            foreach ($palavras_chave as $pal) {
                $termos[] = $pal;
            }
            $v = $pstmt->execute($termos);
            $res = $pstmt->fetchAll();

            if (count($res) == 0)
                return false;

            $listaEstagios = array();
            $this->loader->loadDao('PlanoDeEstagio');
            $this->loader->loadDao('Funcionario');
            $this->loader->loadDao('Aluno');
            $this->loader->loadDao('Estagio');
            $this->loader->loadDao('Apolice');
            $this->loader->loadDao('Status');
            $this->loader->loadDao('Empresa');
            $this->loader->loadDao('Supervisor');
            $this->loader->loadDao('Curso');
            foreach ($res as $linha) {
                $plano_estagio = new PlanoDeEstagio(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
                $plano_estagio->setdata_inicio($linha['pe_data_ini']);
                $plano_estagio->setdata_fim($linha['pe_data_fim']);

                $empresa = new Empresa(null, null, null, null, null, null, null, null, null, null);
                $empresa->setnome($linha['em_nome']);

                $po = new Funcionario(null, null, null, null, null, null, null, null, null, null, null, null, null);
                $po->setnome($linha['po_nome']);

                $aluno = new Aluno(null, null, null, null, $linha['aluno_nome'], null, null, null, null, null, null, null, null, null, null, null, null, null);

                $status = new Status($linha['status_codigo'], $linha['status_descricao'], null);

                $curso = new Curso(null, $linha['curso_nome']);

                $estagio = new Estagio($linha['estagio_id'], null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);

                $oferta = new OfereceCurso(null, null, $curso, null, null);

                $matricula = new Matricula(null, null, null, $oferta, $aluno);

                $estagio->setmatricula($matricula);
                $estagio->setempresa($empresa);
                $estagio->setfuncionario($po);
                $estagio->setaluno($aluno);
                $estagio->setpe($plano_estagio);
                $estagio->setstatus($status);

                $listaEstagios[] = $estagio;
            }

            return $listaEstagios;
        } catch (PDOException $e) {
            Log::logPDOError($e, true);
            $this->conn->rollback();
            return false;
        }
    }

    public function listarEstagios_ce($palavras_chave) {
        try {
            $pstmt = $this->conn->prepare("SELECT es.id AS estagio_id, aluno.cpf AS aluno_cpf, curso.nome AS curso_nome, aluno.nome AS aluno_nome, status.codigo AS status_codigo, status.descricao AS status_descricao, pe.data_ini AS pe_data_ini, "
                    . "pe.data_fim AS pe_data_fim, po.nome AS po_nome, em.nome AS em_nome, em.conveniada AS em_conveniada FROM plano_estagio AS pe "
                    . "JOIN estagio AS es ON es.id = pe.estagio_id "
                    . "JOIN funcionario AS po ON po.siape = es.po_siape "
                    . "JOIN empresa AS em ON em.cnpj = es.empresa_cnpj "
                    . "JOIN aluno_estuda_curso AS alescu ON alescu.matricula = es.aluno_estuda_curso_matricula "
                    . "JOIN oferece_curso AS ocu ON ocu.id = alescu.oferece_curso_id "
                    . "JOIN curso ON curso.id = ocu.curso_id = curso.id "
                    . "JOIN funcionario AS oe ON oe.siape = ocu.oe_siape "
                    . "JOIN responsavel AS resp ON resp.empresa_cnpj = em.cnpj "
                    . "JOIN aluno ON aluno.cpf = es.aluno_cpf "
                    . "JOIN status ON status.codigo = es.status_codigo "
                    . "WHERE curso.nome LIKE ? AND status.descricao LIKE ? AND em.nome LIKE ? AND resp.nome LIKE ? AND aluno.nome LIKE ? AND po.nome LIKE ? AND (pe.data_ini >= ? OR pe.data_fim <= ?)");
            $termos = array();
            foreach ($palavras_chave as $pal) {
                $termos[] = $pal;
            }
            //var_dump($termos);
            $v = $pstmt->execute($termos);
            $res = $pstmt->fetchAll();

            if (count($res) == 0)
                return false;

            $listaEstagios = array();
            $this->loader->loadDao('PlanoDeEstagio');
            $this->loader->loadDao('Apolice');
            $this->loader->loadDao('Status');
            $this->loader->loadDao('Empresa');
            $this->loader->loadDao('Supervisor');
            $this->loader->loadDao('Curso');
            $this->loader->loadDao('Status');
            foreach ($res as $linha) {
                $plano_estagio = new PlanoDeEstagio(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
                $plano_estagio->setdata_inicio($linha['pe_data_ini']);
                $plano_estagio->setdata_fim($linha['pe_data_fim']);

                $empresa = new Empresa(null, null, null, null, null, null, null, null, $linha['em_conveniada'], null);
                $empresa->setnome($linha['em_nome']);

                $po = new Funcionario(null, null, null, null, null, null, null, null, null, null, null, null, null);
                $po->setnome($linha['po_nome']);

                $aluno = new Aluno(null, null, null, null, $linha['aluno_nome'], null, null, null, null, null, null, null, null, null, null, null, null, null);

                $status = new Status($linha['status_codigo'], $linha['status_descricao'], null);

                $curso = new Curso(null, $linha['curso_nome']);

                $estagio = new Estagio($linha['estagio_id'], null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, $status, null);
                $oferta = new OfereceCurso(null, null, $curso, null, null);

                $matricula = new Matricula(null, null, null, $oferta, $aluno);

                $estagio->setmatricula($matricula);
                $estagio->setempresa($empresa);
                $estagio->setfuncionario($po);
                $estagio->setaluno($aluno);
                $estagio->setpe($plano_estagio);

                $listaEstagios[] = $estagio;
            }
            return $listaEstagios;
        } catch (PDOException $e) {
            Log::logPDOError($e, true);
            $this->conn->rollback();
            return false;
        }
    }

    public function concluirEstagio($estagio) {
        try {
            $statusModel = $this->loader->loadModel('StatusModel', 'StatusModel');

            $this->conn->beginTransaction();

            //atualiza o status do estágio
            $this->conn->exec("UPDATE TABLE estagio SET status_codigo = " . StatusModel::$RELATORIO_SEC . " WHERE id = " . $estagio->getid());

            //adiciona notificações
            $statusModel->adicionaNotificacao(StatusModel::$RELATORIO_SEC, $estagio, $estagio->getusuario());

            $this->conn->commit();
        } catch (PDOException $ex) {
            Log::logPDOError($e);
            $this->conn->rollback();
            return false;
        }
    }

}
