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
}

<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Curso.php";

class CursoModel extends MainModel {

    private $_tabela = "curso";

    public function create(Curso $curso) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (nome, turno, campus_cnpj) VALUES(?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($curso->getnome(), $curso->getturno(), $curso->getcampus()->getcnpj()));
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            return $id;
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
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id");
                $pstmt->bindParam(':id', $id);
            }
        } else {
            if ($id == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE id = :id LIMIT :limite");
                $pstmt->bindParam(':id', $id);
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
                $campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
                $result[$cont] = new Curso($row["id"], $row["nome"], $row["nome"], $row["turno"], $campusModel->read($row["campus"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbycampus(Campus $campus, $limite) {
        if ($limite == 0) {
            if ($campus == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE campus_cnpj = :campus_cnpj");
                $pstmt->bindParam(':campus_cnpj', $campus->getcnpj());
            }
        } else {
            if ($campus == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE campus_cnpj = :campus_cnpj LIMIT :limite");
                $pstmt->bindParam(':campus_cnpj', $campus->getcnpj());
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
                $result[$cont] = new Curso($row["id"], $row["nome"], $row["nome"], $row["turno"], $campus);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Curso $curso) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->$_tabela . " SET nome=?, turno=?, campus_cnpj=? WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($curso->getnome(), $curso->getturno(), $curso->getcampus()->getcnpj(), $curso->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Curso $curso) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->$_tabela . " WHERE id = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($curso->getid()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
