<?php

require_once('MainModel.php');

class CursoModel extends MainModel
{
    public function cadastrar($curso)
    {
        try {
            $this->conn->beginTransaction();
			
            $pstmt = $this->conn->prepare("INSERT INTO curso (nome, campus_id) VALUES(?, ?, ?)");
            $pstmt->execute(array($curso->getnome(), $curso->getcampus()->getid()));

            $this->conn->commit();
            return true;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }
    }

	public function recuperarPorCampus($campus)
	{
		try {
            $pstmt = $this->conn->prepare("SELECT * FROM curso WHERE id=(SELECT curso_id FROM oferece WHERE campus_cnpj=?)");
            $pstmt->execute($campus->getcnpj());
			$res = $pstmt1->fetchAll();
			
			if(count($res)==0)
				return false;
			
			$cursos = array();
			foreach($res as $curso)
				$cursos->array_push(new Curso($curso['id'], $curso['nome'],  $campus));
			
			return $curso;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }	
	}
   
}
