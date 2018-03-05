<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Supervisor.php";

class SupervisorModel extends MainModel {

    private $_tabela = "supervisor";

    public function create(Supervisor $supervisor) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (nome, cargo, habilitacao, empresa_cnpj) VALUES(?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($supervisor->getnome(), $supervisor->getcargo(), $supervisor->gethabilitacao(), $supervisor->getempresa()->getcnpj()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            $supervisor->setid($id);
            return 0;
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
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id");
                $pstmt->bindParam(':id', $id);
            }
        } else {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id LIMIT :limite");
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
                $empresaModel = $this->loader->loadModel("EmpresaModel", "EmpresaModel");
                $result[$cont] = new Supervisor($row["id"], $row["nome"], $row["cargo"], $row["habilitacao"], $empresaModel->read($row["empresa_cnpj"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyempresa(Empresa $empresa, $limite) {
        if ($limite == 0) {
            if ($empresa == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE empresa_cnpj = :empresa_cnpj");
                $pstmt->bindParam(':empresa_cnpj', $empresa->getcnpj());
            }
        } else {
            if ($empresa == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE empresa_cnpj = :empresa_cnpj LIMIT :limite");
                $pstmt->bindParam(':empresa_cnpj', $empresa->getcnpj());
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
                $result[$cont] = new Supervisor($row["id"], $row["nome"], $row["cargo"], $row["habilitacao"], $empresa);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Supervisor $supervisor) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET nome=?, cargo=?, habilitacao=?, empresa_cnpj=? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($supervisor->getnome(), $supervisor->getcargo(), $supervisor->gethabilitação(), $supervisor->getempresa()->getcnpj, $supervisor->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Supervisor $supervisor) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($supervisor->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
