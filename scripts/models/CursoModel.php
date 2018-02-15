<?php
require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Curso.php";

class CursoModel extends MainModel {
	 private $_tabela = "curso";
	 
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

