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
    
    public function __construct($_id, $_nome) {
        $this->_id = $_id;
        $this->_nome = $_nome;
    }

    public function getid() {
        return $this->_id;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }
    
}
