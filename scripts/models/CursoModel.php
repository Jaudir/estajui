<?php
require_once(dirname(__FILE__) . '/MainModel.php');

class CursoModel extends MainModel{
  private $_tabela = "curso";
  
  public function getCursoAluno($aluno){
        try{
            $this->loader->loadDAO('Curso');

            $stmt = $this->conn->prepare('SELECT curso.* FROM aluno JOIN aluno_estuda_curso ON aluno_estuda_curso.aluno_cpf=aluno.cpf JOIN curso ON curso.id=aluno_estuda_curso.cpf WHERE aluno.cpf = :cpf');
            $stmt->execute(array(':cpf' => $aluno->getcpf()));

            $cursos = $stmt->fetchAll();

            $cursosObj = array();
            if(count($cursos) > 0){
                foreach($cursos as $curso){
                    array_push($cursosObj, new Curso($curso['id'], $curso['nome'], $curso['turno'], $curso['campus']));
                }
                
                return $cursosObj;
            }
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
        return false;
    }
	 
	 public function read($id, $limite) {
        $this->loader->loadDAO('Curso');
        if ($limite == 0) {
            if ($id == null) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id");
                $pstmt->bindParam(':id', $id);
            }
        } else {
            if ($id == null) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id LIMIT :limite");
                $pstmt->bindParam(':id', $id);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
			
			$campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
            while ($row = $pstmt->fetch()) {		 
                $result[$cont] = new Curso($row["id"], $row["nome"],$row["turno"],$campusModel->read($row["campus_cnpj"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return false;
        }
    }

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
