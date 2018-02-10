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
    public function get_matricula() {
        return $this->_matricula;
    }

    public function get_semestre_inicio() {
        return $this->_semestre_inicio;
    }

    public function get_ano_inicio() {
        return $this->_ano_inicio;
    }

    public function get_curso() {
        return $this->_curso;
    }

    public function get_aluno() {
        return $this->_aluno;
    }

    public function set_matricula($_matricula) {
        $this->_matricula = $_matricula;
        return $this;
    }

    public function set_semestre_inicio($_semestre_inicio) {
        $this->_semestre_inicio = $_semestre_inicio;
        return $this;
    }

    public function set_ano_inicio($_ano_inicio) {
        $this->_ano_inicio = $_ano_inicio;
        return $this;
    }

    public function set_curso($_curso) {
        $this->_curso = $_curso;
        return $this;
    }

    public function set_aluno($_aluno) {
        $this->_aluno = $_aluno;
        return $this;
    }


}
