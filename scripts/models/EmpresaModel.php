<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Empresa.php";

class EmpresaModel extends MainModel {

    private $_tabela = "empresa";

    public function create(Empresa $empresa) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (cnpj, nome, razao_social, telefone, fax, nregistro, conselhofiscal, endereco_id, conveniada) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($empresa->getcnpj(), $empresa->getnome(), $empresa->getrazao_social(), $empresa->gettelefone(), $empresa->getfax(), $empresa->getnregistro(), $empresa->getconselhofiscal(), $empresa->getendereco()->getid(), (int) $empresa->getconveniada()));
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
                $pstmt->bindParam(':chave', $cnpj);
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
                $enderecoModel = $this->loader->loadModel("EnderecoModel", "EnderecoModel");
                $result[$cont] = new Empresa($row["cnpj"], $row["nome"], $row["razao_social"], $row["telefone"], $row["fax"], $row["nregistro"], $row["conselhofiscal"], $enderecoModel->read($row["endereco_id"], 1)[0], boolval($row["conveniada"]));
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Empresa $empresa) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET cnpj=?, nome=?, razao_social=?, telefone=?, fax=?, nregistro=?, conselhofiscal=?, endereco_id=?, conveniada=? WHERE cnpj = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($empresa->getcnpj(), $empresa->getnome(), $empresa->getrazao_social(), $empresa->gettelefone(), $empresa->getfax(), $empresa->getnregistro(), $empresa->getconselhofiscal(), $empresa->getendereco()->getid(), (int) $empresa->getconveniada(), $empresa->getcnpj()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Empresa $empresa) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE cnpj LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($empresa->getcnpj()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
