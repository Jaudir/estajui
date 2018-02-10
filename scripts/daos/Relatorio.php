<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Estagio.php';

/**
 * Description of relatorio
 *
 * @author gabriel Lucas
 */
class Relatorio {
    
    private $_id;
    private $_arquivo;
    private $_data_envio;
    private $_estagio;
    
    public function __construct($_id, $_arquivo, $_data_envio, $_estagio) {
        $this->_id = $_id;
        $this->_arquivo = $_arquivo;
        $this->_data_envio = $_data_envio;
        $this->_estagio = $_estagio;
    }
    
    public function get_id() {
        return $this->_id;
    }

    public function get_arquivo() {
        return $this->_arquivo;
    }

    public function get_data_envio() {
        return $this->_data_envio;
    }

    public function get_estagio() {
        return $this->_estagio;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_arquivo($_arquivo) {
        $this->_arquivo = $_arquivo;
        return $this;
    }

    public function set_data_envio($_data_envio) {
        $this->_data_envio = $_data_envio;
        return $this;
    }

    public function set_estagio($_estagio) {
        $this->_estagio = $_estagio;
        return $this;
    }



}
