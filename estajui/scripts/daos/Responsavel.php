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
    private $_aprovado;

    public function __construct($_email, $_nome, $_telefone, $_cargo, $_empresa, $_aprovado) {
        $this->_email = $_email;
        $this->_nome = $_nome;
        $this->_telefone = $_telefone;
        $this->_cargo = $_cargo;
        $this->_empresa = $_empresa;
        $this->_aprovado = $_aprovado;
    }

    public function getaprovado() {
        return $this->_aprovado;
    }

    public function setaprovado($_aprovado) {
        $this->_aprovado = $_aprovado;
        return $this;
    }

    public function getemail() {
        return $this->_email;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function gettelefone() {
        return $this->_telefone;
    }

    public function getcargo() {
        return $this->_cargo;
    }

    public function getempresa() {
        return $this->_empresa;
    }

    public function setemail($_email) {
        $this->_email = $_email;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function settelefone($_telefone) {
        $this->_telefone = $_telefone;
        return $this;
    }

    public function setcargo($_cargo) {
        $this->_cargo = $_cargo;
        return $this;
    }

    public function setempresa($_empresa) {
        $this->_empresa = $_empresa;
        return $this;
    }

}
