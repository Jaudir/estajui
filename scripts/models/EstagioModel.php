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
			."JOIN estagio AS es ON p.estagio_id = es.id "
			."JOIN supervisiona AS sona ON es.id = sona.estagio_id "
			."JOIN supervisor AS sor ON sona.supervisor_id = sor.id "
			."JOIN apolice AS ap ON es.id = ap.estagio_id "
			."JOIN funcionario AS f ON es.po_siape = f.siape "
			."JOIN empresa AS em ON es.empresa_cnpj = em.cnpj "
			."JOIN endereco AS en ON em.endereco_id = en.id "
			."JOIN status AS s ON es.status_codigo = s.codigo "
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
			$endereco = new Endereco(null, $res['logradouro'], $res['bairro'], $res['en_numero'], null, $res['cidade'], $res['uf'], $res['cep'],null);
			$empresa = new Empresa($res['cnpj'], $res['em_nome'], $res['telefone'], $res['fax'], $res['nregistro'], $res['conselhofiscal'], $endereco, null);
			$planoDeEstagio = new PlanoDeEstagio(null, null, $res['atividades'], null, null, $res['data_ini'], $res['data_fim'], $res['hora_inicio1'], $res['hora_inicio2'], $res['hora_fim1'], $res['hora_fim2'], $res['total_horas'], null, null);
			$supervisor = new Supervisor(null, $res['sor_nome'], $res['cargo'], $res['habilitacao'], null);
			$estagio = new Estagio(null, $res['bool_aprovado'], $res['bool_obrigatorio'], null, null, null, null, null, null, null, null, null, $empresa, null, $funcionario, null, $status, $planoDeEstagio);
			$estagio->setapolice($apolice);
			$estagio->setsupervisor($supervisor);
			return $estagio;
		} catch (PDOException $e) {
			Log::logPDOError($e, true);
			$this->conn->rollback();
			echo "deu ruim 2";
			return false;
		}
	}
	public function cadastrarDadosEstagioeEmpresa($supervisor, $estagio, $planoDeEstagio,$empresa){
        try {
            $this->conn->beginTransaction();
            $pstmt = $this->conn->prepare("INSERT INTO ".$supervisor.get_tabela()." (nome, cargo, habilitacao, empresa_cnpj) VALUES(?,?, ?,?)");
			$pstmt->execute(array($supervisor->get_nome(),$supervisor->get_cargo(),$supervisor->get_habilitacao(),$supervisor->get_empresa()));
			$supervisor->set_id($this->conn->lastInsertId());
			$pstmt = $this->conn->prepare("INSERT INTO ".$planoDeEstagio.get_tabela()." (estagio_id,setor_unidade,data_ini, data_fim, atividades,hora_inicio1, hora_fim1, total_horas, empresa_cnpj) VALUES(?,?, ?,?)");
			$pstmt->execute(array($estagio->get_id(),$planoDeEstagio->get_setor_unidade(),$planoDeEstagio->get_data_inicio(),$planoDeEstagio->get_data_fim(),$planoDeEstagio->get_atividades,$planoDeEstagio->get_hora_inicio1(),$planoDeEstagio->get_data_fim1(),$planoDeEstagio->get_total_horas(),$empresa->get_id()));
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollback();
            return false;
        }	
	}	 	
}