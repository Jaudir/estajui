<?php

class AlunoEstudaCurso{
    private $matricula;
    private $semestre_inicio;
    private $ano_inicio;
    private $oferece_curso;
    private $aluno;

    public function __construct($matricula, $semestre_inicio, $ano_inicio, $oferece_curso, $aluno){
        $this->matricula = $matricula;
        $this->semestre_inicio = $semestre_inicio;
        $this->oferece_curso = $oferece_curso;
        $this->aluno = $aluno;
    }

    public function setmatricula($matricula){
        $this->matricula = $matricula;
        return $this;
    }

    public function getmatricula(){
        return $this->matricula;
    }

    public function setsemestre_inicio($semestre_inicio){
        $this->semestre_inicio = $semestre_inicio;
        return $this;
    }

    public function getsemestre_inicio(){
        return $this->semestre_inicio;
    }

    public function setano_inicio($ano_inicio){
        $this->ano_inicio = $ano_inicio;
        return $this;
    }

    public function getano_inicio(){
        return $this->ano_inicio;
    }

    public function setoferece_curso($oferece_curso){
        $this->oferece_curso = $oferece_curso;
        return $this;
    }

    public function getoferece_curso(){
        return $this->oferece_curso;
    }

    public function setaluno($aluno){
        $this->aluno = $aluno;
        return $this;
    }

    public function getaluno(){
        return $this->aluno;
    }
}