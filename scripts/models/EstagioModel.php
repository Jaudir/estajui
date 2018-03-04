<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Estagio.php";

class EstagioModel extends MainModel {

    private $_tabela = "estagio";	


	public function recuperar($estagio_id) {
		try {
			$pstmt = $this->conn->prepare("SELECT es.bool_aprovado, es.bool_obrigatorio, s.descricao, ap.numero AS ap_numero, ap.seguradora, "
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
			$funcionario = new Funcionario(null, null, null, null, $res['f_nome'], null, null, null, null, null, $res['formacao'], null, null);
			$apolice = new Apolice($res['ap_numero'], $res['seguradora'], null);
			$status = new Status(null, $res['descricao']);
			$datateste = $res['data_ini'];
			$endereco = new Endereco(null, $res['logradouro'], $res['bairro'], $res['en_numero'], null, $res['cidade'], $res['uf'], $res['cep'],$null);
			$empresa = new Empresa($res['cnpj'], $res['em_nome'], $res['telefone'], $res['fax'], $res['nregistro'], $res['conselhofiscal'], $endereco, null);
			$planoDeEstagio = new PlanoDeEstagio(null, null, $res['atividades'], null, null, $res['data_ini'], $res['data_fim'], $res['hora_inicio1'], $res['hora_inicio2'], $res['hora_fim1'], $res['hora_fim2'], $res['total_horas'], null, null);
			$supervisor = new Supervisor(null, $res['sor_nome'], $res['cargo'], $res['habilitacao'], null);
			$estagio = new Estagio(null, $res['bool_aprovado'], $res['bool_obrigatorio'], null, null, null, null, null, null, null, null, null, $empresa, null, $funcionario, null, $status, $planoDeEstagio);
			$estagio->setapolice($apolice);
			$estagio->setsupervisor($supervisor);
			return $estagio;
		} catch (PDOException $e) {
			Log::logPDOError($e, true);
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
				$pstmt->execute(array($empresa->get_cnpj(),$empresa->get_nome(),$empresa->get_razao_social(),$empresa->get_fax()
				,$empresa->get_telefone(),$empresa->get_nregistro(),$empresa->get_conselhofiscal(),false,$endereco->getid()));
				
				$pstmt = $this->conn->prepare("INSERT INTO responsavel (email, nome, telefone, cargo, empresa_cnpj,aprovado) values(? ,?,?,?,?,?)");
				$pstmt->execute(array($responsavel->get_email(), $responsavel->get_nome(), $responsavel->get_cargo(), $empresa->get_cnpj(),false)); 
				
				$pstmt = $this->conn->prepare("INSERT INTO supervisor (nome, cargo, habilitacao, empresa_cnpj) VALUES(?,?, ?,?)");
				$pstmt->execute(array($supervisor->get_nome(),$supervisor->get_cargo(),$supervisor->get_habilitacao(),$empresa->get_cnpj()));
				$supervisor->set_id($this->conn->lastInsertId());

				$pstmt = $this->conn->prepare("INSERT INTO supervisiona (estagio_id,supervisor_id) VALUES(?,?)");
				$pstmt->execute(array($supervisor->get_id,$supervisor->get_estagio()));
				
				$pstmt = $this->conn->prepare("INSERT INTO plano_estagio (estagio_id,setor_unidade,data_ini, data_fim, atividades,hora_inicio1,
				 hora_fim1, total_horas, empresa_cnpj) VALUES(?,?, ?,?,?,?,?,?,?)");
				$pstmt->execute(array($planoDeEstagio->get_estagio(),$planoDeEstagio->get_setor_unidade(),$planoDeEstagio->get_data_inicio(),$planoDeEstagio->get_data_fim(),$planoDeEstagio->get_atividades,$planoDeEstagio->get_hora_inicio1(),$planoDeEstagio->get_data_fim1(),$planoDeEstagio->get_total_horas(),$empresa->get_cnpj()));
				$this->conn->commit();
			}catch(PDOException $e){
				$this->conn->rollback();
				return false;
			}
		}else{
			try {
				
				$this->conn->beginTransaction();
				$pstmt = $this->conn->prepare("INSERT INTO supervisor (nome, cargo, habilitacao, empresa_cnpj) VALUES(?,?, ?,?)");
				$pstmt->execute(array($supervisor->get_nome(),$supervisor->get_cargo(),$supervisor->get_habilitacao(),$empresa->get_cnpj()));
				$supervisor->set_id($this->conn->lastInsertId());

				$pstmt = $this->conn->prepare("INSERT INTO supervisiona (estagio_id,supervisor_id) VALUES(?,?)");
				$pstmt->execute(array($supervisor->get_id,$planoDeEstagio->get_estagio()));
				
				$pstmt = $this->conn->prepare("INSERT INTO plano_estagio (estagio_id,setor_unidade,data_ini, data_fim, atividades,hora_inicio1,
				 hora_fim1, total_horas, empresa_cnpj) VALUES(?,?, ?,?,?,?,?,?,?)");
				$pstmt->execute(array($planoDeEstagio->get_estagio(),$planoDeEstagio->get_setor_unidade(),$planoDeEstagio->get_data_inicio(),$planoDeEstagio->get_data_fim(),$planoDeEstagio->get_atividades,$planoDeEstagio->get_hora_inicio1(),$planoDeEstagio->get_data_fim1(),$planoDeEstagio->get_total_horas(),$empresa->get_cnpj()));
				$this->conn->commit();
				return true;
			} catch (PDOException $e) {
				$this->conn->rollback();
				return false;
			}	
		}
	}	 	
}