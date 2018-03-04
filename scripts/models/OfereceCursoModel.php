<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/OfereceCurso.php";

class OfereceCursoModel extends MainModel {

    private $_tabela = "oferece_curso";

    public function create(OfereceCurso $ofereceCurso) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (turno, curso_id, campus_cnpj, oe_siape) VALUES(?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($ofereceCurso->getturno(), $ofereceCurso->getcurso->getid(), $ofereceCurso->getcampus()->getcnpj(), $ofereceCurso->getfuncionario()->getsiape()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            $ofereceCurso->setid($id);
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
                $funcionarioModel = $this->loader->loadModel("FuncionarioModel", "FuncionarioModel");
                $campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
                $cursoModel = $this->loader->loadModel("CursoModel", "CursoModel");
                $result[$cont] = new OfereceCurso($row["id"], $row["turno"], $cursoModel->read($row["curso_id"], 1)[0], $campusModel->read($row["campus_cnpj"], 1)[0], $funcionarioModel->read($row["oe_siape"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(OfereceCurso $ofereceCurso) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET turno=? , curso_id=? , campus_cnpj=? , oe_siape=? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($ofereceCurso->getturno(), $ofereceCurso->getcurso()->getid(), $ofereceCurso->getcampus()->getcnpj(), $ofereceCurso->getfuncionario()->getsiape(), $ofereceCurso->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(OfereceCurso $ofereceCurso) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($ofereceCurso->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
