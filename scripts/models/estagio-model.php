<?php

require_once('MainModel.php');

class EstagioModel extends MainModel
{
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