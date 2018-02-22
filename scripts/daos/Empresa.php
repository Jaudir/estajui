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
        $this->_razaosocial = $_razaosocial;
    }

    public function get_cnpj() {
        return $this->_cnpj;
    }

    public function get_nome() {
        return $this->_nome;
    }

    public function get_telefone() {
        return $this->_telefone;
    }

    public function get_fax() {
        return $this->_fax;
    }

    public function get_nregistro() {
        return $this->_nregistro;
    }

    public function get_conselhofiscal() {
        return $this->_conselhofiscal;
    }

    public function get_endereco() {
        return $this->_endereco;
    }

    public function get_responsavel() {
        return $this->_responsavel;
    }

    public function set_cnpj($_cnpj) {
        $this->_cnpj = $_cnpj;
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

    public function set_fax($_fax) {
        $this->_fax = $_fax;
        return $this;
    }

    public function set_nregistro($_nregistro) {
        $this->_nregistro = $_nregistro;
        return $this;
    }

    public function set_conselhofiscal($_conselhofiscal) {
        $this->_conselhofiscal = $_conselhofiscal;
        return $this;
    }

    public function set_endereco($_endereco) {
        $this->_endereco = $_endereco;
        return $this;
    }

    public function set_responsavel($_responsavel) {
        $this->_responsavel = $_responsavel;
        return $this;
    }

    public function set_conveniada($_conveniada){
        $this->_razaosocial = $_razaosocial;
        return $this;
    }

    public function get_conveniada(){
        return $this->_conveniada;
    }

    public function set_razaosocial($_razaosocial){
        $this->_razaosocial = $_razaosocial;
        return $this;
    }

    public function get_razaosocial(){
        return $this->_razaosocial;
    }
}
