<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Empresa.php';

/**
 * Description of responsavel
 *
 * @author gabriel Lucas
 */
class Responsavel {
    
    private $_email;
    private $_nome;
    private $_telefone;
    private $_cargo;
    private $_empresa;
    
    public function __construct($_email, $_nome, $_telefone, $_cargo, $_empresa) {
        $this->_email = $_email;
        $this->_nome = $_nome;
        $this->_telefone = $_telefone;
        $this->_cargo = $_cargo;
        $this->_empresa = $_empresa;
    }

    public function get_email() {
        return $this->_email;
    }

    public function get_nome() {
        return $this->_nome;
    }

    public function get_telefone() {
        return $this->_telefone;
    }

    public function get_cargo() {
        return $this->_cargo;
    }

    public function get_empresa() {
        return $this->_empresa;
    }

    public function set_email($_email) {
        $this->_email = $_email;
        return $this;
    }

    public function set_nome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function set_telefone($_telefone) {
        $this->_telefone = $_telefone;
        return $this;
    }

    public function set_cargo($_cargo) {
        $this->_cargo = $_cargo;
        return $this;
    }

    public function set_empresa($_empresa) {
        $this->_empresa = $_empresa;
        return $this;
    }


}
