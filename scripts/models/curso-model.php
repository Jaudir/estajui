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
			$this->loader->loadDAO('Curso');
			
            $pstmt = $this->conn->prepare("SELECT curso.id, nome FROM curso JOIN oferece_curso ON oferece_curso.curso_id=curso.id WHERE campus_cnpj=?");
            $pstmt->execute(array($campus->getcnpj()));
			$res = $pstmt->fetchAll();
			
			if(count($res)==0)
				return false;
			
			$cursos = array();
			foreach($res as $curso)
				$cursos[] = new Curso($curso['id'], $curso['nome'],  $campus);
			
			return $cursos;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            return false;
        }	
	}
   
}
