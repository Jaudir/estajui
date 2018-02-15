<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Estagio.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Funcionario.php';

/**
 * Description of ComentarioPE
 *
 * @author gabriel Lucas
 */
class ComentarioPE {
    
    private $_id;
    private $_data;
    private $_descricao;
    private $_correcao;
    private $_funcionario;
    private $_estagio;
    
    public function __construct($_id, $_data, $_descricao, $_correcao, $_funcionario, $_estagio) {
        $this->_id = $_id;
        $this->_data = $_data;
        $this->_descricao = $_descricao;
        $this->_correcao = $_correcao;
        $this->_funcionario = $_funcionario;
        $this->_estagio = $_estagio;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_data() {
        return $this->_data;
    }

    public function get_descricao() {
        return $this->_descricao;
    }

    public function get_correcao() {
        return $this->_correcao;
    }

    public function get_funcionario() {
        return $this->_funcionario;
    }

    public function get_estagio() {
        return $this->_estagio;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_data($_data) {
        $this->_data = $_data;
        return $this;
    }

    public function set_descricao($_descricao) {
        $this->_descricao = $_descricao;
        return $this;
    }

    public function set_correcao($_correcao) {
        $this->_correcao = $_correcao;
        return $this;
    }

    public function set_funcionario($_funcionario) {
        $this->_funcionario = $_funcionario;
        return $this;
    }

    public function set_estagio($_estagio) {
        $this->_estagio = $_estagio;
        return $this;
    }


    
}
