<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Estagio.php';

/**
 * Description of Apolice
 *
 * @author gabriel Lucas
 */
class Apolice {
    
    private $_numero;
    private $_seguradora;
    private $_estagio;
    
    public function __construct($_numero, $_seguradora, $_estagio) {
        $this->_numero = $_numero;
        $this->_seguradora = $_seguradora;
        $this->_estagio = $_estagio;
    }

    public function get_numero() {
        return $this->_numero;
    }

    public function get_seguradora() {
        return $this->_seguradora;
    }

    public function get_estagio() {
        return $this->_estagio;
    }

    public function set_numero($_numero) {
        $this->_numero = $_numero;
        return $this;
    }

    public function set_seguradora($_seguradora) {
        $this->_seguradora = $_seguradora;
        return $this;
    }

    public function set_estagio($_estagio) {
        $this->_estagio = $_estagio;
        return $this;
    }


    
}
