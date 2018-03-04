<?php

/**
 * Description of Apolice
 *
 * @author gabriel Lucas
 */
class Apolice {
    
    private $_numero;
    private $_seguradora;
    
    public function __construct($_numero, $_seguradora) {
        $this->_numero = $_numero;
        $this->_seguradora = $_seguradora;
    }

    public function getnumero() {
        return $this->_numero;
    }

    public function getseguradora() {
        return $this->_seguradora;
    }

    public function setnumero($_numero) {
        $this->_numero = $_numero;
        return $this;
    }

    public function setseguradora($_seguradora) {
        $this->_seguradora = $_seguradora;
        return $this;
    }
    
}
