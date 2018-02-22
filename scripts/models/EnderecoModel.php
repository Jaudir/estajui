<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Endereco.php";

class EnderecoModel extends MainModel {

    private $_tabela = "endereco";

    public function create(Endereco $endereco) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($endereco->getlogradouro(), $endereco->getbairro(), $endereco->getnumero(), $endereco->getcomplemento(), $endereco->getcidade(), $endereco->getuf(), $endereco->getcep()));
            $this->conn->commit();
            $endereco->setid($this->conn->lastInsertId());
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
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $result[$cont] = new Endereco($row["id"], $row["logradouro"], $row["bairro"], $row["numero"], $row["complemento"], $row["cidade"], $row["uf"], $row["cep"]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Endereco $endereco) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET logradouro=?, bairro=?, numero=?, complemento=?, cidade=?, uf=?, cep=? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($endereco->getlogradouro(), $endereco->getbairro(), $endereco->getnumero(), $endereco->getcomplemento(), $endereco->getcidade(), $endereco->getuf(), $endereco->getcep(), $endereco->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Endereco $endereco) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->_tabela . " WHERE id LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($endereco->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
