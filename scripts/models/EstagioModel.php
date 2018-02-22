<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Estagio.php";

class EstagioModel extends MainModel {

    private $_tabela = "estagio";

    public function create(Estagio $estagio) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (bool_aprovado, bool_obrigatorio, periodo, serie, modulo, integ_ano, integ_semestre, dependencias, justificativa, endereco_tc, enderece_pe, aluno_cpf, empresa_cnpj, curso_id, po_siape, status_codigo) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array((int)$estagio->getaprovado(), (int)$estagio->getobrigatorio(), $estagio->getperiodo(), $estagio->getserie(), $estagio->getmodulo(), $estagio->getano(), $estagio->getsemestre(), $estagio->getdependencias(), $estagio->getjustificativa(), $estagio->getendereco_tc(), $estagio->getendereco_pe(), $estagio->getaluno()->getcpf(), $estagio->getempresa()->getcnpj(), $estagio->getcurso()->getid(), $estagio->getfuncionario()->getsiape(), $estagio->getstatus()->getcodigo()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            return $id;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($id, $limite) {
        if ($limite == 0) {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id LIKE :id");
                $pstmt->bindParam(':id', $id);
            }
        } else {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id LIKE :id LIMIT :limite");
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
                $cursoModel = $this->loader->loadModel("CursoModel", "CursoModel");
                $statusModel = $this->loader->loadModel("StatusModel", "StatusModel");
                $planodeestagioModel = $this->loader->loadModel("PlanoDeEstagioModel", "PlanoDeEstagioModel");
                $result[$cont] = new Estagio($row["id"], boolval($row["bool_aprovado"]), boolval($row["bool_obrigatorio"]), null, null, $row["periodo"], $row["serie"], $row["modulo"], $row["integ_ano"], $row["integ_semestre"], $row["dependencias"], $row["justificativa"], $row["endereco_tc"], $row["endereco_pe"], $empresaModel->read($row["empresa_cnpj"], 1)[0], $alunoModel->read($row["aluno_cpf"],1)[0], $funcionarioModel->read($row["po_siape"], 1)[0], $cursoModel->read($row["curso_id"],1)[0], $statusModel->read($row["status_codigo"],1)[0], null);
                $result[$cont]->setapolice($apoliceModel->readbyestagio($result[$cont],1)[0]);
                $result[$cont]->setpe($planodeestagioModel->read($result[$cont],1)[0]);
                $result[$cont]->setsupervisor($supervisorModel->read($result[$cont]->getempresa(),1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Estagio $estagio) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET bool_aprovado = ? , bool_obrigatorio = ? , periodo = ? , serie = ? , modulo = ? , integ_ano = ? , integ_semestre = ? , dependencias = ? , justificativa = ? , endereco_tc = ? , enderece_pe = ? , aluno_cpf = ? , empresa_cnpj = ? , curso_id = ? , po_siape = ? , status_codigo = ? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array((int)$estagio->getaprovado(), (int)$estagio->getobrigatorio(), $estagio->getperiodo(), $estagio->getserie(), $estagio->getmodulo(), $estagio->getano(), $estagio->getsemestre(), $estagio->getdependencias(), $estagio->getjustificativa(), $estagio->getendereco_tc(), $estagio->getendereco_pe(), $estagio->getaluno()->getcpf(), $estagio->getempresa()->getcnpj(), $estagio->getcurso()->getid(), $estagio->getfuncionario()->getsiape(), $estagio->getstatus()->getcodigo(), $estagio->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Estagio $estagio) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id = ?");
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

}
