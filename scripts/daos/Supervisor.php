<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Empresa.php';

/**
 * Description of Supervisor
 *
 * @author gabriel Lucas
 */
class Supervisor {
    
    private $_id;
    private $_nome;
    private $_cargo;
    private $_habilitacao;
    private $_empresa;
    
    public function __construct($_id, $_nome, $_cargo, $_habilitacao, $_empresa) {
        $this->_id = $_id;
        $this->_nome = $_nome;
        $this->_cargo = $_cargo;
        $this->_habilitacao = $_habilitacao;
        $this->_empresa = $_empresa;
    }
    
    public function getid() {
        return $this->_id;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function getcargo() {
        return $this->_cargo;
    }

    public function gethabilitacao() {
        return $this->_habilitacao;
    }

    public function getempresa() {
        return $this->_empresa;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function setcargo($_cargo) {
        $this->_cargo = $_cargo;
        return $this;
    }

    public function sethabilitacao($_habilitacao) {
        $this->_habilitacao = $_habilitacao;
        return $this;
    }

    public function setempresa($_empresa) {
        $this->_empresa = $_empresa;
        return $this;
    }




}
