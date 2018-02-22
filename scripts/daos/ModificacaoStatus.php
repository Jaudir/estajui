<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Status.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Estagio.php';

/**
 * Description of ModificacaoStatus
 *
 * @author gabriel Lucas
 */
class ModificacaoStatus {
    
    private $_id;
    private $_data;
    private $_estagio;
    private $_status;
    private $_usuario;
    
    public function __construct($_id, $_data, $_estagio, $_status, $_usuario) {
        $this->_id = $_id;
        $this->_data = $_data;
        $this->_estagio = $_estagio;
        $this->_status = $_status;
        $this->_usuario = $_usuario;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_data() {
        return $this->_data;
    }

    public function get_estagio() {
        return $this->_estagio;
    }

    public function get_status() {
        return $this->_status;
    }

    public function get_usuario() {
        return $this->_usuario;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_data($_data) {
        $this->_data = $_data;
        return $this;
    }

    public function set_estagio($_estagio) {
        $this->_estagio = $_estagio;
        return $this;
    }

    public function set_status($_status) {
        $this->_status = $_status;
        return $this;
    }

    public function set_usuario($_usuario) {
        $this->_usuario = $_usuario;
        return $this;
    }


}
