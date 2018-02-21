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
    private $_habilitação;
    private $_empresa;
    
    function __construct($_id, $_nome, $_cargo, $_habilitação, $_empresa) {
        $this->_id = $_id;
        $this->_nome = $_nome;
        $this->_cargo = $_cargo;
        $this->_habilitação = $_habilitação;
        $this->_empresa = $_empresa;
    }

    public function get_tabela(){
        return "supervisor";
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_nome() {
        return $this->_nome;
    }

    public function get_cargo() {
        return $this->_cargo;
    }

    public function get_habilitação() {
        return $this->_habilitação;
    }

    public function get_empresa() {
        return $this->_empresa;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_nome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function set_cargo($_cargo) {
        $this->_cargo = $_cargo;
        return $this;
    }

    public function set_habilitação($_habilitação) {
        $this->_habilitação = $_habilitação;
        return $this;
    }

    public function set_empresa($_empresa) {
        $this->_empresa = $_empresa;
        return $this;
    }


    
}
