<?php

require_once('MainModel.php');

class ModificaStatusModel extends MainModel
{
	public function salvar($modificacao)
	{
		try{
			$this->conn->beginTransaction();
			$pstmt = $this->conn->prepare("INSERT INTO modifica_status (data, status_codigo, usuario_email, estagio_id) VALUES (?,?,?,?)");
			$pstmt->execute(array($modificacao->getdata(), $modificacao->getstatus()->getcodigo(), $modificacao->getusuario()->getemail(), $modificacao->getestagio()->getid()));
			
			$this->conn->commit();
		} catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
	}

}