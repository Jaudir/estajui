<?php

require_once('MainModel.php');

class EstagioModel extends MainModel {

    private $_tabela = "estagio";
    private $_tabela_intermediaria = "relatorio";


	public function recuperar($estagio_id) {
		try {

			$pstmt = $this->conn->prepare("SELECT es.id, es.aluno_cpf, es.bool_aprovado, es.bool_obrigatorio, s.descricao AS status_descricao, ap.numero AS ap_numero, ap.seguradora, "
			."sor.nome AS sor_nome, sor.habilitacao, sor.cargo, f.nome AS f_nome, f.formacao, p.data_ini, p.data_fim, "
			."p.hora_inicio1, p.hora_inicio2, p.hora_fim1, p.hora_fim2, p.total_horas, p.atividades, em.nome AS em_nome, em.razao_social, "
			."em.cnpj, en.logradouro, en.numero AS en_numero, en.bairro, en.cidade, en.uf, en.cep, em.telefone, "
			."em.fax, em.nregistro, em.conselhofiscal FROM plano_estagio AS p "
			."LEFT JOIN estagio AS es ON p.estagio_id = es.id "
			."LEFT JOIN supervisiona AS sona ON es.id = sona.estagio_id "
			."LEFT JOIN supervisor AS sor ON sona.supervisor_id = sor.id "
			."LEFT JOIN apolice AS ap ON es.id = ap.estagio_id "
			."LEFT JOIN funcionario AS f ON es.po_siape = f.siape "
			."LEFT JOIN empresa AS em ON es.empresa_cnpj = em.cnpj "
			."LEFT JOIN endereco AS en ON em.endereco_id = en.id "
			."LEFT JOIN status AS s ON es.status_codigo = s.codigo "
			."WHERE es.id=?");
			$v = $pstmt->execute(array($estagio_id));
			$res = $pstmt->fetchAll();
			$q = count($res);
			if ($q == 0){
				return false;
			}
			$res = $res[0];
            $this->loader->loadDao('PlanoDeEstagio');
            $this->loader->loadDao('Apolice');
            $this->loader->loadDao('Status');
            $this->loader->loadDao('Empresa');
            $this->loader->loadDao('Supervisor');
            $this->loader->loadDao('Funcionario');
            $this->loader->loadDao('Endereco');
            $this->loader->loadDao('Estagio');
			$funcionario = new Funcionario(null, null, null, null, $res['f_nome'], null, null, null, null, null, $res['formacao'], null, null);
			$apolice = new Apolice($res['ap_numero'], $res['seguradora']);
            
            $alunoModel = $this->loader->loadModel('AlunoModel', 'AlunoModel');

			$funcionario = new Funcionario(null, null, null, null, $res['f_nome'], null, null, null, null, null, $res['formacao'], null, null);
			$apolice = new Apolice($res['ap_numero'], $res['seguradora'], null);
			$status = new Status(null, $res['status_descricao'], null);
			$endereco = new Endereco(null, $res['logradouro'], $res['bairro'], $res['en_numero'], null, $res['cidade'], $res['uf'], $res['cep'], null);
			$empresa = new Empresa($res['cnpj'], $res['em_nome'], $res['telefone'], $res['fax'], $res['nregistro'], $res['conselhofiscal'], $endereco, null, null, null);
			$planoDeEstagio = new PlanoDeEstagio(null, null,null, $res['atividades'], null, null, $res['data_ini'], $res['data_fim'], $res['hora_inicio1'], $res['hora_inicio2'], $res['hora_fim1'], $res['hora_fim2'], $res['total_horas'], null, null);
			$supervisor = new Supervisor(null, $res['sor_nome'], $res['cargo'], $res['habilitacao'], null);
			$estagio = new Estagio($res['id'], $res['bool_aprovado'], $res['bool_obrigatorio'], $apolice, $supervisor, null, null, null, null, null, null, null, null, null, $empresa, $alunoModel->read($res['aluno_cpf'], 1)[0], $funcionario, null, $status, $planoDeEstagio);

            return $estagio;
		} catch (PDOException $e) {
			Log::LogPDOError($e, true);
			return false;
		}
	}

