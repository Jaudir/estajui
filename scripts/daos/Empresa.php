<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Responsavel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Endereco.php';

/**
 * Description of Empresa
 *
 * @author gabriel Lucas
 */
class Empresa {
    private $_cnpj;
    private $_nome;
    private $_telefone;
    private $_fax;
    private $_nregistro;
    private $_conselhofiscal;
    private $_endereco;
    private $_responsavel;
    private $_conveniada;
    private $_razaosocial;

    public function __construct($_cnpj, $_nome, $_telefone, $_fax, $_nregistro, $_conselhofiscal, $_endereco, $_responsavel, $_conveniada, $_razaosocial) {
        $this->_cnpj = $_cnpj;
        $this->_nome = $_nome;
        $this->_telefone = $_telefone;
        $this->_fax = $_fax;
        $this->_nregistro = $_nregistro;
        $this->_conselhofiscal = $_conselhofiscal;
        $this->_endereco = $_endereco;
        $this->_responsavel = $_responsavel;
        $this->_conveniada = $_conveniada;
        $this->_razaosocial = $_razao_social;
    }

    public function getresponsavel() {
        return $this->_responsavel;
    }

    public function setresponsavel($_responsavel) {
        $this->_responsavel = $_responsavel;
        return $this;
    }

    public function getcnpj() {
        return $this->_cnpj;
    }

    public function getnome() {
        return $this->_nome;
    }

    public function gettelefone() {
        return $this->_telefone;
    }

    public function getfax() {
        return $this->_fax;
    }

    public function getnregistro() {
        return $this->_nregistro;
    }

    public function getconselhofiscal() {
        return $this->_conselhofiscal;
    }

    public function getendereco() {
        return $this->_endereco;
    }

    public function setcnpj($_cnpj) {
        $this->_cnpj = $_cnpj;
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

    public function setfax($_fax) {
        $this->_fax = $_fax;
        return $this;
    }

    public function setnregistro($_nregistro) {
        $this->_nregistro = $_nregistro;
        return $this;
    }

    public function setconselhofiscal($_conselhofiscal) {
        $this->_conselhofiscal = $_conselhofiscal;
        return $this;
    }

    public function setendereco($_endereco) {
        $this->_endereco = $_endereco;
        return $this;
    }

    public function setconveniada($_conveniada) {
        $this->_razaosocial = $_razaosocial;
        return $this;
    }

    public function getconveniada() {
        return $this->_conveniada;
    }

    public function setrazaosocial($_razaosocial) {
        $this->_razaosocial = $_razaosocial;
        return $this;
    }

    public function getrazaosocial() {
        return $this->_razaosocial;
    }

}
