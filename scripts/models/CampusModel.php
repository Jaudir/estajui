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

    public function cadastrar($campus)
    {
        try {
            $this->conn->beginTransaction();
			
            $pstmt = $this->conn->prepare("INSERT INTO endereco (logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(?, ?, ?, ?, ?, ?, ?)");
            $pstmt->execute(array($campus->getendereco()->getlogradouro(), $campus->getendereco()>getbairro(), $campus->getendereco()->getnumero(), $campus->getendereco()->getcomplemento(), $campus->getendereco()->getcidade(), $campus->getendereco()->getuf(), $campus->getendereco()->getcep()));
			
			$pstmt = $this->conn->prepare("INSERT INTO campus (cnpj, telefone, endereco_id) VALUES(?, ?, ?)");
            $pstmt->execute(array($campus->getcnpj(),$campus->gettelefone(),$this->conn->lastInsertId()));

            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }

	public function recuperar($campus)
	{
		try {
            $pstmt = $this->conn->prepare("SELECT * FROM campus JOIN endereco ON endereco.id=campus.endereco_id WHERE campus.cnpj=?");
            $pstmt->execute($campus->getcnpj());
			$res = $pstmt->fetchAll();
			
			if(count($res)==0)
				return false;
			
			$endereco = new Endereco($res['id'], $res['logradouro'], $res['bairro'], $res['numero'], $res['complemento'], $res['cidade'], $res['uf'], $res['cep']);
			$campus = new Campus($res['cnpj'], $res['telefone'], $endereco);
			
			return $campus;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }	
	}
	
	public function recuperarTodos(){
		try{
			$pstmt = $this->conn->prepare("SELECT * FROM campus JOIN endereco ON campus.endereco_id=endereco.id");
			$pstmt->execute();
			$res = $pstmt->fetchAll();
			
			$campi = array();
			foreach($res as $campus){
				$endereco = new Endereco($campus['id'], $campus['logradouro'], $campus['bairro'], $campus['numero'], $campus['complemento'], $campus['cidade'], $campus['uf'], $campus['cep'], $campus['sala']);
				$c = new Campus($campus['cnpj'], $campus['telefone'], $endereco);
				array_push($campi, $c);
			}
			
			return $campi;
		} catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }	
	}
}