	public function cadastrarDadosEstagio($supervisor, $endereco, $planoDeEstagio,$empresa, $novo){
		if($novo == true){
			
			try{
				$this->conn->beginTransaction();
				$pstmt = $this->conn->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) 
				VALUES(?, ?, ?, ?, ?, ?, ?)");
                $pstmt->execute(array($endereco->getlogradouro(), $endereco->getbairro(), $endereco->getnumero(), $endereco->getcomplemento(),
                    $endereco->getcidade(), $endereco->getuf(), $endereco->getcep()));
                $endereco->setid($this->conn->lastInsertId());

                $pstmt = $this->conn->prepare("INSERT INTO empresa (cnpj,nome, razao_social,fax,telefone,nregistro,conselhofiscal,
				conveniada,endereco_id) VALUES(?,?, ?,?,?,?,?,?,?)");
                $pstmt->execute(array($empresa->get_cnpj(), $empresa->get_nome(), $empresa->get_razao_social(), $empresa->get_fax()
                    , $empresa->get_telefone(), $empresa->get_nregistro(), $empresa->get_conselhofiscal(), false, $endereco->getid()));

                $pstmt = $this->conn->prepare("INSERT INTO responsavel (email, nome, telefone, cargo, empresa_cnpj,aprovado) values(? ,?,?,?,?,?)");
                $pstmt->execute(array($responsavel->get_email(), $responsavel->get_nome(), $responsavel->get_cargo(), $empresa->get_cnpj(), false));

                $pstmt = $this->conn->prepare("INSERT INTO supervisor (nome, cargo, habilitacao, empresa_cnpj) VALUES(?,?, ?,?)");
                $pstmt->execute(array($supervisor->get_nome(), $supervisor->get_cargo(), $supervisor->get_habilitacao(), $empresa->get_cnpj()));
                $supervisor->set_id($this->conn->lastInsertId());

                $pstmt = $this->conn->prepare("INSERT INTO supervisiona (estagio_id,supervisor_id) VALUES(?,?)");
                $pstmt->execute(array($supervisor->get_id, $supervisor->get_estagio()));

                $pstmt = $this->conn->prepare("INSERT INTO plano_estagio (estagio_id,setor_unidade,data_ini, data_fim, atividades,hora_inicio1,
				 hora_fim1, total_horas, empresa_cnpj) VALUES(?,?, ?,?,?,?,?,?,?)");
                $pstmt->execute(array($planoDeEstagio->get_estagio(), $planoDeEstagio->get_setor_unidade(), $planoDeEstagio->get_data_inicio(), $planoDeEstagio->get_data_fim(), $planoDeEstagio->get_atividades, $planoDeEstagio->get_hora_inicio1(), $planoDeEstagio->get_data_fim1(), $planoDeEstagio->get_total_horas(), $empresa->get_cnpj()));
                $this->conn->commit();
            } catch (PDOException $e) {
                $this->conn->rollback();
                return false;
            }
        } else {
            try {

                $this->conn->beginTransaction();
                $pstmt = $this->conn->prepare("INSERT INTO supervisor (nome, cargo, habilitacao, empresa_cnpj) VALUES(?,?, ?,?)");
                $pstmt->execute(array($supervisor->get_nome(), $supervisor->get_cargo(), $supervisor->get_habilitacao(), $empresa->get_cnpj()));
                $supervisor->set_id($this->conn->lastInsertId());

                $pstmt = $this->conn->prepare("INSERT INTO supervisiona (estagio_id,supervisor_id) VALUES(?,?)");
                $pstmt->execute(array($supervisor->get_id, $planoDeEstagio->get_estagio()));

                $pstmt = $this->conn->prepare("INSERT INTO plano_estagio (estagio_id,setor_unidade,data_ini, data_fim, atividades,hora_inicio1,
				 hora_fim1, total_horas, empresa_cnpj) VALUES(?,?, ?,?,?,?,?,?,?)");
                $pstmt->execute(array($planoDeEstagio->get_estagio(), $planoDeEstagio->get_setor_unidade(), $planoDeEstagio->get_data_inicio(), $planoDeEstagio->get_data_fim(), $planoDeEstagio->get_atividades, $planoDeEstagio->get_hora_inicio1(), $planoDeEstagio->get_data_fim1(), $planoDeEstagio->get_total_horas(), $empresa->get_cnpj()));
                $this->conn->commit();
                return true;
            } catch (PDOException $e) {
                $this->conn->rollback();
                return false;
            }
        }
    }

    public function create(Estagio $estagio) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (bool_aprovado, bool_obrigatorio, periodo, serie, modulo, integ_ano, integ_semestre, dependencias, justificativa, endereco_tc, enderece_pe, horas_contabilizadas, aluno_cpf, empresa_cnpj, aluno_estuda_curso_matricula, po_siape, status_codigo) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array((int) $estagio->getaprovado(), (int) $estagio->getobrigatorio(), $estagio->getperiodo(), $estagio->getserie(), $estagio->getmodulo(), $estagio->getano(), $estagio->getsemestre(), $estagio->getdependencias(), $estagio->getjustificativa(), $estagio->getendereco_tc(), $estagio->getendereco_pe(), $estagio->gethoras_contabilizadas(), $estagio->getaluno()->getcpf(), $estagio->getempresa()->getcnpj(), $estagio->getmatricula()->getid(), $estagio->getfuncionario()->getsiape(), $estagio->getstatus()->getcodigo()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            $estagio->setid($id);
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

//    public function getpo(Estagio $estagio) {
//        if ($id != NULL) {
//            $pstmt = $this->conn->prepare("SELECT * FROM funcionario WHERE   LIMIT 1");
//            try {
//                $this->conn->beginTransaction();
//                $pstmt->execute();
//                $this->conn->commit();
//                $cont = 0;
//                $result = [];
//                while ($row = $pstmt->fetch()) {
//                    $apoliceModel = $this->loader->loadModel("ApoliceModel", "ApoliceModel");
//                    $supervisorModel = $this->loader->loadModel("SupervisorModel", "SupervisorModel");
//                    $empresaModel = $this->loader->loadModel("EmpresaModel", "EmpresaModel");
//                    $alunoModel = $this->loader->loadModel("AlunoModel", "AlunoModel");
//                    $funcionarioModel = $this->loader->loadModel("FuncionarioModel", "FuncionarioModel");
//                    $matriculaModel = $this->loader->loadModel("MatriculaModel", "MatriculaModel");
//                    $statusModel = $this->loader->loadModel("StatusModel", "StatusModel");
//                    $planodeestagioModel = $this->loader->loadModel("PlanoDeEstagioModel", "PlanoDeEstagioModel");
//                    $result[$cont] = new Estagio($row["id"], boolval($row["bool_aprovado"]), boolval($row["bool_obrigatorio"]), null, null, $row["periodo"], $row["serie"], $row["modulo"], $row["integ_ano"], $row["integ_semestre"], $row["dependencias"], $row["justificativa"], $row["endereco_tc"], $row["endereco_pe"], $empresaModel->read($row["empresa_cnpj"], 1)[0], $alunoModel->read($row["aluno_cpf"], 1)[0], $funcionarioModel->read($row["po_siape"], 1)[0], $matriculaModel->read($row["aluno_estuda_curso_matricula"], 1)[0], $statusModel->read($row["status_codigo"], 1)[0], null);
//                    $result[$cont]->setapolice($apoliceModel->readbyestagio($result[$cont], 1)[0]);
//                    $result[$cont]->setpe($planodeestagioModel->read($result[$cont], 1)[0]);
//                    $result[$cont]->setsupervisor($supervisorModel->read($result[$cont]->getempresa()->getcnpj(), 1)[0]);
//                    $cont++;
//                }
//                return $result;
//            } catch (PDOExecption $e) {
//                #return "Error!: " . $e->getMessage() . "</br>";
//                return 2;
//            }
//        } else {
//            return NULL;
//        }
//    }

    public function read($id, $limite) {
        if ($limite == 0) {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " ORDER BY status_codigo ASC");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id ORDER BY status_codigo ASC");
                $pstmt->bindParam(':id', $id);
            }
        } else {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " ORDER BY status_codigo ASC LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id ORDER BY status_codigo ASC LIMIT :limite");
                $pstmt->bindParam(':id', $id);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $this->conn->beginTransaction();
            $pstmt->execute();
            $this->conn->commit();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $apoliceModel = $this->loader->loadModel("ApoliceModel", "ApoliceModel");
                $supervisorModel = $this->loader->loadModel("SupervisorModel", "SupervisorModel");
                $empresaModel = $this->loader->loadModel("EmpresaModel", "EmpresaModel");
                $alunoModel = $this->loader->loadModel("AlunoModel", "AlunoModel");
                $funcionarioModel = $this->loader->loadModel("FuncionarioModel", "FuncionarioModel");
                $matriculaModel = $this->loader->loadModel("MatriculaModel", "MatriculaModel");
                $statusModel = $this->loader->loadModel("StatusModel", "StatusModel");
                $planodeestagioModel = $this->loader->loadModel("PlanoDeEstagioModel", "PlanoDeEstagioModel");
                $result[$cont] = new Estagio($row["id"], boolval($row["bool_aprovado"]), boolval($row["bool_obrigatorio"]), null, null, $row["periodo"], $row["serie"], $row["modulo"], $row["integ_ano"], $row["integ_semestre"], $row["dependencias"], $row["justificativa"], $row["endereco_tc"], $row["endereco_pe"], $empresaModel->read($row["empresa_cnpj"], 1)[0], $alunoModel->read($row["aluno_cpf"], 1)[0], $funcionarioModel->read($row["po_siape"], 1)[0], $matriculaModel->read($row["aluno_estuda_curso_matricula"], 1)[0], $statusModel->read($row["status_codigo"], 1)[0], null);
                $result[$cont]->sethoras_contabilizadas($row["horas_contabilizadas"]);
                $result[$cont]->setapolice($apoliceModel->readbyestagio($result[$cont], 1)[0]);
                $result[$cont]->setpe($planodeestagioModel->read($result[$cont], 1)[0]);
                $result[$cont]->setsupervisor($supervisorModel->read($result[$cont]->getempresa()->getcnpj(), 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }


    public function submeterrelatorio($id, $arquivo,$usuario){
            $statusModel = $this->loader->loadModel('StatusModel', 'StatusModel');
            $estagio = new Estagio($id,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $pstmt = $this->conn->prepare("select * from ".$this->_tabela_intermediaria." where estagio_id = ?");
            $pstmt->execute(array($id));
            $res = $pstmt->fetchAll();
            $q = count($res);
            if($q == 1){
                try{
                    $this->conn->beginTransaction();
                    $pstmt = $this->conn->prepare("update  ".$this->_tabela_intermediaria." set conteudo = ?, nome = ? , tipo = ?, data_envio = now() where id = ?");
                    $pstmt->execute(array($arquivo->get_conteudo(),$arquivo->get_nome(),$arquivo->get_tipo(),$id));
                    $statusModel->adicionaNotificacao(StatusModel::$AGURDANDO_REL,$estagio, $usuario);
                    $this->conn->commit();
                    return true;  
                }catch(PDOExecption $e){
                    $this->conn->rollback();
                    return false;
                }
            }else{
                try{      
                    $this->conn->beginTransaction();
                    $pstmt = $this->conn->prepare("insert into ".$this->_tabela_intermediaria." (conteudo, tipo, nome, data_envio,estagio_id) value (?,?,?,NOW(),?)");
                    $pstmt->execute(array($arquivo->get_conteudo(),$arquivo->get_tipo(),$arquivo->get_nome(),$id));
                    $statusModel->adicionaNotificacao(StatusModel::$AGURDANDO_REL,$estagio, $usuario);
                    
                    $pstmt = $this->conn->prepare("update ".$this->_tabela." set status_codigo = ? where id = ?");
                    $pstmt->execute(array(StatusModel::$AGURDANDO_REL, $id));
                    
                    
                    $this->conn->commit();
                    return true;  
                }catch(PDOExecption $e){
                    $this->conn->rollback();
                    return false;
                }
            }
    }



    public function readbyaluno(Aluno $aluno, $limite) {
        if ($limite == 0) {
            if ($aluno == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " ORDER BY status_codigo ASC");
            } else {
                $key = $aluno->getcpf();
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE aluno_cpf = :aluno_cpf ORDER BY status_codigo ASC");
                $pstmt->bindParam(':aluno_cpf', $key);
            }
        } else {
            if ($aluno == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite ORDER BY status_codigo ASC");
            } else {
                $key = $aluno->getcpf();
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE aluno_cpf = :aluno_cpf LIMIT :limite ORDER BY status_codigo ASC");
                $pstmt->bindParam(':aluno_cpf', $key);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $this->conn->beginTransaction();
            $pstmt->execute();
            $this->conn->commit();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $apoliceModel = $this->loader->loadModel("ApoliceModel", "ApoliceModel");
                $supervisorModel = $this->loader->loadModel("SupervisorModel", "SupervisorModel");
                $empresaModel = $this->loader->loadModel("EmpresaModel", "EmpresaModel");
                $funcionarioModel = $this->loader->loadModel("FuncionarioModel", "FuncionarioModel");
                $matriculaModel = $this->loader->loadModel("MatriculaModel", "MatriculaModel");
                $statusModel = $this->loader->loadModel("StatusModel", "StatusModel");
                $planodeestagioModel = $this->loader->loadModel("PlanoDeEstagioModel", "PlanoDeEstagioModel");
                $result[$cont] = new Estagio($row["id"], boolval($row["bool_aprovado"]), boolval($row["bool_obrigatorio"]), null, null, $row["periodo"], $row["serie"], $row["modulo"], $row["integ_ano"], $row["integ_semestre"], $row["dependencias"], $row["justificativa"], $row["endereco_tc"], $row["endereco_pe"], $empresaModel->read($row["empresa_cnpj"], 1)[0], $aluno, $funcionarioModel->read($row["po_siape"], 1)[0], $matriculaModel->read($row["aluno_estuda_curso_matricula"], 1)[0], $statusModel->read($row["status_codigo"], 1)[0], null);
                $result[$cont]->sethoras_contabilizadas($row["horas_contabilizadas"]);
                $result[$cont]->setapolice($apoliceModel->readbyestagio($result[$cont], 1)[0]);
                $result[$cont]->setpe($planodeestagioModel->read($result[$cont], 1)[0]);
                $result[$cont]->setsupervisor($supervisorModel->read($result[$cont]->getempresa()->getcnpj(), 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Estagio $estagio) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET bool_aprovado = ? , bool_obrigatorio = ? , periodo = ? , serie = ? , modulo = ? , integ_ano = ? , integ_semestre = ? , dependencias = ? , justificativa = ? , endereco_tc = ? , endereco_pe = ? , horas_contabilizadas = ? , aluno_cpf = ? , empresa_cnpj = ? , aluno_estuda_curso_matricula = ? , po_siape = ? , status_codigo = ? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array((int) $estagio->getaprovado(), (int) $estagio->getobrigatorio(), $estagio->getperiodo(), $estagio->getserie(), $estagio->getmodulo(), $estagio->getano(), $estagio->getsemestre(), $estagio->getdependencias(), $estagio->getjustificativa(), $estagio->getendereco_tc(), $estagio->getendereco_pe(), $estagio->gethoras_contabilizadas(), $estagio->getaluno()->getcpf(), $estagio->getempresa()->getcnpj(), $estagio->getmatricula()->getmatricula(), $estagio->getfuncionario()->getsiape(), $estagio->getstatus()->getcodigo(), $estagio->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Estagio $estagio) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->_tabela . " WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($estagio->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function buscarPorEmpresa($empresaCnpj){
		try{
			return $this->mread(array('empresa_cnpj' => $empresaCnpj));
		}catch(PDOException $ex){
			return false;
		}
	}

	private function mread($fields){
		//TODO: carregando apenas o estágio, editar para carrear tabelas associadas

		$query = "SELECT * FROM estagio WHERE";

		foreach($fields as $column => $value){
			$query = $query . ' ' . $column . ' = ' . $value;
		}

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$response = $stmt->fetchAll();

		if(count($response) == 0)
			return false;
		
		$estagios = array();
		foreach($response as $res){
			$estagio = new Estagio($res['id'], $res['bool_aprovado'], $res['bool_obrigatorio'], null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
			$estagios[] = $estagio;
		}

		return $estagios;
    }
/*
    $pstmt->execute(array($planoDeEstagio->get_estagio(),$planoDeEstagio->get_setor_unidade(),$planoDeEstagio->get_data_inicio(),$planoDeEstagio->get_data_fim(),$planoDeEstagio->get_atividades,$planoDeEstagio->get_hora_inicio1(),$planoDeEstagio->get_data_fim1(),$planoDeEstagio->get_total_horas(),$empresa->get_cnpj()));
				$this->conn->commit();
				return true;
			} catch (PDOException $e) {
				$this->conn->rollback();
				return false;
			}	
		}
	}
*/

	public function preCadastrarEstagio($estagio){
		try{
			$this->conn->beginTransaction();
			$stmt = $this->conn->prepare("INSERT INTO estagio(bool_aprovado, bool_obrigatorio, aluno_cpf, curso_id) VALUES(?, ?, ?, ?)");
			$stmt->execute(array(0, $estagio->getobrigatorio(), $estagio->getaluno()->getcpf(), $estagio->getcurso()->getid()));
			$this->conn->commit();
			return true;
		}catch(PDOException $ex){
            $this->conn->rollback();
            return false;
		}
	}

	public function salvar($estagio)
	{
		try{
			$this->conn->beginTransaction();
			$pstmt = $this->conn->prepare("INSERT INTO estagio (aprovado, obrigatorio, periodo, serie, modulo, ano, semestre, dependencias, justificativa, endereco_tc, endereco_pe, empresa_cnpj, aluno_cpf, po_siape, curso_id, status_codigo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$pstmt->execute(array($estagio->getaprovado(), $estagio->getobrigatorio(), $estagio->getperiodo(), $estagio->getserie(), $estagio->getmodulo(), $estagio->getano(), $estagio->getsemestre(), $estagio->getdependencias(), $estagio->getjustificativa(), $estagio->getendereco_tc(), $estagio->getendereco_pe(), $estagio->getempresa()->getcnpj(), $estagio->getaluno()->getcpf(), $estagio->getfuncionario()->getsiape(), $estagio->getcurso()->getid(), $estagio->getstatus()->getcodigo()));
			$this->conn->commit();
		} catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
	}
}
