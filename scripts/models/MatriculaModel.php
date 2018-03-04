<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Matricula.php";

class MatriculaModel extends MainModel {

    private $_tabela = "aluno_estuda_curso";

    public function create(Matricula $matricula) {
        $pstmt = $this->conn->prepare("INSERT INTO " . $this->_tabela . " (matricula, semestre_inicio, ano_inicio, oferece_curso_id, aluno_cpf) VALUES(?, ?, ?, ?, ?)");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($matricula->getmatricula(), $matricula->getsemestre_inicio(), $matricula->getano_inicio(), $matricula->oferta()->getid(), $matricula->getaluno()->getcpf()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function read($matricula, $limite) {
        if ($limite == 0) {
            if ($matricula == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE matricula LIKE :matricula");
                $pstmt->bindParam(':matricula', $matricula);
            }
        } else {
            if ($matricula == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE matricula LIKE :matricula LIMIT :limite");
                $pstmt->bindParam(':matricula', $matricula);
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
                $oferececursoModel = $this->loader->loadModel("OfereceCursoModel", "OfereceCursoModel");
                $alunoModel = $this->loader->loadModel("AlunoModel", "AlunoModel");
                $result[$cont] = new Matricula($row["matricula"], $row["semestre_inicio"], $row["ano_inicio"], $oferececursoModel->read($row["oferece_curso_id"], 1)[0], $alunoModel->read($row["aluno_cpf"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyaluno(Aluno $aluno, $limite) {
        if ($limite == 0) {
            if ($aluno == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE aluno_cpf LIKE :aluno_cpf");
                $pstmt->bindParam(':aluno_cpf', $aluno->getcpf());
            }
        } else {
            if ($aluno == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE aluno_cpf LIKE :aluno_cpf LIMIT :limite");
                $pstmt->bindParam(':aluno_cpf', $aluno->getcpf());
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
                $oferececursoModel = $this->loader->loadModel("OfereceCursoModel", "OfereceCursoModel");
                $result[$cont] = new Matricula($row["matricula"], $row["semestre_inicio"], $row["ano_inicio"], $oferececursoModel->read($row["oferece_curso_id"], 1)[0], $aluno);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbycurso(Curso $curso, $limite) {
        if ($limite == 0) {
            if ($curso == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE curso_id LIKE :curso_id");
                $pstmt->bindParam(':curso_id', $curso->getid());
            }
        } else {
            if ($curso == NULL) {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE curso_id LIKE :curso_id LIMIT :limite");
                $pstmt->bindParam(':curso_id', $curso->getid());
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
                $alunoModel = $this->loader->loadModel("AlunoModel", "AlunoModel");
                $result[$cont] = new Matricula($row["matricula"], $row["semestre_inicio"], $row["ano_inicio"], $curso, $alunoModel->read($row["aluno_cpf"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Matricula $matricula) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET semestre_inicio=?, ano_inicio=?, oferece_curso_id=?, aluno_cpf=? WHERE matricula = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($matricula->getsemestre_inicio(), $matricula->getano_inicio(), $matricula->getoferta()->getid(), $matricula->getaluno()->getcpf(), $matricula->getmatricula()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function updatematricula(Matricula $matricula, $matricula_anterior) {
        $pstmt = $this->conn->prepare("UPDATE " . $this->_tabela . " SET matricula=?, semestre_inicio=?, ano_inicio=?, oferece_curso_id=?, aluno_cpf=? WHERE matricula = ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($matricula->getmatricula(), $matricula->getsemestre_inicio(), $matricula->getano_inicio(), $matricula->getoferta()->getid(), $matricula->getaluno()->getcpf(), $matricula_anterior));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Matricula $matricula) {
        $pstmt = $this->conn->prepare("DELETE from " . $this->_tabela . " WHERE matricula LIKE ?");
        try {
            $this->conn->beginTransaction();
            $pstmt->execute(array($matricula->getmatricula()));
            $this->conn->commit();
            return 0;
        } catch (PDOExecption $e) {
            $this->conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}
