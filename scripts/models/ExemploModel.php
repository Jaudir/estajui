<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/dao.php";

class DaoModel extends MainModel {

    private $_tabela = "tabela";

    public function create($dao) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (valor1, valor2) VALUES(?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($dao->valor1(), $dao->valor2()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            return $id;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($chave, $limite) {
        if ($limite == 0) {
            if ($chave == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE chave LIKE :chave");
                $pstmt->bindParam(':chave', $chave);
            }
        } else {
            if ($chave == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE chave LIKE :chave LIMIT :limite");
                $pstmt->bindParam(':chave', $chave);
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
                $result[$cont] = new Dao($row["valor1"], $row["valor2"]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update($dao) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET valor1=?, valor2=? WHERE valor1 = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($dao->valor1(), $dao->valor2(), $dao->valor1()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete($dao) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE valor1 LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($dao->valor1()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
