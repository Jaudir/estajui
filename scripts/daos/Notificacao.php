<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Status.php';

/**
 * Description of Notificacao
 *
 * @author gabriel Lucas
 */
class Notificacao {
    
    private $_id;
    private $_lida;
    private $_status;
    private $_usuario;
    
    public function __construct($_id, $_lida, $_status, $_usuario) {
        $this->_id = $_id;
        $this->_lida = $_lida;
        $this->_status = $_status;
        $this->_usuario = $_usuario;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_lida() {
        return $this->_lida;
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

    public function set_lida($_lida) {
        $this->_lida = $_lida;
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
