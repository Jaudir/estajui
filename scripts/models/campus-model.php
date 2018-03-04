<?php

require_once('MainModel.php');

class CampusModel extends MainModel
{
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
				$endereco = new Endereco($campus['id'], $campus['logradouro'], $campus['bairro'], $campus['numero'], $campus['complemento'], $campus['cidade'], $campus['uf'], $campus['cep']);
				$c = new Campus($campus['cnpj'], $campus['telefone'], $endereco);
				$campi->array_push($c);
			}
			
			return $campi;
		} catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }	
	}
   
}

