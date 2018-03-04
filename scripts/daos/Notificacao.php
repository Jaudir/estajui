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
    private $_modificacao_status;
    private $_justificativa;
    
    public function __construct($_id, $_lida, $_modificacao_status, $_justificativa) {
        $this->_id = $_id;
        $this->_lida = $_lida;
        $this->_modificacao_status = $_modificacao_status;
        $this->_justificativa = $_justificativa;
    }
    
    public function getid() {
        return $this->_id;
    }

    public function getlida() {
        return $this->_lida;
    }

    public function getmodificacao_status() {
        return $this->_modificacao_status;
    }

    public function getjustificativa() {
        return $this->_justificativa;
    }

    public function setid($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function setlida($_lida) {
        $this->_lida = $_lida;
        return $this;
    }

    public function setmodificacao_status($_modificacao_status) {
        $this->_modificacao_status = $_modificacao_status;
        return $this;
    }

    public function setjustificativa($_justificativa) {
        $this->_justificativa = $_justificativa;
        return $this;
    }

}
