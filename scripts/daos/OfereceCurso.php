<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Curso.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Campus.php';

/**
 * Description of OfereceCurso
 *
 * @author Igor Alberte
 */
class OfereceCurso {
    
    private $_id;
    private $_turno;
    private $_curso;
    private $_campus;
    
    public function __construct($_id, $_turno, $_curso, $_campus) {
        $this->_id = $_id;
        $this->_turno = $_turno;
        $this->_curso = $_curso;
        $this->_campus = $_campus;
    }

    public function getid() {
        return $this->_id;
    }

    public function getturno() {
        return $this->_turno;
    }

    public function getcurso() {
        return $this->_curso;
    }

    public function getcampus() {
        return $this->_campus;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setturno($_turno) {
        $this->_turno= $_turno;
        return $this;
    }

    public function setcurso($_curso) {
        $this->_curso= $_curso;
        return $this;
    }

    public function setcampus($_campus) {
        $this->_campus= $_campus;
        return $this;
    }
    
}