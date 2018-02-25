<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Responsavel.php";

class ResponsavelModel extends MainModel {

    private $_tabela = "responsavel";

    public function create(Responsavel $reponsavel) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (email, nome, telefone, cargo, empresa_cnpj, aprovado) VALUES(?, ?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($reponsavel->getemail(), $reponsavel->getnome(), $reponsavel->gettelefone(), $reponsavel->getcargo(), $reponsavel->getempresa()->getcnpj(),(int) $reponsavel->getaprovado()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($email, $limite) {
        if ($limite == 0) {
            if ($email == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE email = :email");
                $pstmt->bindParam(':email', $email);
            }
        } else {
            if ($email == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE email = :email LIMIT :limite");
                $pstmt->bindParam(':email', $email);
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
                $result[$cont] = new Responsavel($row["email"], $row["nome"], $row["telefone"], $row["cargo"], $empresaModel->read($row["empresa_cnpj"], 1)[0], boolval($row["aprovado"]));
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
                $result[$cont] = new Responsavel($row["email"], $row["nome"], $row["telefone"], $row["cargo"], $empresa, boolval($row["aprovado"]));
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Responsavel $responsavel) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET email=?, nome=?, telefone=?, cargo=?, empresa_cnpj, aprovado=? WHERE email = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($responsavel->getemail(), $responsavel->getnome(), $responsavel->gettelefone(), $responsavel->getcargo(), $responsavel->getempresa()->getcnpj(), (int) $responsavel->getaprovado()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Responsavel $responsavel) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE email = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($responsavel->getemail()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
