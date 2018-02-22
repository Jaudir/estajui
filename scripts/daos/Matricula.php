<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Aluno.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Curso.php';

/**
 * Description of Matricula
 *
 * @author gabriel Lucas
 */
class Matricula {

    private $_matricula;
    private $_semestre_inicio;
    private $_ano_inicio;
    private $_curso;
    private $_aluno;

    public function __construct($_matricula, $_semestre_inicio, $_ano_inicio, $_curso, $_aluno) {
        $this->_matricula = $_matricula;
        $this->_semestre_inicio = $_semestre_inicio;
        $this->_ano_inicio = $_ano_inicio;
        $this->_curso = $_curso;
        $this->_aluno = $_aluno;
    }

    public function getmatricula() {
        return $this->_matricula;
    }

    public function getsemestre_inicio() {
        return $this->_semestre_inicio;
    }

    public function getano_inicio() {
        return $this->_ano_inicio;
    }

    public function getcurso() {
        return $this->_curso;
    }

    public function getaluno() {
        return $this->_aluno;
    }

    public function setmatricula($_matricula) {
        $this->_matricula = $_matricula;
        return $this;
    }

    public function setsemestre_inicio($_semestre_inicio) {
        $this->_semestre_inicio = $_semestre_inicio;
        return $this;
    }

    public function setano_inicio($_ano_inicio) {
        $this->_ano_inicio = $_ano_inicio;
        return $this;
    }

    public function setcurso($_curso) {
        $this->_curso = $_curso;
        return $this;
    }

    public function setaluno($_aluno) {
        $this->_aluno = $_aluno;
        return $this;
    }

}
