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
    private $_turno;
    private $_campus;
    
    public function __construct($_id, $_nome, $_turno, $_campus) {
        $this->_id = $_id;
        $this->_nome = $_nome;
        $this->_turno = $_turno;
        $this->_campus = $_campus;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_nome() {
        return $this->_nome;
    }

    public function get_turno() {
        return $this->_turno;
    }

    public function get_campus() {
        return $this->_campus;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_nome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function set_turno($_turno) {
        $this->_turno = $_turno;
        return $this;
    }

    public function set_campus($_campus) {
        $this->_campus = $_campus;
        return $this;
    }


    
}
