<?php

require_once(dirname(__FILE__) . '/MainModel.php');

class AlunoEstudaCursoModel extends MainModel{
    public function buscarPorAlunoCursoCampus($aluno, $curso, $campus){
        try{
            $this->loader->loadDao('AlunoEstudaCurso');
            
            $stmt = $this->conn->prepare('SELECT aluno_estuda_curso.* FROM aluno_estuda_curso JOIN oferece_curso ON oferece_curso.id = oferece_curso_id AND oferece_curso.curso_id = :curso AND oferece_curso.campus_cnpj = :campus WHERE aluno_cpf = :cpf');
            $stmt->execute(array(':cpf' => $aluno->getcpf(), ':curso' => $curso->getid(), ':campus' => $campus->getcnpj()));
            
            $res = $stmt->fetchAll();

            if(count($res) == 1){
                $res = $res[0];
                return new AlunoEstudaCurso(
                    $res['matricula'], 
                    $res['semestre_inicio'], 
                    $res['ano_inicio'], 
                    null,
                    null
                );
            }
            return false;
        }catch(PDOException $ex){
            Log::LogPDOError($ex);
            return false;
        }
    }
}