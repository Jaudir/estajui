<?php
require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Leciona.php";

class LecionaModel extends MainModel {
	 private $_tabela = "leciona";
	 
	 public function read($siape, $limite) {
        if ($limite == 0) {
            if ($siape == null) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE po_siape = :siape");
                $pstmt->bindParam(':siape', $siape);
            }
        } else {
            if ($siape == null) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE po_siape = :siape LIMIT :limite");
                $pstmt->bindParam(':siape', $siape);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
			
			$funcionarioModel = $this->loader->loadModel("FuncionarioModel","FuncionarioModel");
			$ofereceCursoModel = $this->loader->loadModel("OfereceCursoModel","OfereceCursoModel");
            while ($row = $pstmt->fetch()) {
				$f = $funcionarioModel->read($row["po_siape"], 1)[0];
				
				$funcionario = new Funcionario($f->getlogin(), $f->getsenha(), $f->gettipo(), $f->getsiape(), $f->getnome(), $f->ispo(),
								 $f->isoe(), $f->isce(), $f->issra(), $f->isroot(), $f->getformacao(), $f->isprivilegio(),$f->getCampus() );
				
				$o = $ofereceCursoModel->read($row["oferece_curso_id"], 1)[0];
				$ofereceCurso = new OfereceCurso($o->getid(), $o->getturno(), $o->getcurso(), $o->getcampus());
			
				$aux = new Leciona($funcionario, $ofereceCurso);
                //$result[$cont] = $aux;
				array_push($result,$aux);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return false;
        }
    }
}

