<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Aluno.php";

class AlunoModel extends MainModel {

    private $_tabela = "aluno";

    public function create($aluno) {
        $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
        $result = $usuarioModel->create($aluno);
        if ($result) {
            $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (cpf, nome, data_nasc, rg_num, rg_orgao, estado_civil, sexo, telefone, celular, nome_pai, nome_mae, cidade_natal, estado_natal, endereco_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            try {
                $this->conn->beginTransaction();
                $pstmt->execute(array($aluno->getcpf(), $aluno->getnome(), $aluno->getdatat_nasc(), $aluno->getrg_num(), $aluno->getrg_orgao(), $aluno->getestado_civil(), $aluno->getsexo(), $aluno->gettelefone(), $aluno->getcelular(), $aluno->getnome_pai(), $aluno->getnome_mae(), $aluno->getcidade_natal(), $aluno->getestado_natal(), (int) $aluno->getacesso(), $aluno->getendereco()->getid()));
                $this->conn->commit();
                return 0;
            } catch (PDOException $e) {
                $this->conn->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return 2;
            }
        } else {
            return $result;
        }
    }

    public function read($cpf, $limite) {
        if ($limite == 0) {
            if ($cpf == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE cpf LIKE :cpf");
                $pstmt->bindParam(':cpf', $cpf);
            }
        } else {
            if ($cpf == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE cpf LIKE :cpf LIMIT :limite");
                $pstmt->bindParam(':cpf', $cpf);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            $enderecoModel = $this->loader->loadModel("EnderecoModel", "EnderecoModel");
            $cursoModel = $this->loader->loadModel("CursoModel", "CursoModel");

            while ($row = $pstmt->fetch()) {
                $user = $usuarioModel->read($row["usuario_email"], 1)[0];
                $result[$cont] = new Aluno($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["cpf"], $row["nome"], $row["data_nasc"], $row["rg_num"], $row["rg_orgao"], $row["estado_civil"], $row["sexo"], $row["telefone"], $row["celular"], $row["nome_pai"], $row["nome_mae"], $row["cidade_natal"], $row["estado_natal"], boolval($row["acesso"]), $enderecoModel->read($row["endereco_id"], 1)[0]);
                $result[$cont]->setCursos($cursoModel->getCursoAluno($result[$cont]));
                $cont++;
            }
            return $result;
        } catch (PDOException $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function getCursos(Aluno $aluno) {
        if ($this->conn) {
            $pstmt = $this->conn->prepare("SELECT * FROM aluno_estuda_curso WHERE aluno_cpf LIKE :aluno_cpf");
            $pstmt->bindParam(':aluno_cpf', $aluno->getcpf());
        }
    }

    public function readbyusuario(Usuario $user, $limite) {
        $key = $user->getlogin();
        if ($this->conn) {
            if ($limite == 0) {
                if ($user == NULL) {
                    $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
                } else {
                    $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email");
                    $pstmt->bindParam(':usuario_email', $key);
                }
            } else {
                if ($user == NULL) {
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
                    $enderecoModel = $this->loader->loadModel("EnderecoModel", "EnderecoModel");
                    $result[$cont] = new Aluno($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["cpf"], $row["nome"], $row["data_nasc"], $row["rg_num"], $row["rg_orgao"], $row["estado_civil"], $row["sexo"], $row["telefone"], $row["celular"], $row["nome_pai"], $row["nome_mae"], $row["cidade_natal"], $row["estado_natal"], boolval($row["acesso"]), $enderecoModel->read($row["endereco_id"], 1)[0]);
                    $cont++;
                }
                return $result;
            } catch (PDOExecption $e) {
                #return "Error!: " . $e->getMessage() . "</br>";
                return 2;
            }
        } else {
            return 1;
        }
    }

    public function update(Aluno $aluno) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET cpf=?, nome=?, data_nasc=?, rg_num=?, rg_orgao=?, estado_civil=?, sexo=?, telefone=?, celular=?, nome_pai=?, nome_mae=?, cidade_natal=?, estado_natal=?, acesso=?, endereco_id=? WHERE cpf = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($aluno->getcpf(), $aluno->getnome(), $aluno->getdatat_nasc(), $aluno->getrg_num(), $aluno->getrg_orgao(), $aluno->getestado_civil(), $aluno->getsexo(), $aluno->gettelefone(), $aluno->getcelular(), $aluno->getnome_pai(), $aluno->getnome_mae(), $aluno->getcidade_natal(), $aluno->getestado_natal(), (int) $aluno->getacesso(), $aluno->getendereco()->getid(), $aluno->getcpf()));
            $this->conn->commit();
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->update($aluno);
        } catch (PDOException $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Aluno $aluno) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE cpf LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($aluno->getcpf()));
            $this->conn->commit();
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->delete($aluno);
        } catch (PDOException $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function cadastrar($aluno) {
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO usuario (email, senha, tipo) VALUES(?,?, ?)");
            $pstmt->execute(array($aluno->getlogin(), Usuario::generateSenha($aluno->getsenha()), $aluno->gettipo()));

            $pstmt = $this->conn->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
            $pstmt->execute(array($aluno->getendereco()->getlogradouro(), $aluno->getendereco()->getbairro(), $aluno->getendereco()->getnumero(), $aluno->getendereco()->getcomplemento(), $aluno->getendereco()->getcidade(), $aluno->getendereco()->getuf(), $aluno->getendereco()->getcep()));
            $endereco = $aluno->getendereco();
            $endereco -> setid($this->conn->lastInsertId());
            $pstmt = $this->conn->prepare(" INSERT INTO aluno (nome, estado_natal, cidade_natal, data_nasc, nome_pai, nome_mae, estado_civil, sexo, rg_num, rg_orgao, cpf, telefone, celular, usuario_email, endereco_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pstmt->execute(array($aluno->getnome(), $aluno->getestado_natal(), $aluno->getcidade_natal(), $aluno->getdatat_nasc(), $aluno->getnome_pai(), $aluno->getnome_mae(), $aluno->getestado_civil(), $aluno->getsexo(), $aluno->getrg_num(), $aluno->getrg_orgao(), $aluno->getcpf(), $aluno->gettelefone(), $aluno->getcelular()
                , $aluno->getlogin(), $endereco->getid()));

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function recuperar($aluno) {
        try {
            $pstmt = $this->conn->prepare("SELECT * FROM aluno JOIN endereco ON endereco.id=aluno.endereco_id JOIN usuario ON aluno.usuario_email=usuario.email WHERE aluno.cpf=?");
            $v = $pstmt->execute(array($aluno->getcpf()));
            $res = $pstmt->fetchAll();

            if (count($res) == 0)
                return false;

            $res = $res[0];

            $endereco = new Endereco($res['id'], $res['logradouro'], $res['bairro'], $res['numero'], $res['complemento'], $res['cidade'], $res['uf'], $res['cep'],null);
            $aluno = new Aluno($res['usuario_email'], $res['senha'], $res['tipo'], $res['cpf'], $res['nome'], $res['data_nasc'], $res['rg_num'], $res['rg_orgao'], $res['estado_civil'], $res['sexo'], $res['telefone'], $res['celular'], $res['nome_pai'], $res['nome_mae'], $res['cidade_natal'], $res['estado_natal'], $res['acesso'], $endereco);

            return $aluno;
        } catch (PDOException $e) {
            Log::logPDOError($e, true);
            $this->conn->rollback();
            return false;
        }
    }

    public function atualizar($aluno) {
        try {
            $endereco = $aluno->getendereco();

            $pstmt = $this->conn->prepare("UPDATE usuario SET senha=? WHERE email=?");
            $pstmt->execute(array($aluno->getsenha(), $aluno->getlogin()));

            $pstmt = $this->conn->prepare("UPDATE endereco SET logradouro=?, bairro=?, numero=?, complemento=?, cidade=?, uf=?, cep=? WHERE id=?");
            $pstmt->execute(array($endereco->getlogradouro(), $endereco->getbairro(), $endereco->getnumero(), $endereco->getcomplemento(), $endereco->getcidade(), $endereco->getuf(),
                $endereco->getcep(), $endereco->getid()));

            $pstmt = $this->conn->prepare("UPDATE aluno SET nome=?, rg_orgao=?, estado_civil=?, sexo=?, telefone=?, celular=?, nome_pai=?, nome_mae=?, cidade_natal=?, estado_natal=?
										  WHERE cpf=?");
            $pstmt->execute(array($aluno->getnome(), $aluno->getrg_orgao(), $aluno->getestado_civil(), $aluno->getsexo(), $aluno->gettelefone(), $aluno->getcelular(), $aluno->getnome_pai(),
                $aluno->getnome_mae(), $aluno->getcidade_natal(), $aluno->getestado_natal(), $aluno->getcpf()));
        } catch (PDOException $e) {
            Log::logPDOError($e, true);
            $this->conn->rollback();
            return false;
        }
        return true;
    }

    public function VerificaLoginCadastrado($email) {
        try {
            $pstmt = $this->conn->prepare("SELECT email from usuario WHERE email LIKE :email");
            $pstmt->bindParam(':email', $email);
            $pstmt->execute();
            if ($pstmt->fetch() == null) {
                return false;
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
	
	public function visualizarEstagios($aluno_cpf){
		try {
            $pstmt = $this->conn->prepare("SELECT es.id AS estagio_id, es.bool_aprovado, es.bool_obrigatorio, s.descricao, ap.numero AS ap_numero, ap.seguradora, "
			."sor.nome AS sor_nome, sor.habilitacao, sor.cargo, f.nome AS f_nome, f.formacao, p.data_ini, p.data_fim, "
			."p.hora_inicio1, p.hora_inicio2, p.hora_fim1, p.hora_fim2, p.total_horas, p.atividades, em.nome AS em_nome, em.razao_social, "
			."em.cnpj, en.logradouro, en.numero AS en_numero, en.bairro, en.cidade, en.uf, en.cep, em.telefone, "
			."em.fax, em.nregistro, em.conselhofiscal FROM plano_estagio AS p "
			."JOIN estagio AS es ON p.estagio_id = es.id "
			."JOIN supervisiona AS sona ON es.id = sona.estagio_id "
			."JOIN supervisor AS sor ON sona.supervisor_id = sor.id "
			."JOIN apolice AS ap ON es.id = ap.estagio_id "
			."JOIN funcionario AS f ON es.po_siape = f.siape "
			."JOIN empresa AS em ON es.empresa_cnpj = em.cnpj "
			."JOIN endereco AS en ON em.endereco_id = en.id "
			."JOIN status AS s ON es.status_codigo = s.codigo "
			."WHERE es.aluno_cpf=?");
            $v = $pstmt->execute(array($aluno_cpf));
            $res = $pstmt->fetchAll();

            if (count($res) == 0)
                return false;
			
			$listaEstagios = array();
            $this->loader->loadDao('PlanoDeEstagio');
            $this->loader->loadDao('Apolice');
            $this->loader->loadDao('Status');
            $this->loader->loadDao('Empresa');
            $this->loader->loadDao('Supervisor');
            foreach ($res as $linha) {
				$funcionario = new Funcionario(null, null, null, null, $linha['f_nome'], null, null, null, null, null, $linha['formacao'], null, null);
				$apolice = new Apolice($linha['ap_numero'], $linha['seguradora'], null);
				$status = new Status(null, $linha['descricao'], null);
				$endereco = new Endereco(null, $linha['logradouro'], $linha['bairro'], $linha['en_numero'], null, $linha['cidade'], $linha['uf'], $linha['cep'], null);
				$empresa = new Empresa($linha['cnpj'], $linha['em_nome'], $linha['telefone'], $linha['fax'], $linha['nregistro'], $linha['conselhofiscal'], $endereco, null, null, null);
                $planoDeEstagio = new PlanoDeEstagio(null, null, null, $linha['atividades'], null, null, $linha['data_ini'], $linha['data_fim'], $linha['hora_inicio1'], $linha['hora_inicio2'], $linha['hora_fim1'], $linha['hora_fim2'], $linha['total_horas'], null, null);
				$supervisor = new Supervisor(null, $linha['sor_nome'], $linha['cargo'], $linha['habilitacao'], null);
				$estagio = new Estagio(null, $linha['bool_aprovado'], $linha['bool_obrigatorio'], null, null, null, null, null, null, null, null, null, null, null,$empresa, null, $funcionario, null, $status, $planoDeEstagio);
				$estagio->setapolice($apolice);
				$estagio->setsupervisor($supervisor);
				$listaEstagios[] = $estagio;
			}

            return $listaEstagios;
        } catch (PDOException $e) {
            Log::logPDOError($e, true);
            $this->conn->rollback();
            return false;
        }
	}

	public function listarEstagios($palavras_chave, $id, $tipo_de_usuario){
		try {
            $pstmt = $this->conn->prepare("SELECT es.id AS estagio_id, aluno.cpf AS aluno_cpf, curso.nome AS curso_nome, aluno.nome AS aluno_nome, status.codigo AS status_codigo, status.descricao AS status_descricao, pe.data_ini AS pe_data_ini, "
			."pe.data_fim AS pe_data_fim, po.nome AS po_nome, em.nome AS em_nome FROM plano_estagio AS pe "
			."JOIN estagio AS es ON es.id = pe.estagio_id "
			."JOIN funcionario AS po ON po.siape = es.po_siape "
			."JOIN empresa AS em ON em.cnpj = es.empresa_cnpj "
			."JOIN aluno_estuda_curso AS alescu ON alescu.matricula = es.aluno_estuda_curso_matricula "
			."JOIN oferece_curso AS ocu ON ocu.id = alescu.oferece_curso_id "
            ."JOIN curso ON curso.id = ocu.curso_id = curso.id "
			."JOIN funcionario AS oe ON oe.siape = ocu.oe_siape "
			."JOIN responsavel AS resp ON resp.empresa_cnpj = em.cnpj "
			."JOIN aluno ON aluno.cpf = es.aluno_cpf "
            ."JOIN status ON status.codigo = es.status_codigo "
			."WHERE ".$tipo_de_usuario." = ? AND curso.nome LIKE ? AND status.descricao LIKE ? AND em.nome LIKE ? AND resp.nome LIKE ? AND aluno.nome LIKE ? AND po.nome LIKE ? AND (pe.data_ini >= ? OR pe.data_fim <= ?)");
            $termos = array();
			$termos[] = $id;
			foreach ($palavras_chave as $pal){
				$termos[] = $pal;
			}
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
            foreach ($res as $linha) {
				$plano_estagio = new PlanoDeEstagio(null,null,null,null,null,null,null,null,null,null,null,null,null,null, null);
				$plano_estagio->setdata_inicio($linha['pe_data_ini']);
				$plano_estagio->setdata_fim($linha['pe_data_fim']);

				$empresa = new Empresa(null,null,null,null,null,null,null,null, null, null);
				$empresa->setnome($linha['em_nome']);

				$po = new Funcionario(null,null,null,null,null,null,null,null,null,null,null,null,null);
				$po->setnome($linha['po_nome']);

				$aluno = new Aluno(null, null, null, null, $linha['aluno_nome'], null, null, null, null, null, null, null, null, null, null, null, null, null);

                $status = new Status($linha['status_codigo'], $linha['status_descricao'], null);

                $curso = new Curso(null, $linha['curso_nome']);

                $estagio = new Estagio($linha['estagio_id'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null, null, null);

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

    public function obterCursos(){
        
    }
}
