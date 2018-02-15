<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class CursoModel extends MainModel{
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
}