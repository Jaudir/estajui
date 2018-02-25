<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/ComentarioRelatorio.php";

class ComentarioRelatorioModel extends MainModel {

    private $_tabela = "comentario_relatorio";

    public function create(ComentarioRelatorio $comentario, $relatorio_id) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (data, descricao, relatorio_id, po_siape) VALUES(?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($comentario->getdata(), $comentario->getdescricao(), $relatorio_id, $comentario->getfuncionario()->getsiape()));
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
                $result[$cont] = new ComentarioRelatorio($row["id"], $row["data"], $row["descricao"], $funcionarioModel->read($row["po_siape"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyrelatorio(Relatorio $relatorio, $limite) {
        if ($limite == 0) {
            if ($relatorio == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE relatorio_id = :relatorio_id");
                $pstmt->bindParam(':relatorio_id', $relatorio->getid());
            }
        } else {
            if ($relatorio == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE relatorio_id = :relatorio_id LIMIT :limite");
                $pstmt->bindParam(':relatorio_id', $relatorio->getid());
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
                $result[$cont] = new ComentarioPE($row["id"], $row["data"], $row["descricao"], $row["endereco_correcao"], $funcionarioModel->read($row["po_siape"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyfuncionario(Funcionario $funcionario, $limite) {
        if ($limite == 0) {
            if ($funcionario == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE po_siape = :po_siape");
                $pstmt->bindParam(':po_siape', $funcionario->getsiape());
            }
        } else {
            if ($funcionario == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE po_siape = :po_siape LIMIT :limite");
                $pstmt->bindParam(':po_siape', $funcionario->getsiape());
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
                $result[$cont] = new ComentarioRelatorio($row["id"], $row["data"], $row["descricao"], $funcionario);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(ComentarioRelatorio $comentario) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET id=?, data=?, descricao=?, po_siape=? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($comentario->getid(), $comentario->getdata(), $comentario->getdescricao(), $comentario->getfuncionario()->getsiape(), $comentario->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(ComentarioRelatorio $comentario) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($comentario->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
