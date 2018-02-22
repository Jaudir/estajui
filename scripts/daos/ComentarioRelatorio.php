<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Funcionario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/estajui/scripts/daos/Relatorio.php';

/**
 * Description of ComentarioRelatorio
 *
 * @author gabriel Lucas
 */
class ComentarioRelatorio {
    
    private $_id;
    private $_data;
    private $_descricao;
    private $_relatorio;
    private $_funcionario;
    
    public function __construct($_id, $_data, $_descricao, $_relatorio, $_funcionario) {
        $this->_id = $_id;
        $this->_data = $_data;
        $this->_descricao = $_descricao;
        $this->_relatorio = $_relatorio;
        $this->_funcionario = $_funcionario;
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

    public function get_relatorio() {
        return $this->_relatorio;
    }

    public function get_funcionario() {
        return $this->_funcionario;
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

    public function set_relatorio($_relatorio) {
        $this->_relatorio = $_relatorio;
        return $this;
    }

    public function set_funcionario($_funcionario) {
        $this->_funcionario = $_funcionario;
        return $this;
    }


    
}
