<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Campus.php';

/**
 * Representação de um usuário para o sistema.
 *
 * @author gabriel Lucas
 */
class Funcionario extends Usuario {

    private $_siape;
    private $_nome;
    private $_po;
    private $_oe;
    private $_ce;
    private $_sra;
    private $_root;
    private $_formacao;
    private $_privilegio;
    private $_campus;

    public function __construct($login, $senha, $tipo, $_siape, $_nome, $_po, $_oe, $_ce, $_sra, $_root, $_formacao, $_privilegio, $_campus) {
        parent::__construct($login, $senha, $tipo);
        $this->_siape = $_siape;
        $this->_nome = $_nome;
        $this->_po = $_po;
        $this->_oe = $_oe;
        $this->_ce = $_ce;
        $this->_sra = $_sra;
        $this->_root = $_root;
        $this->_formacao = $_formacao;
        $this->_privilegio = $_privilegio;
        $this->_campus = $_campus;
    }

    public function getsiape() {
        return $this->_siape;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function ispo() {
        return $this->_po;
    }

    public function isoe() {
        return $this->_oe;
    }

    public function isce() {
        return $this->_ce;
    }

    public function issra() {
        return $this->_sra;
    }

    public function isroot() {
        return $this->_root;
    }

    public function getformacao() {
        return $this->_formacao;
    }

    public function isprivilegio() {
        return $this->_privilegio;
    }

    public function getcampus() {
        return $this->_campus;
    }

    public function setsiape($_siape) {
        $this->_siape = $_siape;
        return $this;
    }

    public function setnome($_nome) {
        $this->_nome = $_nome;
        return $this;
    }

    public function setpo($_po) {
        $this->_po = $_po;
        return $this;
    }

    public function setoe($_oe) {
        $this->_oe = $_oe;
        return $this;
    }

    public function setce($_ce) {
        $this->_ce = $_ce;
        return $this;
    }

    public function setsra($_sra) {
        $this->_sra = $_sra;
        return $this;
    }

    public function setroot($_root) {
        $this->_root = $_root;
        return $this;
    }

    public function setformacao($_formacao) {
        $this->_formacao = $_formacao;
        return $this;
    }

    public function setprivilegio($_privilegio) {
        $this->_privilegio = $_privilegio;
        return $this;
    }

    public function setcampus($_campus) {
        $this->_campus = $_campus;
        return $this;
    }

}
