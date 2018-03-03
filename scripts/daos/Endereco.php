<?php

/**
 * Description of Endereco
 *
 * @author gabriel Lucas
 */
class Endereco {

    private $_id;
    private $_logradouro;
    private $_bairro;
    private $_numero;
    private $_complemento;
    private $_cidade;
    private $_uf;
    private $_cep;
    private $_sala;

    public function __construct($_id, $_logradouro, $_bairro, $_numero, $_complemento, $_cidade, $_uf, $_cep, $_sala) {
        $this->_id = $_id;
        $this->_logradouro = $_logradouro;
        $this->_bairro = $_bairro;
        $this->_numero = $_numero;
        $this->_complemento = $_complemento;
        $this->_cidade = $_cidade;
        $this->_uf = $_uf;
        $this->_cep = $_cep;
        $this->_sala = $_sala;
    }

    public function getid() {
        return $this->_id;
    }

    public function getsala() {
        return $this->_sala;
    }

    public function setsala($_sala) {
        return $this->_sala = $_sala;
    }

    public function getlogradouro() {
        return $this->_logradouro;
    }

    public function getbairro() {
        return $this->_bairro;
    }

    public function getnumero() {
        return $this->_numero;
    }

    public function getcomplemento() {
        return $this->_complemento;
    }

    public function getcidade() {
        return $this->_cidade;
    }

    public function getuf() {
        return $this->_uf;
    }

    public function getcep() {
        return $this->_cep;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setlogradouro($_logradouro) {
        $this->_logradouro = $_logradouro;
        return $this;
    }

    public function setbairro($_bairro) {
        $this->_bairro = $_bairro;
        return $this;
    }

    public function setnumero($_numero) {
        $this->_numero = $_numero;
        return $this;
    }

    public function setcomplemento($_complemento) {
        $this->_complemento = $_complemento;
        return $this;
    }

    public function setcidade($_cidade) {
        $this->_cidade = $_cidade;
        return $this;
    }

    public function setuf($_uf) {
        $this->_uf = $_uf;
        return $this;
    }

    public function setcep($_cep) {
        $this->_cep = $_cep;
        return $this;
    }

}
