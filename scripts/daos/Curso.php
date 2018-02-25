<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Campus.php';

/**
 * Description of Curso
 *
 * @author gabriel Lucas
 */
class Curso {
    
    private $_id;
    private $_nome;
    
    public function __construct($_id, $_nome, $_turno, $_campus) {
        $this->_id = $_id;
        $this->_nome = $_nome;
        $this->_turno = $_turno;
        $this->_campus = $_campus;
    }

    public function getid() {
        return $this->_id;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function getturno() {
        return $this->_turno;
    }

    public function getcampus() {
        return $this->_campus;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function setturno($_turno) {
        $this->_turno = $_turno;
        return $this;
    }

    public function setcampus($_campus) {
        $this->_campus = $_campus;
        return $this;
    }


    
}
