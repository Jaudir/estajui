<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Status.php";

class StatusModel extends MainModel {

    private $_tabela = "status";

    public function create(Status $status) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (descricao, bitmap_usuarios_alvo) VALUES(?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($status->getdescricao(), $status->get_usuarios_alvo()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            return $id;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($codigo, $limite) {
        if ($limite == 0) {
            if ($codigo == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE codigo LIKE :codigo");
                $pstmt->bindParam(':codigo', $codigo);
            }
        } else {
            if ($codigo == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE codigo LIKE :codigo LIMIT :limite");
                $pstmt->bindParam(':codigo', $codigo);
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
                $result[$cont] = new Status($row["codigo"], $row["descricao"], $row["bitmap_usuarios_alvos"]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Status $status) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET descricao=?, bitmap_usuarios_alvo=? WHERE codigo = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($status->getdescricao(), $status->get_usuarios_alvo(), $status->getcodigo()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Status $status) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE codigo = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($status->getcodigo()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
