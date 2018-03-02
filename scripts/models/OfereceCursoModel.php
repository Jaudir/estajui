<?php
require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Leciona.php";

class OfereceCursoModel extends MainModel {
	 private $_tabela = "oferece_curso";
	 
	 public function read($id, $limite) {
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
			
			$cursoModel = $this->loader->loadModel("CursoModel", "CursoModel");
            $campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
            while ($row = $pstmt->fetch()) {
                $curso = $cursoModel->read($row["curso_id"], 1)[0];
				
                $result[$cont] = new OfereceCurso($row["id"], $row["turno"], $curso, $campusModel->read($row["campus_cnpj"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return false;
        }
    }
}

