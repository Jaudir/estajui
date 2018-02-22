<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Apolice.php";

class ApoliceModel extends MainModel {

    private $_tabela = "apolice";

    public function create(Apolice $apolice, $estagio_id) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (numero, estagio_id, segurador) VALUES(?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($apolice->getnumerot(), $estagio_id, $apolice->getseguradora()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($numero) {
        if ($limite == 0) {
            if ($numero == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE numero LIKE :numero");
                $pstmt->bindParam(':numero', $numero);
            }
        } else {
            if ($numero == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE numero LIKE :numero LIMIT :limite");
                $pstmt->bindParam(':numero', $numero);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $result[$cont] = new Apolice($row["numero"], $row["seguradora"]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyestagio($estagio_id) {
        if ($limite == 0) {
            if ($estagio_id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id LIKE :estagio_id");
                $pstmt->bindParam(':estagio_id', $estagio_id);
            }
        } else {
            if ($estagio_id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE estagio_id LIKE :estagio_id LIMIT :limite");
                $pstmt->bindParam(':estagio_id', $estagio_id);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $result[$cont] = new Apolice($row["numero"], $row["seguradora"]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Apolice $apolice) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET numero=?, seguradora=? WHERE numero = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($apolice->getnumero(), $apolice->getseguradora(), $apolice->getnumero()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Apolice $apolice) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE numero LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($apolice->getnumero()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
