<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Campus.php";

class CampusModel extends MainModel {

    private $_tabela = "campus";

    public function create(Campus $campus) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (cnpj, telefone, endereco_id) VALUES(?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($campus->getcnpj(), $campus->gettelefone(), $campus->getendereco()->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($cnpj, $limite) {
        if ($limite == 0) {
            if ($cnpj == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE cnpj LIKE :cnpj");
                $pstmt->bindParam(':cnpj', $cnpj);
            }
        } else {
            if ($cnpj == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE cnpj LIKE :cnpj LIMIT :limite");
                $pstmt->bindParam(':cnpj', $cnpj);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $enderecoModel = $this->loader->loadModel("EnderecoModel", "EnderecoModel");
                $result[$cont] = new Campus($row["cnpj"], $row["telefone"], $enderecoModel->read($row["endereco_id"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 1;
        }
    }

    public function update(Campus $campus) {
            $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET cnpj=?, telefone=?, endereco_id=? WHERE cnpj = ?");
            try {
                $this->conn->beginTransaction();
                $pstmt->execute(array($campus->getcnpj(), $campus->gettelefone(), $campus->getendereco()->getid(), $campus->getcnpj()));
                $this->conn->commit();
                return 0;
            } catch (PDOExecption $e) {
                $this->conn->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return 2;
            }
    }

    public function delete(Campus $campus) {
            $pstmt = $this->conn->prepare("DELETE from " . $this->_tabela . " WHERE cnpj LIKE ?");
            try {
                $this->conn->beginTransaction();
                $pstmt->execute(array($campus->getcnpj()));
                $this->conn->commit();
                $enderecoModel = $this->loader->loadModel("EnderecoModel", "EnderecoModel");
                return $enderecoModel->delete($campus->getendereco());
            } catch (PDOExecption $e) {
                $this->conn->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return 1;
            }
    }

}
